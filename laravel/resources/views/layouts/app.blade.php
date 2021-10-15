 <html data-theme="mytheme">

 <head>
   <title>@yield('title') - Stegcrypt</title>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
   <link href="{{ asset('css/app.css') }}" rel="stylesheet">

 </head>

 <body class="bg-white">

   <div class="shadow bg-white drawer h-full">
     <input id="my-drawer-3" type="checkbox" class="drawer-toggle">
     <div class="flex flex-col drawer-content">
       <x-navbar></x-navbar>

       @yield('content')
     </div>

     <x-nav_mobile></x-nav_mobile>

   </div>

   <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
   <script src="/js/app.js"></script>
   @yield('script')

 </body>

 </html>