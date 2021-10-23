@extends('layouts.app')
@section('title', 'Encrypt Message')
@section('script-footer')

<script src="https://cdn.jsdelivr.net/npm/@ryangjchandler/alpine-clipboard@0.1.x/dist/alpine-clipboard.umd.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<header class="bg-white shadow">
  <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900">
      Profile Page
    </h1>
  </div>
</header>
<main>
  <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 min-h-screen" x-data="profileState()">
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
      <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
          Account Information
        </h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">
          Personal details and password.
        </p>
      </div>
      <div class="border-t border-gray-200">
        <dl>
          <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
              Full name
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              <input type="text" placeholder="Name" value="{{Auth::user()->name}}" class="input input-sm input-bordered bg-white">
              <a href="/profile/update-password" class="text-primary float-right">Update</a>
            </dd>
          </div>

          <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
              Email address
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              {{Auth::user()->email}}
            </dd>
          </div>
          <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
              Password
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              <a href="/profile/update-password" class="text-primary">Update Password</a>
            </dd>
          </div>

        </dl>
      </div>
    </div>

  </div>
</main>
@endsection