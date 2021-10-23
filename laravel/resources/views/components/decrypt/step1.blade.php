<div class="absolute md:relative w-11/12 md:w-full mx-4 md:mx-0 my-6 md:my-0 transition duration-500 ease-in-out transform" :class="{'-translate-x-96 md:translate-x-0': shadowStep>1}">
  <div class="border-2 border-gray-200 rounded-lg p-5 mb-5 " :class="{'bg-gray-200': step>1}">

    <form method="POST" enctype="multipart/form-data" id="upload_image_form" action="javascript:void(0)">
      @csrf
      <div class="mb-2">
        <label for="label">Encrypted image:</label>
        <!-- Show the image -->
        <template x-if="imageUrl">
          <img :src="imageUrl" x-show="imageUrl && !imageError" class="object-cover rounded border border-gray-200 w-full ">
        </template>

        <!-- Image file selector -->
        <input class="mt-2" x-show="step<2" name="image" x-ref=img type="file" x-model="imageFile" accept="image/jpg, image/png" @change="fileChosen">

        <label class="label">
          <span class="label-text text-error" x-show="imageError" x-text="imageError"></span>
        </label>
      </div>
      <div class="form-control">
        <label class="label">
          <span class="label-text">Private Key</span>
        </label>
        <input type="text" :readonly="step>1" x-model="private_key.val" placeholder="Private Key" class="input input-bordered bg-white" :class="{'border-red-400': private_key.error , 'bg-gray-100': step>1}">
        <label class="label">
          <span class="label-text text-error" x-show="private_key.error" x-text="private_key.error"></span>
        </label>

      </div>
      <div class="form-control flex items-end">
        <button x-show="imageUrl && !imageError && step<2" x-ref="steganoBtn" class="btn btn-sm w-full btn-outline float-right my-3 hover:text-white" :disabled="isLoading" :class="{ 'loading': isLoading }" x-text="isLoading ? 'Please wait' : 'Process Steganography'"></button>
      </div>
    </form>
    <div class="alert alert-error w-full" x-show="errorDecrypt.status">
      <div class="flex-1">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-6 h-6 mx-2 stroke-current">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
        </svg>
        <label x-html="errorDecrypt.message">Error
        </label>
      </div>
    </div>
  </div>
</div>