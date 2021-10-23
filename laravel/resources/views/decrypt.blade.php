@extends('layouts.app')
@section('title', 'Decryption')
@section('content')
<header class="bg-white shadow">
  <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900">
      Decrypt
    </h1>
  </div>
</header>
<main>
  <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 min-h-screen" x-data="decryptState()">
    <ul class="w-full steps grid grid-cols-3">
      <li @click="changeStep(1)" class="step step-info">Steganography</li>
      <li @click="changeStep(2)" class="step " :class="{'step-info': step>1}">Decryption</li>
      <li @click="changeStep(3)" class="step " :class="{'step-info': step>2}">Results</li>
    </ul>
    <div class="py-6 sm:px-0 grid grid-cols-1 md:grid-cols-3 gap-2 relative overflow-x-hidden h-full">
      <x-decrypt.step1></x-decrypt.step1>
      <x-decrypt.step2></x-decrypt.step2>
      <x-decrypt.step3></x-decrypt.step3>
    </div>
    <!-- /End replace -->
  </div>
</main>
<script>
  function decryptState() {
    return {
      decrypt_id: 0,
      errorDecrypt: {
        status: false,
        message: '',
      },
      key: {
        val: '',
        error: ''
      },
      message: {
        val: '',
        error: ''
      },

      private_key: {
        t: '',
        val: ''
      },

      ciphertext: '',
      cipherkey: '',
      imageFile: '',
      imageUrl: '',
      imageError: '',
      isLoading: false,
      stepRSA: 1,
      step: 1,
      shadowStep: 1,
      init: function() {
        @isset($data)
        let data = `{!! json_encode($data) !!}`;
        data = JSON.parse(data)
        this.decrypt_id = data.id
        this.key.val = data.key
        this.message.val = data.message
        this.imageUrl = `/storage/${data.encrypted_img}`
        this.private_key.val = data.private_key
        this.cipherkey = data.cipherkey
        this.ciphertext = data.ciphertext
        this.step = 3
        this.shadowStep = 3
        @endisset


        this.$refs.steganoBtn.addEventListener("click", (e) => {
          e.preventDefault();
          var formData = new FormData();
          var privateKey = this.private_key.val.split(",")
          if (privateKey.length != 2) return this.private_key.error = 'Invalid private key format';
          if (this.private_key.val[0] != '{') return this.private_key.error = 'Invalid private key format';
          if (this.private_key.val[(this.private_key.val.length) - 1] != '\}') return this.private_key.error = 'Invalid private key format';
          if (isNaN(privateKey[0].replace('{', '')) || isNaN(privateKey[1].replace('}', ''))) return this.private_key.error = 'Invalid private key format';

          this.private_key.error = '';
          this.isLoading = true
          formData.append('private_key', this.private_key.val)
          formData.append('image', $('input[type=file]')[0].files[0])
          formData.append('_token', $('input[name=_token]').val())

          $.ajax({
            type: 'POST',
            url: '/decrypt',

            data: formData,
            cache: false,
            contentType: false,
            processData: false,

            success: function(data) {
              this.errorDecrypt.status = false
              this.step = 3;
              this.shadowStep = 3;
              this.cipherkey = data.data.cipherkey
              this.ciphertext = data.data.ciphertext
              this.key.val = data.data.key
              this.message.val = data.data.message
              this.isLoading = false
            }.bind(this),
            error: function(data) {
              this.errorDecrypt.status = true
              console.log(data)
              this.errorDecrypt.message = `${data.responseJSON.message} <br/>`;
              this.errorDecrypt.message += "<ul class='list-disc ml-5'>";
              for (const val in data.responseJSON.errors) {
                this.errorDecrypt.message += `<li>${data.responseJSON.errors[val]}</li>`;
              }
              this.errorDecrypt.message += "</ul>";

              this.isLoading = false;
            }.bind(this)
          });
        });
      },
      renewToken() {
        var csrfUrl = '/refresh_csrf';

        $.get(csrfUrl, function(data) {
          $('meta[name="csrf-token"]').attr('content', data);
        });
        return;
      },

      changeStep(to) {
        if (to <= this.step) this.shadowStep = to;
      },

      fileChosen(event) {
        this.fileToDataUrl(event, src => this.imageUrl = src)
        console.log(event.target.files)
      },
      fileToDataUrl(event, callback) {
        if (!event.target.files.length) return
        let status = true;
        let file = event.target.files[0],

          reader = new FileReader()
        reader.readAsDataURL(file)
        reader.onload = function(e) {
          img = new Image();
          img.src = e.target.result;
          min = this.min;
          img.onload = function() {
            if (img.width < this.min || img.height < this.min) this.imageError = 'Gambar terlalu kecil'
            else this.imageError = ''
          }.bind(this)

          callback(e.target.result)

        }.bind(this)
      },

    }
  }
</script>
@endsection