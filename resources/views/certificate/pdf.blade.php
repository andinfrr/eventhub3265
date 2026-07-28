<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>

        @page {
            size: A4 landscape;
            margin: 0;
        }


        body {
            margin: 0;
            padding: 0;
            font-family: "DejaVu Sans", sans-serif;
            background: #ffffff;
        }


        .certificate {

            width: 100%;
            height: 100vh;
            position: relative;
            text-align: center;
            padding: 45px;
            box-sizing: border-box;

        }



        /* Outer Border */
        .border {

            position: absolute;
            top: 25px;
            left: 25px;
            right: 25px;
            bottom: 25px;

            border: 6px solid #1f4e79;

        }



        .inner-border {

            position: absolute;
            top: 35px;
            left: 35px;
            right: 35px;
            bottom: 35px;

            border: 2px solid #d4af37;

        }



        .content {

            position: relative;
            z-index: 2;
            margin-top: 65px;

        }



        .logo img {

            width: 90px;
            height: auto;

        }



        .title {

            margin-top: 15px;
            font-size: 38px;
            font-weight: bold;
            letter-spacing: 8px;
            color: #1f4e79;

        }



        .subtitle {

            margin-top: 5px;
            font-size: 20px;
            letter-spacing: 5px;
            color: #555;

        }



        .text {

            margin-top: 30px;
            font-size: 15px;
            color: #333;

        }



        .name {

            margin-top: 15px;
            font-size: 35px;
            font-weight: bold;
            color: #1f4e79;

            text-transform: uppercase;

            border-bottom: 2px solid #d4af37;

            display: inline-block;

            padding: 0 40px 8px;

        }



        .event {

            margin-top: 15px;

            font-size: 22px;

            font-weight: bold;

            color: #333;

        }



        .description {

            margin-top: 10px;

            font-size: 14px;

        }



        .footer {

            position: absolute;

            bottom: 70px;

            left: 0;

            right: 0;

            display: flex;

            justify-content: space-around;

            text-align: center;

        }



        .signature {

            width: 220px;

            font-size: 13px;

        }



        .signature .line {

            margin-top: 45px;

            border-top: 1px solid #333;

            padding-top: 8px;

        }



        .certificate-number {

            position: absolute;

            top: 55px;

            right: 70px;

            font-size: 12px;

            color: #555;

        }



        .date {

            margin-top: 25px;

            font-size: 14px;

        }


    </style>

</head>



<body>


<div class="certificate">


    <div class="border"></div>

    <div class="inner-border"></div>



    <div class="certificate-number">

        No: {{ $transaction->order_id }}

    </div>




    <div class="content">



        {{-- Logo Event --}}
        @if($transaction->event && $transaction->event->logo)

            <div class="logo">

                <img src="{{ public_path('storage/'.$transaction->event->logo) }}">

            </div>

        @endif





        <div class="title">

            CERTIFICATE

        </div>



        <div class="subtitle">

            OF PARTICIPATION

        </div>




        <div class="text">

            This certificate is proudly presented to

        </div>




        <div class="name">

            {{ $transaction->customer_name }}

        </div>




        <div class="text">

            For successfully participating in

        </div>




        <div class="event">

            {{ $transaction->event->title ?? 'EventHub Event' }}

        </div>




        <div class="description">

            This certificate is awarded as a form of appreciation

            for participation and contribution in this event.

        </div>




        <div class="date">

            Issued on

            {{ $transaction->created_at->format('d F Y') }}

        </div>



    </div>






    <div class="footer">



        <div class="signature">

            Event Committee


            <div class="line">

                EventHub Committee

            </div>


        </div>





        <div class="signature">

            Authorized By


            <div class="line">

                Admin EventHub

            </div>


        </div>



    </div>




</div>


</body>

</html>