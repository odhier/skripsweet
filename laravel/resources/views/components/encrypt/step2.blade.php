<div class="absolute md:relative w-11/12 md:w-full mx-4 md:mx-0 my-6 md:my-0 transition duration-500 ease-in-out transform" :class="{'translate-x-96 md:translate-x-0': shadowStep==1, '-translate-x-96 md:translate-x-0': shadowStep==3}">
  <div class="border-2 border-gray-200 rounded-lg p-5 mb-5" x-show="step>1" :class="{'bg-gray-200': step>2}">
    <form method="POST" enctype="multipart/form-data" id="upload_image_form" action="javascript:void(0)">

      <div class="form-control ">
        <input type="hidden" id="triggerUp" @click="$nextTick(() => $refs.cipherkey.focus());">
        <label class="label">
          <span class="label-text">Key (Encrypted)</span>
        </label>
        <input type="text" name="cipherkey" id="cipherkey" readonly x-ref="cipherkey" x-model="cipherkey" placeholder="Key" class="input input-bordered bg-gray-100">
        <label class="label">
          <span class="label-text text-error hidden"></span>
        </label>
      </div>
      <div class="form-control">
        <label class="label">
          <span class="label-text">Ciphertext</span>

        </label>
        <textarea x-ref="ciphertext" readonly x-model="ciphertext" placeholder="Ciphertext" class="textarea textarea-bordered bg-gray-100"></textarea>
        <label class="label">
          <span class="label-text text-error hidden"></span>
        </label>
      </div>

      <div class="mb-2">
        <!-- Show the image -->
        <template x-if="imageUrl">
          <img :src="imageUrl" x-show="imageUrl && !imageError" class="object-cover rounded border border-gray-200 w-full ">
        </template>

        <!-- Show the gray box when image is not available -->
        <template x-if="!imageUrl">
          <div class="border rounded border-gray-200 bg-gray-100 w-full h-auto"></div>
        </template>

        <!-- Image file selector -->
        <input class="mt-2" x-show="step<3" name="image" x-ref=img type="file" x-model="imageFile" accept="image/jpg, image/png" @change="fileChosen">
        <label class="label">
          <a href="#" class="label-text-alt" x-show="step<3">Minimum size: <span x-text="minimumImg"></span></a>
        </label>
        <label class="label">
          <span class="label-text text-error" x-show="imageError" x-text="imageError"></span>
        </label>
      </div>
      <div class="form-control  flex items-end">
        <button x-show="imageUrl && !imageError && step<3" x-ref="steganoBtn" class="btn btn-sm w-full btn-outline float-right my-3 hover:text-white" :disabled="isLoading" :class="{ 'loading': isLoading }" x-text="isLoading ? 'Please wait' : 'Process Steganography'"></button>
      </div>

    </form>
  </div>

</div>