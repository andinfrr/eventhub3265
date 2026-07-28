<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\CertificateMail;

class CheckoutController extends Controller
{

    public function create(Event $event)
    {
        $categories = Category::all();

        $user = auth()->user();

        return view('checkout.create', compact(
            'event',
            'categories',
            'user'
        ));
    }



    public function applyCoupon(Request $request, Event $event)
    {
        $request->validate([
            'coupon' => 'required|string'
        ]);


        $coupon = Coupon::where('code', strtoupper($request->coupon))->first();


        if (!$coupon) {
            return back()->with('coupon_error', 'Kode voucher tidak ditemukan.');
        }


        if (!$coupon->status) {
            return back()->with('coupon_error', 'Voucher sudah tidak aktif.');
        }


        if ($coupon->expired_at && $coupon->expired_at < now()) {
            return back()->with('coupon_error', 'Voucher sudah kedaluwarsa.');
        }


        if ($coupon->used >= $coupon->max_usage) {
            return back()->with('coupon_error', 'Kuota voucher sudah habis.');
        }



        $subtotal = $event->price + 5000;



        if ($coupon->discount_type == 'percent') {

            $discount = ($subtotal * $coupon->discount_value) / 100;

        } else {

            $discount = $coupon->discount_value;

        }



        if ($discount > $subtotal) {
            $discount = $subtotal;
        }



        $finalPrice = $subtotal - $discount;



        session([
            'coupon_id'       => $coupon->id,
            'coupon_code'     => $coupon->code,
            'discount_amount' => $discount,
            'final_price'     => $finalPrice,
        ]);



        return back()->with(
            'coupon_success',
            'Voucher berhasil diterapkan.'
        );
    }




    public function store(Request $request, Event $event)
    {

        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);



        if ($event->stock <= 0) {

            return back()->with(
                'error',
                'Mohon maaf, tiket untuk acara ini sudah habis.'
            );

        }



        $orderId = 'TRX-' . time() . '-' . Str::random(5);



        $totalPrice = session(
            'final_price',
            $event->price + 5000
        );



        $transaction = Transaction::create([

            'organization_id' => $event->organization_id,

            'event_id' => $event->id,

            'order_id' => $orderId,

            'customer_name' => $request->customer_name,

            'customer_email' => $request->customer_email,

            'customer_phone' => $request->customer_phone,

            'total_price' => $totalPrice,

            'status' => 'pending',

            'coupon_code' => session('coupon_code'),

        ]);




        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');

        \Midtrans\Config::$isProduction = false;

        \Midtrans\Config::$isSanitized = true;

        \Midtrans\Config::$is3ds = true;




        $params = [

            'transaction_details' => [

                'order_id' => $orderId,

                'gross_amount' => $totalPrice,

            ],


            'customer_details' => [

                'first_name' => $request->customer_name,

                'email' => $request->customer_email,

                'phone' => $request->customer_phone,

            ],

        ];




        try {


            $snapToken = \Midtrans\Snap::getSnapToken($params);



            $transaction->update([

                'snap_token' => $snapToken

            ]);



            session()->forget([

                'coupon_id',

                'coupon_code',

                'discount_amount',

                'final_price'

            ]);



            return redirect()->route(
                'checkout.payment',
                $transaction->order_id
            );



        } catch (\Exception $e) {


            return back()->with(
                'error',
                $e->getMessage()
            );


        }

    }





    public function payment($order_id)
    {

        $categories = Category::all();


        $transaction = Transaction::with('event')
            ->where('order_id', $order_id)
            ->firstOrFail();



        return view(
            'checkout.payment',
            compact(
                'transaction',
                'categories'
            )
        );

    }






    public function success($order_id)
    {

        $categories = Category::all();



        $transaction = Transaction::with('event')
            ->where('order_id', $order_id)
            ->firstOrFail();




        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');

        \Midtrans\Config::$isProduction = false;

        \Midtrans\Config::$isSanitized = true;

        \Midtrans\Config::$is3ds = true;




        try {


            $status = \Midtrans\Transaction::status($order_id);



            $trx_status = is_array($status)

                ? ($status['transaction_status'] ?? '')

                : ($status->transaction_status ?? '');





            if (in_array($trx_status, ['settlement','capture'])) {



                if (strtolower($transaction->status) == 'pending') {



                    // Update transaksi sukses
                    $transaction->update([

                        'status' => 'success'

                    ]);





                    // Kirim E-Certificate
                    try {


                        Mail::to($transaction->customer_email)

                            ->send(
                                new CertificateMail($transaction)
                            );


                    } catch (\Exception $e) {


                        Log::error(
                            'Gagal kirim certificate: '
                            .$e->getMessage()
                        );


                    }





                    // Tambah penggunaan voucher
                    if ($transaction->coupon_code) {


                        Coupon::where(
                            'code',
                            $transaction->coupon_code
                        )->increment('used');


                    }





                    // Kurangi stok event
                    if ($transaction->event && $transaction->event->stock > 0) {


                        $transaction->event->decrement('stock');



                        // Kirim E-Ticket
                        try {


                            Mail::to(
                                $transaction->customer_email
                            )->send(
                                new \App\Mail\EventTicketMail($transaction)
                            );



                        } catch (\Exception $e) {


                            Log::error(
                                'Gagal kirim E-Ticket: '
                                .$e->getMessage()
                            );


                        }


                    }



                }


            }





        } catch (\Exception $e) {


            return redirect()
                ->route('home')
                ->with(
                    'error',
                    'Transaksi gagal diproses.'
                );


        }





        return view(
            'checkout.success',
            compact(
                'transaction',
                'categories'
            )
        );

    }

}