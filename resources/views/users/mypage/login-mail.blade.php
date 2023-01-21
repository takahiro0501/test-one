<x-default-layout>
  <div class="mypage-mail-login-box">
    <div class="mypage-mail-login-title">
      <h1>{{ __('sentences.user_mypage_mail.title') }}</h1>
    </div>
    <form method="POST" action="{{ route('reservation.mypage.mail.login') }}">
      @csrf
      <div class="mypage-mail-login-parts">
        <p class="mypage-mail-login-label"><label for="email">{{ __('sentences.user_mypage_mail.email') }}</label></p>
        <input class="mypage-mail-login-input" id="email" type="email" name="email" value="{{ old('email') }}" autofocus />
        @if ($errors->has('email'))
          <div class="mypage-mail-login-error">
            {{$errors->first('email')}}
          </div>
        @endif
      </div>
      <div class="mypage-mail-login-parts">
        <p class="mypage-mail-login-label"><label for="password">{{ __('sentences.user_mypage_mail.password') }}</label></p>
        <input class="mypage-mail-login-input" id="password" type="password"  name="password" autocomplete="current-password" />
        @if ($errors->has('password'))
          <div class="mypage-mail-login-error">
            {{$errors->first('password')}}
          </div>
        @endif
      </div>
      <div class="mypage-mail-login-btn">
          <button type="submit">{{ __('sentences.user_mypage_mail.btn') }}</button>
      </div>
        @if ($errors->has('authfail'))
          <div class="mypage-mail-login-error">
            {{$errors->first('authfail')}}
          </div>
        @endif
    </form>
    <div class="mypage-mail-login-karteno">
      <a href="{{ route('reservation.mypage.karte') }}">{{ __('sentences.user_mypage_mail.karte') }}</a>
    </div>
    <div class="mypage-mail-login-line">
      <a href="{{ route('reservation.mypage.login.line.redirect') }}">{{ __('sentences.user_mypage_mail.line') }}</a>
    </div>
    <div class="mypage-mail-login-password-forget">
      <a href="{{ route('reservation.mypage.password') }}">{{ __('sentences.user_mypage_mail.forget') }}</a>
    </div>
  </div>
</x-default-layout>
