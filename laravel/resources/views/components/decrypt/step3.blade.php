<div class="absolute md:relative w-11/12 md:w-full mx-4 md:mx-0 my-6 md:my-0 transition duration-500 ease-in-out transform" :class="{'translate-x-96 md:translate-x-0': shadowStep<3}">
  <div class="border-2 border-gray-200 rounded-lg p-5 mb-5 border-anim h-max" x-show="step>2">

    <div class="form-control ">
      <label class="label">
        <span class="label-text">Key</span>
      </label>
      <input type="text" name="key" id="key" readonly x-ref="key" x-model="key.val" placeholder="Key" class="input input-bordered bg-gray-100">
      <label class="label">
        <span class="label-text text-error hidden"></span>
      </label>
    </div>
    <div class="form-control">
      <label class="label">
        <span class="label-text">Message</span>

      </label>
      <textarea x-ref="message" readonly x-model="message.val" placeholder="message" class="textarea textarea-bordered bg-gray-100"></textarea>
      <label class="label">
        <span class="label-text text-error hidden"></span>
      </label>
    </div>

  </div>

</div>