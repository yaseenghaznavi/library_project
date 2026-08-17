<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('home.css')

</head>

<body>

    @include('home.header')

    @include('home.main_banner')

    @include('home.category')

    @include('home.book')

    @include('home.footer')

    @include('home.chatbot')




</body>

</html>