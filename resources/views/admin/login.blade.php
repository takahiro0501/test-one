<x-admin-layout>
  <div class="admin-login-box">
    <div class="admin-login-title">
      <h1>{{ __('sentences.admin_login.title') }}</h1>
    </div>
    <form method="post" action="{{ route('admin.login') }}">
      @csrf
      <div class="admin-login-parts">
        <input  placeholder="メールアドレス" class="admin-login-input" id="email" type="text" name="email" value="{{ old('email') }}" autofocus />
        @if ($errors->has('email'))
          <div class="admin-login-error">
            {{$errors->first('email')}}
          </div>
        @endif
      </div>
      <div class="admin-login-parts">
        <input placeholder="パスワード" class="admin-login-input" id="password" type="password"  name="password" autocomplete="current-password" />
        @if ($errors->has('password'))
          <div class="admin-login-error">
            {{$errors->first('password')}}
          </div>
        @endif
      </div>
        @if ($errors->has('authfail'))
          <div class="admin-login-error">
            {{$errors->first('authfail')}}
          </div>
        @endif
      <div class="admin-login-btn">
          <button type="submit">{{ __('sentences.admin_login.btn') }}</button>
      </div>
    </form>
  </div>
</x-admin-layout>
