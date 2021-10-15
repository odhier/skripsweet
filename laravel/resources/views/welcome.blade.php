 <!doctype html class="bg-white">

 <head>
   <title>Home - Stegcrypt</title>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
   <link href="{{ asset('css/app.css') }}" rel="stylesheet">
 </head>

 <body class="overflow-hidden bg-white">

   <div class="header ">
     <nav class="bg-white-800">
       <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
         <div class="relative flex items-center justify-between h-16">
           <div class="absolute  inset-y-0 left-0 flex items-center sm:hidden">
             <!-- Mobile menu button-->
             <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
               <span class="sr-only">Open main menu</span>
               <!--
            Icon when menu is closed.

            Heroicon name: outline/menu

            Menu open: "hidden", Menu closed: "block"
          -->
               <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
               </svg>
               <!--
            Icon when menu is open.

            Heroicon name: outline/x

            Menu open: "block", Menu closed: "hidden"
          -->
               <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
               </svg>
             </button>
           </div>
           <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
             <div class="flex-shrink-0 flex items-center">
               <img class="block h-8 w-auto" src="/images/icon-logo.png" alt="Stegcrypt">
               <img class="hidden lg:block h-8 w-auto" src="/images/logo-dark.png" alt="Stegcrypt">
             </div>

           </div>
           <div class="z-10 absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
             <div class="hidden sm:block sm:ml-6">
               <div class="flex space-x-4">
                 <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->

                 <a href="/register" class="text-gray-300 hover:bg-indigo-900 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Register</a>

                 <a href="/login" class="text-gray-300 hover:bg-indigo-900 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Login</a>

               </div>
             </div>



           </div>
         </div>
       </div>

       <!-- Mobile menu, show/hide based on menu state. -->
       <div class="hidden" id="mobile-menu">
         <div class="px-2 pt-2 pb-3 space-y-1">
           <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
           <a href="/register" class="text-gray-300 hover:bg-indigo-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Register</a>

           <a href="/login" class="text-gray-300 hover:bg-indigo-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Login</a>
         </div>
       </div>
     </nav>
   </div>
   <div class="bg-white hidden sm:block back transform rotate-45 w-6/12 absolute " style="right: -50vh;width: 150vh; height:125vh;background: rgb(49,46,129);
background: linear-gradient(90deg, rgba(49,46,129,1) 0%, rgb(54 127 168) 100%);box-shadow: inset 8px -11px 24px 0px rgb(0 0 0 / 66%);top:0vh;z-index:0;">
     <div class="w-full h-full">
       <img src="/images/946.png" class="transform -rotate-45 w-3/4 mt-44 ml-0">
     </div>
   </div>
   <div class="bg-white px-2 sm:px-8 container main-section grid grid-cols-1 sm:grid-cols-2 sm:pt-24 bg-gray-800 sm:bg-white">
     <div class="text-4xl sm:text-5xl sm:text-gray-800 p-0 sm:p-12 text-gray-300 sm:leading-relaxed">Everybody has his little dirty <b class="text-gray-300 sm:text-indigo-900">Secret.</b></div>
     <div></div>
   </div>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
 </body>

 </html>