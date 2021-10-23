<div class="drawer-side">

  <label for="my-drawer-3" class="drawer-overlay"></label>

  <div class="p-4 overflow-y-auto menu w-80 bg-base-100 text-primary-content">
    <div class="flex mb-4 items-center">
      <div class="avatar">
        <div class="mx-5 rounded-full w-14 h-14 ring ring-secondary ring-offset-base-100 ring-offset-2">
          <img src="http://daisyui.com/tailwind-css-component-profile-1@56w.png">
        </div>
      </div>
      <div class="profile-info grid grid-cols-1">
        <span>
          {{Auth::user()->name}}
        </span>
        <span>
          {{Auth::user()->email}}
        </span>
        <span><a href="#" class="text-secondary">Edit Profile</a></span>
      </div>
    </div>

    <div class="border-t border-white w-100 mb-4"></div>
    <li>
      <a href="{{route('encrypt')}}">Encrypt</a>
    </li>
    <li>
      <a href="{{route('decrypt')}}">Decrypt</a>
    </li>
    <li>
      <a href="#">History</a>
      <ul>
        <li><a href="{{route('encryptHistory')}}"> History Encrypt</a></li>
        <li><a href="{{route('decryptHistory')}}"> History Decrypt</a></li>
      </ul>
    </li>
  </div>
</div>