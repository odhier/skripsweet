<!doctype html>

<head>
    <!-- ... --->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
</head>

<body>
    <!-- Create By Joker Banny -->
    <div class="min-h-screen bg-no-repeat bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1486520299386-6d106b22014b?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1050&q=80')">
        <div class="flex justify-end sm:flex-row-reverse">
            <div class="bg-white min-h-screen w-full sm:w-1/2 lg:w-2/5 flex justify-center items-start py-12">
                <div class="w-full lg:w-1/2 grid gap-y-5">
                    <a href="/">
                        <div class="flex-1 flex items-center justify-start sm:items-stretch sm:justify-start">
                            <div class="flex-shrink-0 flex items-center">

                                <img class="block h-8 w-auto" src="/images/icon-logo.png" alt="Stegcrypt">
                                <img class="block h-8 w-auto" src="/images/logo-dark.png" alt="Stegcrypt">

                            </div>

                        </div>
                    </a>

                    <div>
                        <span class="text-sm text-gray-900">Oops!</span>
                        <h1 class="text-2xl font-bold text-gray-900">Please verify your email</h1>
                    </div>
                    @if (session('resent'))
                    <div x-data="{ show: true }" x-show="show" class="w-full bg-white my-2 rounded-md px-5 bg-green-500">
                        <div class="flex items-center py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="ml-5">
                                <h1 class="text-md font-bold text-white">Well done!</h1>
                                <p class="text-white text-sm my-0">{{ __('A fresh verification link has been sent to your email address.') }}</p>
                            </div>

                        </div>
                    </div>

                    @endif
                    <div class="my-3 w-full">
                        <span class="block text-md" for="">Before proceeding, please check your email <b>{{$email}}</b></span>

                        <span>for a verification link.</span>
                    </div>
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="text-indigo-500 flex" x-on:click="loading=true" x-data="{loading:false}">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-800" x-show="loading" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ __('click here to request another') }}</button>
                    </form>

                    <div class="">
                        <a href="/re-login">
                            <button href="/re-login" class="mt-4 mb-3 w-full bg-indigo-900 hover:bg-indigo-800 text-white py-2 rounded-md transition duration-100">Login now</button>
                        </a>
                        <div class="flex  space-x-2 justify-center items-end bg-gray-900 hover:bg-gray-600 text-white py-2 rounded-md transition duration-100"">

            <img class=" h-5 cursor-pointer" src="https://imgur.kageurufu.net/arC60SB.jpg" alt="">
                            <button>Or sign-in with google</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</body>

</html>