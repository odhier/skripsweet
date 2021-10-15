<div class="w-full navbar bg-base-100 px-0 sm:px-6 lg:px-12">
  <div class="flex-none lg:hidden">
    <label for="my-drawer-3" class="btn btn-square btn-ghost text-primary-content">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
      </svg>
    </label>
  </div>
  <div class="flex-1 px-2 mx-2">
    <img class="block h-8 w-auto mr-2" src="/images/icon-logo-white.png" alt="Stegcrypt">
    <img class="block h-5 w-auto" src="/images/logo-bright.png" alt="Stegcrypt">
  </div>

  <div class="flex-none hidden lg:block">
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
          <a>Item 1</a>
        </li>
        <li>
          <a>Item 2</a>
        </li>
        <li>
          <a>Item 3</a>
        </li>
      </ul>

    </div>
  </div>
</div>