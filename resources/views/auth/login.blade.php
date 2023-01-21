<x-default-layout>
  <div class="login-box">
    <div class="login-title">
      <h1>{{ __('sentences.user_login.login') }}</h1>
    </div>
    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="login-parts">
        <input class="login-input" id="email"  placeholder="メールアドレス"  type="text" name="email" value="{{ old('email') }}" placeholder="メールアドレス" autofocus />
        @if ($errors->has('email'))
          <div class="login-error">
            {{$errors->first('email')}}
          </div>
        @endif
      </div>
      <div class="login-parts">
        <input class="login-input" id="password"  placeholder="パスワード" type="password"  name="password" autocomplete="current-password" placeholder="パスワード" />
        @if ($errors->has('password'))
          <div class="login-error">
            {{$errors->first('password')}}
          </div>
        @endif
      </div>
      <input type="hidden" name="date" value="{{ old('date',$date) }}"></input>
      <input type="hidden" name="time" value="{{ old('time', $time) }}"></input>
      <input type="hidden" name="staff" value="{{ old('staff',$staff) }}"></input>
      <input type="hidden" name="staffName" value="{{ old('staffName',$staffName) }}"></input>
      <input type="hidden" name="menu" value="{{ old('menu',$menu) }}"></input>
      <input type="hidden" name="menuName" value="{{ old('menuName',$menuName) }}"></input>
        @if ($errors->has('authfail'))
          <div class="login-error">
            {{$errors->first('authfail')}}
          </div>
        @endif
      <div class="login-btn">
          <button type="submit">{{ __('sentences.user_login.btn') }}</button>
      </div>
    </form>
    <div class="login-line">
      <form action="{{ route('reservation.login.line.redirect') }}" method="POST">
        @csrf
        <input type="hidden" name="date" value="{{ $date }}"></input>
        <input type="hidden" name="time" value="{{ $time }}"></input>
        <input type="hidden" name="staff" value="{{ $staff }}"></input>
        <input type="hidden" name="staffName" value="{{ $staffName }}"></input>
        <input type="hidden" name="menu" value="{{ $menu }}"></input>
        <input type="hidden" name="menuName" value="{{ $menuName }}"></input>
        <div class="login-btn">
          <button type="submit">{{ __('sentences.user_login.line') }}</button>
        </div>
      </form>
    </div>
    <div class="login-karteno">
      <form action="{{ route('reservation.loginKarte') }}" method="POST">
        @csrf
        <input type="hidden" name="date" value="{{ $date }}"></input>
        <input type="hidden" name="time" value="{{ $time }}"></input>
        <input type="hidden" name="staff" value="{{ $staff }}"></input>
        <input type="hidden" name="staffName" value="{{ $staffName }}"></input>
        <input type="hidden" name="menu" value="{{ $menu }}"></input>
        <input type="hidden" name="menuName" value="{{ $menuName }}"></input>
        <input type="hidden" name="karteno" value="true"></input>
        <div class="login-btn">
          <button type="submit">{{ __('sentences.user_login.karteno') }}</button>
        </div>
      </form>
    </div>
    <div class="login-guest">
      <form action="{{ route('reservation.guest') }}" method="POST">
        @csrf
        <input type="hidden" name="date" value="{{ $date }}"></input>
        <input type="hidden" name="time" value="{{ $time }}"></input>
        <input type="hidden" name="staff" value="{{ $staff }}"></input>
        <input type="hidden" name="staffName" value="{{ $staffName }}"></input>
        <input type="hidden" name="menu" value="{{ $menu }}"></input>
        <input type="hidden" name="menuName" value="{{ $menuName }}"></input>
        <div class="login-btn">
          <button type="submit">{{ __('sentences.user_login.guest') }}</button>
        </div>
      </form>
    </div>
    <hr>
    <form action="{{ route('reservation.register') }}" method="POST">
      @csrf
      <input type="hidden" name="date" value="{{ $date }}"></input>
      <input type="hidden" name="time" value="{{ $time }}"></input>
      <input type="hidden" name="staff" value="{{ $staff }}"></input>
      <input type="hidden" name="staffName" value="{{ $staffName }}"></input>
      <input type="hidden" name="menu" value="{{ $menu }}"></input>
      <input type="hidden" name="menuName" value="{{ $menuName }}"></input>
      <div class="login-link">
        <button type="submit" >{{ __('sentences.user_login.register') }}</button>
        <p class="login-attention">{{ __('sentences.user_login.attention') }}</p>
      </div>
    </form>
    <div class="password-forget">
      <form action="{{ route('password.request') }}" method="POST">
        @csrf
        <input type="hidden" name="date" value="{{ $date }}"></input>
        <input type="hidden" name="time" value="{{ $time }}"></input>
        <input type="hidden" name="staff" value="{{ $staff }}"></input>
        <input type="hidden" name="staffName" value="{{ $staffName }}"></input>
        <input type="hidden" name="menu" value="{{ $menu }}"></input>
        <input type="hidden" name="menuName" value="{{ $menuName }}"></input>
        <div class="login-link">
          <button type="submit">{{ __('sentences.user_login.foget') }}</button>
        </div>
      </form>
    </div>
  </div>
</x-default-layout>
