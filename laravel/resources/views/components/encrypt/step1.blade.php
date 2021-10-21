<div class="absolute md:relative w-11/12 md:w-full mx-4 md:mx-0 my-6 md:my-0 transition duration-500 ease-in-out transform" :class="{'-translate-x-96 md:translate-x-0': shadowStep>1}">
  <div class="border-2 border-gray-200 rounded-lg p-5 mb-5 " :class="{'bg-gray-200': step>1}">
    <div class="form-control">
      <label class="label">
        <span class="label-text">Key</span>
      </label>
      <input type="text" :readonly="step==3" x-model="key.val" placeholder="Key" class="input input-bordered bg-white" :class="{'border-red-400': key.error , 'bg-gray-100': step==3}">
      <label class="label">
        <span class="label-text text-error" x-show="key.error" x-text="key.error"></span>
      </label>

    </div>

    <div class="form-control">
      <label class="label">
        <span class="label-text">Message</span>
      </label>
      <textarea :readonly="step==3" class="textarea h-24 textarea-bordered bg-white" x-model="message.val" placeholder="Message" :class="{'border-red-400': message.error , 'bg-gray-100': step==3}"></textarea>
      <label class="label">
        <span class="label-text text-error" x-show="message.error" x-text="message.error"></span>
      </label>
    </div>
  </div>
  <section id="rsa">
    <h3 class="pl-3">RSA Encryption</h3>
    <div class="border-2 border-gray-200 rounded-lg h-auto pb-16 p-5" :class="{'bg-gray-200': step>1}">
      <div class="form-control">
        <label class="label">
          <span class="label-text">p</span>
          <div class="label-text-alt tooltip tooltip-left bg-base-200 cursor-pointer text-white rounded-full h-4 w-4 flex items-center justify-center" data-tip="Masukkan satu buah bilangan prima">
            ?
          </div>
        </label>
        <input type="text" :readonly="step==3" @change="stepRSA=1, step=1" x-model="p.val" placeholder="p" class="input input-bordered bg-white" :class="{'border-red-400': p.error , 'bg-gray-100': step==3}">
        <label class="label">
          <span class="label-text text-error" x-show="p.error" x-text="p.error"></span>
        </label>

      </div>
      <div class="form-control">
        <label class="label">
          <span class="label-text">q</span>
          <div class="label-text-alt tooltip tooltip-left bg-base-200 cursor-pointer text-white rounded-full h-4 w-4 flex items-center justify-center" data-tip="Masukkan satu buah bilangan prima">
            ?
          </div>
        </label>
        <input type="text" :readonly="step==3" placeholder="q" @change="stepRSA=1, step=1" x-model="q.val" class="input input-bordered bg-white" :class="{'border-red-400': q.error , 'bg-gray-100': step==3}">
        <label class="label">
          <span class="label-text text-error" x-show="q.error" x-text="q.error"></span>
        </label>
      </div>
      <button x-show="stepRSA == 1" class="flex-none btn btn-sm btn-outline float-right my-3 hover:text-white" :disabled="isLoading" @click="processPQ()" :class="{ 'loading': isLoading }" x-text="isLoading ? 'Please wait' : 'Process P & Q'"></button>
      <div id="candidates" x-show="stepRSA > 1" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-1">
        <div class="form-control">
          <label class="label">
            <span class="label-text">N = p*q</span>
          </label>
          <input type="text" placeholder="N" x-model="N" readonly class="cursor-not-allowed text-black input input-bordered bg-gray-200">
        </div>

        <div class="form-control my-5">
          <label class="label">
            <span class="label-text">r = (p-1) * (q-1)</span>
          </label>
          <input type="text" placeholder="r" x-model="r" readonly class="cursor-not-allowed text-black input input-bordered bg-gray-200">
        </div>
        <div class="form-control">
          <label class="label">
            <span class="label-text">K = Candidates(l mod r)</span>
            <div class="label-text-alt tooltip tooltip-left bg-base-200 cursor-pointer text-white rounded-full h-4 w-4 flex items-center justify-center" data-tip="Pilih salah satu dari kandidat">
              ?
            </div>
          </label>
          <select class="select select-bordered w-full bg-white" x-model="k" :disabled="step==3">
            <option :disabled="true" selected>--Pilih K--</option>
            <template x-for="option in candidates" :key="option">
              <option :value="option" x-text="option" :selected="(k!='' && k == option)">option</option>
            </template>
          </select>
          <label class="label">
            <span class="label-text text-error" x-show="factorK.error" x-text="factorK.error"></span>
          </label>
        </div>

        <div class="form-control  flex items-end">
          <button x-show="stepRSA >= 2 && step < 3" x-ref="encryptBtn" class="btn btn-sm w-max btn-outline float-right my-3 hover:text-white" :disabled="isLoading" :class="{ 'loading': isLoading }" x-text="isLoading ? 'Please wait' : 'Process Encrypt'"></button>
        </div>
        <div class="alert alert-error w-full" x-show="errorEncrypt.status">
          <div class="flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-6 h-6 mx-2 stroke-current">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
            </svg>
            <label x-html="errorEncrypt.message">Error
            </label>
          </div>
        </div>
        <div id="finalRSA" x-show="stepRSA > 2" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-1">
          <label class="label">
            <span class="label-text">Results RSA</span>
          </label>
          <div class="form-control border-t border-gray-800">
            <label class="label">
              <span class="label-text">Factors of K</span>
            </label>
            <input type="text" placeholder="Factors of K" x-model="factorK.val" readonly class="cursor-not-allowed text-black input input-bordered bg-gray-200">
            <label class="label">
              <span class="label-text text-error" x-show="factorK.error" x-text="factorK.error"></span>
            </label>
          </div>
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
        </div>
      </div>


    </div>

  </section>
</div>