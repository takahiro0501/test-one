<x-default-layout>
  <div class="karte-login-box">
    <div class="karte-login-title">
      <h1>{{ __('sentences.user_login_karte.title') }}</h1>
    </div>
    <form method="POST" action="{{ route('login.karte') }}">
      @csrf
      <div class="karte-login-parts">
        <p class="karte-login-label">
          <label for="karte_no">
            {{ __('sentences.user_login_karte.no') }}
          </label>
        </p>
        <input  class="karte-login-input"
                id="karteno" 
                type="text" 
                name="karte_no" 
                value="{{ old('karte_no') }}" 
                autofocus 
        />
        @if ($errors->has('karte_no'))
          <div class="karte-login-error">
            {{$errors->first('karte_no')}}
          </div>
        @endif
      </div>
      <div class="karte-login-parts">
        <p class="karte-login-label">
          <label for="lastname">
            {{ __('sentences.user_login_karte.lastname') }}
          </label>
        </p>
        <input  class="karte-login-input" 
                id="lastname" 
                type="text" 
                name="lastname" 
                value="{{ old('lastname') }}" 
                autofocus 
        />
        @if ($errors->has('lastname'))
          <div class="karte-login-error">
            {{$errors->first('lastname')}}
          </div>
        @endif
      </div>
      <div class="karte-login-parts">
        <p class="karte-login-label">
          <label for="firstname">
            {{ __('sentences.user_login_karte.firstname') }}
          </label>
        </p>
        <input  class="karte-login-input" 
                id="firstname" 
                type="text" 
                name="firstname" 
                value="{{ old('firstname') }}" 
                autofocus 
        />
        @if ($errors->has('firstname'))
          <div class="karte-login-error">
            {{$errors->first('firstname')}}
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
        <div class="karte-login-error">
          {{$errors->first('authfail')}}
        </div>
      @endif
      <div class="karte-login-btn">
          <button type="submit">{{ __('sentences.user_login_karte.btn') }}</button>
      </div>
    </form>
  </div>
</x-default-layout>
