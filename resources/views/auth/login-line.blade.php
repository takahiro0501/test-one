<x-default-layout>
  <div class="line-login-box">
    <div class="line-login-title">
      <h1>{{ __('sentences.user_login_line.title') }}</h1>
    </div>
    <form method="POST" action="{{ route('reservation.login.line.exe') }}">
      @csrf
            <div class="line-login-parts">
                <div class="line-login-label">
                    <label for="lastname">
                        <sapn class="line-login-require">{{ __('sentences.user_login_line.require') }}</sapn>
                        {{ __('sentences.user_login_line.lastname') }}
                    </label>
                </div>
                <input class="line-login-input" id="lastname" type="text" name="lastname" value="{{ old('lastname') }}" placeholder="例）山田" autofocus />
                @if ($errors->has('lastname'))
                    <div class="line-login-error">
                        {{$errors->first('lastname')}}
                    </div>
                @endif
            </div>
            <div class="line-login-parts">
                <div class="line-login-label">
                    <label for="firstname">
                        <span class="line-login-require">{{ __('sentences.user_login_line.require') }}</span>
                      {{ __('sentences.user_login_line.firstname') }}
                    </label>
                </div>
                <input class="line-login-input" id="firstname" type="text" name="firstname" value="{{ old('firstname') }}"  placeholder="例）太郎"/>
                @if ($errors->has('firstname'))
                <div class="line-login-error">
                    {{$errors->first('firstname')}}
                </div>
                @endif
            </div>
      <div class="line-login-parts">
        <p class="line-login-label">
          <label for="tel">
            <span class="line-login-require">{{ __('sentences.user_login_line.require') }}</span>
            {{ __('sentences.user_login_line.tel') }}
          </label>
        </p>
        <input  class="line-login-input" 
                id="tel" 
                type="tel" 
                name="tel" 
                value="{{ old('tel') }}" 
                placeholder="例) 0123456789"
        />
        @if ($errors->has('tel'))
          <div class="line-login-error">
            {{$errors->first('tel')}}
          </div>
        @endif
      </div>
      <input type="hidden" name="date" value="{{ old('date',$date) }}"></input>
      <input type="hidden" name="time" value="{{ old('time', $time) }}"></input>
      <input type="hidden" name="staff" value="{{ old('staff',$staff) }}"></input>
      <input type="hidden" name="staffName" value="{{ old('staffName',$staffName) }}"></input>
      <input type="hidden" name="menu" value="{{ old('menu',$menu) }}"></input>
      <input type="hidden" name="menuName" value="{{ old('menuName',$menuName) }}"></input>
      <input type="hidden" name="line" value="{{ old('line',$line) }}"></input>
      <div class="line-login-btn">
          <button type="submit">{{ __('sentences.user_login_line.btn') }}</button>
      </div>
    </form>
  </div>
</x-default-layout>
