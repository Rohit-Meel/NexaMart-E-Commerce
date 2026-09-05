<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @yield('title', 'NexaMart')
    </title>

    {{-- Font Awesome --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    {{-- Main CSS --}}
    <link rel="stylesheet"
          href="{{ asset('assets/css/style.css') }}">

    {{-- Header CSS --}}
    <link rel="stylesheet"
          href="{{ asset('assets/css/header.css') }}">

    {{-- Navbar CSS --}}
    <link rel="stylesheet"
          href="{{ asset('assets/css/navbar.css') }}">

    {{--Product CSS --}}
      <link rel="stylesheet"
           href="{{ asset('assets/css/products.css') }}">

    {{--Product CSS --}}
      <link rel="stylesheet"
           href="{{ asset('assets/css/categories.css') }}">

    {{--About CSS --}}
      <link rel="stylesheet"
           href="{{ asset('assets/css/about.css') }}">       
           
    {{--Contact CSS --}}
      <link rel="stylesheet"
           href="{{ asset('assets/css/contact.css') }}">  
           
    {{--Contact CSS --}}
      <link rel="stylesheet"
           href="{{ asset('assets/css/cart.css') }}">
           
    {{--Checkout CSS --}}
      <link rel="stylesheet"
           href="{{ asset('assets/css/checkout.css') }}">    
           
    {{--Auth CSS --}}
      <link rel="stylesheet"
           href="{{ asset('assets/css/auth.css') }}">     
           
    {{--Wishlist CSS --}}
      <link rel="stylesheet"
           href="{{ asset('assets/css/wishlist.css') }}">       
           
    {{--Brands CSS --}}
      <link rel="stylesheet"
           href="{{ asset('assets/css/brands.css') }}">    
           
    {{--Shops CSS --}}
      <link rel="stylesheet"
           href="{{ asset('assets/css/shops.css') }}">  

   {{--Offers CSS --}}
      <link rel="stylesheet"
           href="{{ asset('assets/css/offers.css') }}">             
           

    {{-- Footer CSS --}}
    <link rel="stylesheet"
          href="{{ asset('assets/css/footer.css') }}">
      

    {{-- Home CSS --}}
    <link rel="stylesheet"
          href="{{ asset('assets/css/home.css') }}">

    {{-- Responsive CSS --}}
    <link rel="stylesheet"
          href="{{ asset('assets/css/responsive.css') }}">

</head>

<body>

    {{-- HEADER --}}
    @include('frontend.partials.header')

    {{-- NAVBAR --}}
    @include('frontend.partials.navbar')


    {{-- PAGE CONTENT --}}
    @yield('content')


    {{-- FOOTER --}}
    @include('frontend.partials.footer')


    {{-- JS --}}
    <script src="{{ asset('assets/js/app.js') }}"></script>

    @yield('scripts')

</body>

</html>