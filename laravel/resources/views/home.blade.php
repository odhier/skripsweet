@extends('layouts/app')
@section('title', 'Dashboard')
@section('content')
<header class="bg-white shadow">
  <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900">
      Dashboard
    </h1>
  </div>
</header>
<main>
  <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Replace with your content -->
    <div class="px-4 sm:px-0">
      <h2 class="text-lg">Welcome back, <b>{{Auth::user()->name}}</b> </h2>
    </div>
    <!-- /End replace -->
  </div>
  <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Replace with your content -->
    <div class="px-4 py-6 sm:px-0">
      <h2 class="text-lg">Recent Encryptions</b></h2>
    </div>
    <div class="px-4 md:px-0 grid grid-cols-2 md:grid-cols-4 gap-4">
      @foreach($data['recent_encrypt'] as $index=>$recent)
      @if($index < 3) <a href="/encrypt/{{$recent->id}}">
        <div class="avatar ring ring-base-100 ring-opacity-700 rounded-lg w-full opacity-70 hover:opacity-100 ">
          <div class="rounded-btn w-full h-32 md:h-56">
            <img src="{{($recent->encrypted_img)?'/storage/'.$recent->encrypted_img:'/images/noimage.jpg'}}">
          </div>
        </div>
        </a>
        @else
        <div class="relative ring ring-base-100 ring-opacity-700 w-full rounded-lg stack ">
          <a href="/history/encrypt">
            <div class="rounded-btn w-full h-32 md:h-56">
              <img class="w-full" src="{{($recent->encrypted_img)?'/storage/'.$recent->encrypted_img:'/images/noimage.jpg'}}">
            </div>
            @if(($data['count_encrypt'] - 3 >=1 ))
            <div class="absolute bg-opacity-70 hover:bg-opacity-95 transition top-0 left-0 rounded-btn w-full h-32 md:h-56 bg-base-200 text-white flex items-center justify-center text-4xl">
              {{($data['count_encrypt'] - 3)}}+
            </div>
            @endif
          </a>

        </div>
        @endif
        @endforeach

    </div>
    <!-- /End replace -->
  </div>
  <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Replace with your content -->
    <div class="px-4 py-6 sm:px-0">
      <h2 class="text-lg">Recent Decryptions</b></h2>
    </div>
    <div class="px-4 md:px-0 grid grid-cols-2 md:grid-cols-4 gap-4">
      @foreach($data['recent_decrypt'] as $index=>$recent)
      @if($index < 3) <a href="/decrypt/{{$recent->id}}">
        <div class="avatar ring ring-base-100 ring-opacity-700 rounded-lg w-full opacity-70 hover:opacity-100 ">
          <div class="rounded-btn w-full h-32 md:h-56">
            <img src="{{($recent->encrypted_img)?'/storage/'.$recent->encrypted_img:'/images/noimage.jpg'}}">
          </div>
        </div>
        </a>
        @else
        <div class="relative ring ring-base-100 ring-opacity-700 w-full rounded-lg stack ">
          <a href="/history/decrypt">
            <div class="rounded-btn w-full h-32 md:h-56">
              <img class="w-full" src="{{($recent->encrypted_img)?'/storage/'.$recent->encrypted_img:'/images/noimage.jpg'}}">
            </div>
            @if(($data['count_decrypt'] - 3 >=1 ))

            <div class="absolute bg-opacity-70 hover:bg-opacity-95 transition top-0 left-0 rounded-btn w-full h-32 md:h-56 bg-base-200 text-white flex items-center justify-center text-4xl">
              {{($data['count_decrypt'] - 3)}}+
            </div>
            @endif
          </a>

        </div>
        @endif
        @endforeach

    </div>
    <!-- /End replace -->
  </div>
</main>
@endsection