@extends('layouts.app')
@section('title', 'Encrypt Message')
@section('script')


@endsection
@section('content')
<header class="bg-white shadow">
  <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900">
      Encrypt
    </h1>
  </div>
</header>
<main>
  <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Replace with your content -->
    <ul class="w-full steps grid grid-cols-3">
      <li class="step step-info">Encryption</li>
      <li class="step">Steganography</li>
      <li class="step">Results</li>
    </ul>
    <div class="px-4 py-6 sm:px-0 grid grid-cols-3 gap-2" x-data="encryptState()">
      <div>
        <div class="border-2 border-gray-200 rounded-lg h-96 p-5"></div>
        <div class="border-2 border-gray-200 rounded-lg h-96 p-5">
          <div class="form-control">
            <label class="label">
              <span class="label-text">p</span>
              <div class="label-text-alt tooltip bg-base-200 cursor-pointer text-white rounded-full h-4 w-4 flex items-center justify-center" data-tip="Masukkan satu buah bilangan prima">
                ?
              </div>
            </label>
            <input type="text" @change="step=1" x-model="p.val" placeholder="p" class="input input-bordered bg-white" :class="{'border-red-400': p.error}">
            <label class="label">
              <span class="label-text text-error" x-show="p.error" x-text="p.error"></span>
            </label>

          </div>
          <div class="form-control">
            <label class="label">
              <span class="label-text">q</span>
              <div class="label-text-alt tooltip bg-base-200 cursor-pointer text-white rounded-full h-4 w-4 flex items-center justify-center" data-tip="Masukkan satu buah bilangan prima">
                ?
              </div>
            </label>
            <input type="text" placeholder="q" @change="step=1" x-model="q.val" class="input input-bordered bg-white" :class="{'border-red-400': q.error}">
            <label class="label">
              <span class="label-text text-error" x-show="q.error" x-text="q.error"></span>
            </label>
          </div>
          <button x-show="step == 1" class="btn btn-sm btn-outline float-right my-3 hover:text-white" :disabled="isLoading" @click="processPQ()" :class="{ 'loading': isLoading }" x-text="isLoading ? 'Please wait' : 'Process P & Q'"></button>
        </div>
      </div>
      <div class="border-0 border-dashed border-gray-200 rounded-lg h-96"></div>
      <div class="border-0 border-dashed border-gray-200 rounded-lg h-96"></div>
    </div>
    <!-- /End replace -->
  </div>
</main>
<script>
  function encryptState() {
    return {
      p: {
        val: '',
        error: ''
      },
      q: {
        val: '',
        error: ''
      },
      isLoading: false,
      step: 1,
      isPrime(num) {
        for (var i = 2; i < num; i++)
          if (num % i === 0) return false;
        return num > 1;
      },
      processPQ() {
        this.isLoading = true;
        if (!this.isPrime(this.p.val))
          this.p.error = "Bilangan p bukan prima"
        else
          this.p.error = '';
        if (!this.isPrime(this.q.val))
          this.q.error = "Bilangan q bukan prima";
        else
          this.q.error = '';

        if (!this.p.error && !this.q.error) this.step++;
        return this.isLoading = false;
      }
    }
  }
</script>
@endsection