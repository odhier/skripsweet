<div class="absolute md:relative w-11/12 md:w-full mx-4 md:mx-0 my-6 md:my-0 transition duration-500 ease-in-out transform" :class="{'translate-x-96 md:translate-x-0': shadowStep<3}">
  <div class="border-2 border-gray-200 rounded-lg p-5 mb-5 border-anim h-max" x-show="step>2">

    <template x-if="encryptedImageUrl">
      <img :src="encryptedImageUrl" x-show="encryptedImageUrl" class="object-cover rounded border border-gray-200 w-full ">
      <label class="label"></label>
    </template>

    <div class="form-control">
      <label class="label">
        <span class="label-text">Public Key</span>
      </label>
      <div class="relative" x-data="{pubKeyCopy:false}">
        <input type="text" placeholder="Public Key" x-model="public_key.val" readonly class="w-full cursor-not-allowed text-black input input-bordered bg-gray-200">
        <span class="absolute inset-y-0 right-0 flex items-center pr-2" @click="$clipboard(public_key.val); pubKeyCopy = true; setTimeout(() => pubKeyCopy = false, 700)">
          <div :class="{'hidden': !pubKeyCopy}" class="hidden animate-ping w-max px-2 py-1 text-white bg-base-200 text-xs rounded-md">Copied</div>
          <button type="submit" class="p-1 focus:outline-none focus:shadow-outline">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
          </button>
        </span>
      </div>
      <label class="label"></label>
    </div>
    <div class="form-control">
      <label class="label">
        <span class="label-text">Private Key</span>
      </label>
      <div class="relative" x-data="{prvKeyCopy:false}">

        <input type="text" placeholder="Private Key" x-model="private_key.val" readonly class="text-sm text-black input input-bordered bg-gray-200 w-full pr-10">
        <span class="absolute inset-y-0 right-0 flex items-center pr-2" @click="$clipboard(private_key.val); prvKeyCopy = true; setTimeout(() => prvKeyCopy = false, 700)">
          <div :class="{'hidden': !prvKeyCopy}" class="hidden animate-ping w-max px-2 py-1 text-white bg-base-200 text-xs rounded-md">Copied</div>

          <button type="submit" class="p-1 focus:outline-none focus:shadow-outline">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
          </button>
        </span>
      </div>
      <label class="label"></label>

    </div>
    <div class="form-control  flex items-end">
      <a x-show="step==3" :href="encryptedImageUrl" x-ref="downloadBtn" :download="encryptedImageName" class="btn btn-sm w-full btn-outline float-right my-3 hover:text-white"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
        </svg>Download Encrypted Image</a>
    </div>
  </div>
</div>