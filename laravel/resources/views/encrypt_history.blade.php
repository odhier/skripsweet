@extends('layouts.app')
@section('title', 'Encrypt History')
@section('script-footer')

<script src="https://cdn.jsdelivr.net/npm/@ryangjchandler/alpine-clipboard@0.1.x/dist/alpine-clipboard.umd.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<header class="bg-white shadow">
  <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900">
      Encrypt History
    </h1>
  </div>
</header>
<main class="pt-10">
  <div class="grid grid-cols-1 px-5 md:grid-cols-4 gap-5">
    @foreach($data as $e)
    <div class="card text-left shadow-2xl">
      <figure class="">
        <img src="{{($e->encrypted_img)?'/storage/'.$e->encrypted_img:'/images/noimage.jpg'}}" class="rounded-xl object-cover h-48">
      </figure>
      <div class="card-body">
        <h2 class="card-title">{{$e->key}}</h2>
        <p>{{Str::limit($e->message, 40)}}</p>
        <span class="text-sm text-gray-400">{{$e->created_at}}</span>
        <div class="justify-center card-actions">
          <a href="/encrypt/{{$e->id}}" class="btn btn-outline btn-accent">View Detail</a>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</main>
@endsection