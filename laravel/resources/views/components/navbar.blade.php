<div class="w-full navbar bg-base-100 px-0 sm:px-6 lg:px-12">
  <div class="flex-none lg:hidden">
    <label for="my-drawer-3" class="btn btn-square btn-ghost text-primary-content">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
      </svg>
    </label>
  </div>
  <a href="/" class="flex-1 px-2 mx-2">
    <img class="block h-8 w-auto mr-2" src="/images/icon-logo-white.png" alt="Stegcrypt">
    <img class="block h-5 w-auto" src="/images/logo-bright.png" alt="Stegcrypt">
  </a>

  <div class="flex-none hidden lg:block" x-data="{ openMenuProfile: false }">
    <ul class="menu horizontal text-primary-content">
      <li>
        <a href="{{route('encrypt')}}" class="rounded-btn">Encrypt</a>
      </li>
      <li>
        <a href="{{route('decrypt')}}" class="rounded-btn">Decrypt</a>
      </li>
    </ul>
    <div class="rounded-btn dropdown dropdown-end text-primary-content">
      <div tabindex="0" class="btn rounded-btn capitalize font-medium text-base border-0 hover:bg-base-100 focus:bg-primary bg-base-100">History <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg></div>
      <ul tabindex="0" class="p-2 menu dropdown-content bg-base-100 rounded-box w-52">
        <li>
          <a href="{{route('encryptHistory')}}">History Encrypt</a>
        </li>
        <li>
          <a href="{{route('decryptHistory')}}">History Decrypt</a>
        </li>

      </ul>

    </div>

    <div class="float-right h-full flex items-center ml-5" @click="openMenuProfile=!openMenuProfile" @click.away="openMenuProfile=false">
      <div>
        <button type="button" class=" bg-gray-800 flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
          <span class="sr-only">Open user menu</span>
          <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
        </button>
      </div>

      <!--
            Dropdown menu, show/hide based on menu state.

            Entering: "transition ease-out duration-100"
              From: "transform opacity-0 scale-95"
              To: "transform opacity-100 scale-100"
            Leaving: "transition ease-in duration-75"
              From: "transform opacity-100 scale-100"
              To: "transform opacity-0 scale-95"
          -->
      <div :class="{'transform opacity-100 scale-100': openMenuProfile}" class="top-12 right-12 transition ease-in-out duration-100 transform opacity-0 scale-95 origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
        <!-- Active: "bg-gray-100", Not Active: "" -->
        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>
        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Settings</a>
        <a href="/logout" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</a>
      </div>
    </div>
  </div>
</div>