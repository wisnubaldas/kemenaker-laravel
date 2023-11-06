<x-guest-layout>
    <section>
        <div>
            <div class="logo-wrapper">
                <img src="/images/kemnaker-logo.png" alt="kemnaker" width="200px">
                <img src="/images/ukpbj-logo.png" alt="ukpbj" width="80px">
            </div>

           

            <form id="w0" class="login-form" method="POST" action="{{ route('submitlogin') }}">
                @csrf
                @if (session('error'))
              <div class="text-danger text-center">{{ session('error') }}</div>
              
            @endif
                <h4 class="text-center f-bold">SIPNAKER</h4>
                <div class="form-group field-loginform-username required has-success">
                    <input type="text" id="loginform-username" class="form-control" name="username"
                        :value="old('username')" required autofocus placeholder="Username" autocomplete="Username"
                        aria-required="true" aria-invalid="false">

                    <p :messages="$errors - > get('username')" class="mt-2"></p>
                </div>
                <div class="form-group field-loginform-password required has-success">

                    <input type="password" id="loginform-password" class="form-control" name="password" value=""
                        placeholder="Password" aria-required="true" aria-invalid="false">

                    <p :messages="$errors - > get('password')" class="mt-2">
                </div>
                <button type="submit" class="f-med">Login</button>
            </form>
        </div>
        <div class="login-hero">
            <img src="/images/login-img.svg" alt="illustration">
            <h1 class="f-bold">Sistem Informasi Pengadaan<br> Barang Jasa Kementerian</h1>
        </div>
    </section>
</x-guest-layout>
