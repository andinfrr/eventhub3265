<?php

namespace App\Mail;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CertificateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;


    /**
     * Create a new message instance.
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }


    /**
     * Build the message.
     */
    public function build()
    {

        $pdf = Pdf::loadView(
            'certificate.pdf',
            [
                'transaction' => $this->transaction
            ]
        );


        return $this
            ->subject('E-Certificate EventHub')
            ->view('emails.certificate')
            ->attachData(
                $pdf->output(),
                'certificate-'.$this->transaction->order_id.'.pdf',
                [
                    'mime' => 'application/pdf'
                ]
            );

    }
}