<!doctype html>

<head>
  <!-- ... --->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
  <!-- Create By Joker Banny -->
  <div class="min-h-screen bg-no-repeat bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1486520299386-6d106b22014b?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1050&q=80')">
    <div class="flex justify-end sm:flex-row-reverse">
      <div class="bg-white min-h-screen w-full sm:w-1/2 lg:w-2/5 flex justify-center items-center">
        <div>
          <a href="/">
            <div class="flex-1 flex items-center justify-start sm:items-stretch sm:justify-start">
              <div class="flex-shrink-0 flex items-center">

                <img class="block h-8 w-auto" src="/images/icon-logo.png" alt="Stegcrypt">
                <img class="block h-8 w-auto" src="/images/logo-dark.png" alt="Stegcrypt">

              </div>

            </div>
          </a>
          <form class="mt-5 space-y-5" method="POST" action="{{ route('login') }}">
            @csrf
            <div>
              <span class="text-sm text-gray-900"></span>
              <h1 class="text-2xl font-bold text-gray-900">Login to your account</h1>
            </div>
            <div class="my-3">
              <label class="block text-md mb-2" for="email">Email</label>
              <input class="border-2 px-4 w-full focus:ring-2 focus:border-0 focus:ring-blue-900 focus:ring-opacity-50 py-2 rounded-md text-sm outline-none @error('email') border-red-500 @enderror" type="email" name="email" placeholder="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
              @error('email')
              <div class="text-xs text-red-500" role="alert">
                <strong>{{ $message }}</strong>
              </div>
              @enderror
            </div>
            <div class="mt-5">
              <label class="block text-md mb-2" for="password">Password</label>
              <input class="px-4 w-full border-2 py-2 rounded-md text-sm outline-none focus:ring-2 focus:border-0 focus:ring-blue-900 focus:ring-opacity-50 @error('password') border-red-500 @enderror" type="password" name="password" placeholder="password">
              @error('password')
              <div class="text-xs text-red-500" role="alert">
                <strong>{{ $message }}</strong>
              </div>
              @enderror
            </div>

            <div class="flex justify-between">
              <div>
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="text-sm" for="remember">
                  {{ __('Remember Me') }}
                </label>
              </div>
              <span class="text-sm text-blue-700 hover:underline cursor-pointer">Forgot password?</span>
            </div>
            <div class="">
              <button class="mt-4 mb-3 w-full bg-indigo-900 hover:bg-indigo-800 text-white py-2 rounded-md transition duration-100">Login now</button>
              <!-- <div class="flex  space-x-2 justify-center items-end bg-gray-900 hover:bg-gray-600 text-white py-2 rounded-md transition duration-100"">

            <img class=" h-5 cursor-pointer" src="https://imgur.kageurufu.net/arC60SB.jpg" alt="">
                <button>Or sign-in with google</button>
              </div> -->
            </div>
          </form>
          <p class="mt-8"> Dont have an account? <span class="cursor-pointer text-sm text-blue-600"><a href="/register">Register Now</a></span></p>
        </div>
      </div>
    </div>
  </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</body>

</html>