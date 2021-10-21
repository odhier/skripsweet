@extends('layouts.app')
@section('title', 'Unauthorized')
@section('content')
<div class="flex items-center justify-center w-full h-96">
  <div class="container text-center py-12 mx-auto">
    <h1 class="text-4xl font-semibold mb-4 text-base-100">401</h1>
    <p class="text-gray-700 mb-10">Sorry, you're Unauthorized for access this page</p>
    <a href="/" class="btn btn-wide text-white px-6 py-2 tracking-wider uppercase text-sm">&larr; Go back home</a>
  </div>
</div>
@endsection