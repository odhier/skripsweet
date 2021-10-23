<div class="absolute md:relative w-11/12 md:w-full mx-4 md:mx-0 my-6 md:my-0 transition duration-500 ease-in-out transform" :class="{'translate-x-96 md:translate-x-0': shadowStep==1, '-translate-x-96 md:translate-x-0': shadowStep==3}">
  <div class="border-2 border-gray-200 rounded-lg p-5 mb-5" x-show="step>1" :class="{'bg-gray-200': step>2}">

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

  </div>

</div>