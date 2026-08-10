<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/public">

    @include('home.css')

    <style>
        .div_design{
            text-align: center;
            margin: auto;
            margin-top: 100px;
        }
        .heading{
            color: white;
            font-size: 50px;
            font-weight: bold;
        }
    </style>

</head>

<body>

    @include('home.header')

    <div class="currently-market">
        <div class="container">
            <div class="row">
                
                <div class="div_design">
                    <h1 class="heading">Pay Fine</h1>

                    <p style="font-size: 25px;">Fine Amount: {{ $borrow_request->fine }}</p>
                    <br>
                    <br>

                    <form action="{{ route('stripe.checkout') }}" method="post">
                        @csrf

                        <input type="hidden" name="borrow_id" value="{{ $borrow_request->id }}">
                        <input type="hidden" name="amount" value="{{ $borrow_request->fine }}">

                        <button type="submit" class="btn btn-success">
                            Pay with Stripe
                        </button>
                    {{-- </form>
                    <br>
                    <form action="{{ url('/process_payment/Easypaisa') }}" method="post">
                        @csrf

                        <input type="hidden" name="borrow_id" value="{{ $borrow_request->id }}">

                        <button type="submit" class="btn btn-success">
                            Pay with Easypaisa
                        </button>
                    </form> --}}

                </div>

            </div>
        </div>
    </div>

    @include('home.footer')

</body>

</html>