@extends('layouts.app')
@section('title', 'Encrypt Message')
@section('script-footer')

<script src="https://cdn.jsdelivr.net/npm/@ryangjchandler/alpine-clipboard@0.1.x/dist/alpine-clipboard.umd.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
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
  <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 min-h-screen" x-data="encryptState()">
    <!-- Replace with your content -->
    <ul class="w-full steps grid grid-cols-3">
      <li @click="changeStep(1)" class="step step-info">Encryption</li>
      <li @click="changeStep(2)" class="step " :class="{'step-info': step>1}">Steganography</li>
      <li @click="changeStep(3)" class="step " :class="{'step-info': step>2}">Results</li>
    </ul>
    <div class="px-4 py-6 sm:px-0 grid grid-cols-1 md:grid-cols-3 gap-2 relative overflow-x-hidden h-full">
      <x-encrypt.step1></x-encrypt.step1>
      <x-encrypt.step2></x-encrypt.step2>
      <x-encrypt.step3></x-encrypt.step3>
    </div>
  </div>
</main>
<script>
  function encryptState() {
    return {
      encrypt_id: 0,
      errorEncrypt: {
        status: false,
        message: '',
      },
      p: {
        val: '',
        error: ''
      },
      q: {
        val: '',
        error: ''
      },
      key: {
        val: '',
        error: ''
      },
      message: {
        val: '',
        error: ''
      },
      N: '',
      r: '',
      candidates: [],
      k: '',
      factorK: {
        val: '',
        error: ''
      },
      public_key: {
        t: '',
        val: ''
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
      encryptedImageUrl: '',
      encryptedImageName: '',
      min: '',
      minimumImg: '',
      isLoading: false,
      stepRSA: 1,
      step: 1,
      shadowStep: 1,
      init: function() {
        @isset($data)
        let data = `{!! json_encode($data) !!}`;
        data = JSON.parse(data)

        this.encrypt_id = data.id
        console.log(data.message)
        this.key.val = data.key
        this.message.val = data.message
        this.p.val = data.p
        this.q.val = data.q
        this.N = this.p.val * this.q.val;
        this.r = (this.p.val - 1) * (this.q.val - 1)
        this.k = data.k
        this.factorK.val = data.factor_k
        this.public_key.val = data.public_key
        this.private_key.val = data.private_key
        this.stepRSA = 3
        this.getCandidates()
        this.cipherkey = data.cipherkey
        this.ciphertext = data.ciphertext
        this.imageUrl = ((data.original_img)) ? `/storage/${data.original_img}` : ''
        this.step = ((data.original_img)) ? 3 : 2
        this.shadowStep = ((data.original_img)) ? 3 : 2

        this.encryptedImageUrl = (data.encrypted_img) ? `/storage/${data.encrypted_img}` : ''
        this.encryptedImageName = (data.encrypted_img) ? data.encrypted_img : ''
        @endisset

        this.$refs.encryptBtn.addEventListener("click", (e) => {
          if (!this.k) return this.factorK.error = "Silahkan pilih K terlebih dahulu";
          this.isLoading = true;
          this.factorK.error = "";

          this.factorize(this.k)
          if (this.factorK.error) return;
          $.ajax({
            type: 'POST',
            url: '/encrypt',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
              encrypt_id: this.encrypt_id,
              key: this.key.val,
              message: this.message.val,
              p: this.p.val,
              q: this.q.val,
              k: this.k,
              factor_k: this.factorK.val,
              public_key: this.public_key.val,
              private_key: this.private_key.val,
              _token: "{{ csrf_token() }}",
            },
            success: function(data) {
              this.errorEncrypt.status = false;
              this.encrypt_id = data.data.encrypt_id
              this.cipherkey = data.data.cipherkey
              this.ciphertext = data.data.ciphertext
              m = Math.ceil(Math.sqrt(((this.cipherkey.length > this.ciphertext.length) ? this.cipherkey.length : this.ciphertext.length) * 8))
              this.min = m;
              this.minimumImg = `${m}x${m} px`;
              this.stepRSA++;
              this.step = 2;
              this.shadowStep = 2;
              $("#triggerUp").click();
            }.bind(this),
            error: function(data) {
              this.errorEncrypt.status = true
              this.errorEncrypt.message = `${data.responseJSON.message} <br/>`;
              this.errorEncrypt.message += "<ul class='list-disc ml-5'>";
              for (const val in data.responseJSON.errors) {
                this.errorEncrypt.message += `<li>${data.responseJSON.errors[val]}</li>`;
              }
              this.errorEncrypt.message += "</ul>";
            }.bind(this)
          });
          this.isLoading = false;
        });
        this.$refs.steganoBtn.addEventListener("click", (e) => {
          e.preventDefault();
          var formData = new FormData();

          this.isLoading = true
          this.renewToken()
          token = $('meta[name="csrf-token"]').attr('content');
          formData.append('encrypt_id', this.encrypt_id)
          formData.append('image', $('input[type=file]')[0].files[0])
          formData.append('_token', token)
          console.log(formData)

          $.ajax({
            type: 'POST',
            url: '/encrypt/stegano',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            // data: {
            //   encrypt_id: this.encrypt_id,
            //   _token: token
            // },
            success: function(data) {
              this.step = 3;
              this.shadowStep = 3;
              this.encryptedImageUrl = `/storage/${data.data.encrypted_img}`;
              this.encryptedImageName = data.data.encrypted_img
              this.isLoading = false
            }.bind(this),
            error: function(data) {
              //

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
      isPrime(num) {
        for (var i = 2; i < num; i++)
          if (num % i === 0) return false;
        return num > 1;
      },
      changeStep(to) {
        if (to <= this.step) this.shadowStep = to;
      },
      processPQ() {
        this.isLoading = true;
        this.key.error = !this.key.val ? "Key tidak boleh kosong" : '';
        this.message.error = !this.message.val ? "Message tidak boleh kosong" : '';
        this.p.error = !this.p.val ? "p tidak boleh kosong" : !this.isPrime(this.p.val) ? "Bilangan p bukan prima" : '';
        this.q.error = !this.q.val ? "q tidak boleh kosong" : !this.isPrime(this.q.val) ? "Bilangan q bukan prima" : '';

        this.isLoading = false;
        if (!this.p.error && !this.q.error && !this.key.error && !this.message.error) {
          this.stepRSA++;
          this.processCandidates();
        }
      },
      processCandidates() {
        this.N = this.p.val * this.q.val;
        this.r = (this.p.val - 1) * (this.q.val - 1)
        this.getCandidates();
      },
      //Menentukan kandidat l mod r
      getCandidates() {
        this.candidates = [];
        i = 1;
        while (this.candidates.length < 50) {
          _can = ((this.r * i) + 1);
          if (!this.isPrime(_can)) this.candidates.push(_can);
          i++;
        }
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
      factorize(num) {
        this.factorK.val = "";
        t = num;
        prime = true;

        i = 1
        while ((t > 1) && (++i < Math.sqrt(num) + 1)) {
          while (this.mod(t, i) == 0) {
            t = t / i;
            this.private_key.t = this.factorK.val;
            this.public_key.t = i;

            if (!prime) this.factorK.val += "*";
            if (prime) prime = false;
            this.factorK.val += i;
          }
        }


        if (prime) {
          this.factorK.error = num + " is prime.";
        } else if (t > 1) {
          this.private_key.t = t;
          this.factorK.val += "*" + t;
        }

        this.private_key.val = `\{${this.private_key.t}, ${this.N}\}`;
        this.public_key.val = `\{${this.public_key.t}, ${this.N}\}`;
      },
      mod(a, b) {
        return a - b * Math.floor(a / b);
      }
    }
  }
</script>
@endsection