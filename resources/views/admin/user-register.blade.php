<x-admin-layout>
    <div class="register-box">
        <div class="register-title">
            <h1>{{ __('sentences.user_register.title') }}</h1>
        </div>
        <form method="POST" action="{{ route('admin.user.registerExe') }}">
            @csrf

            <div class="register-parts">
                <div class="register-label">
                    <label for="karte">
                        <span class="register-notrequire">任意</span>
                        {{ __('sentences.user_register.karte') }}
                    </label>
                </div>
                <input class="register-input" id="karte" type="text" name="karte" value="{{ old('karte') }}"/>
                @if ($errors->has('karte'))
                    <div class="register-error">
                        {{$errors->first('karte')}}
                    </div>
                @endif
            </div>

            <div class="register-parts">
                <div class="register-label">
                    <label for="lastname">
                        <span class="register-require">{{ __('sentences.user_register.require') }}</span>
                        {{ __('sentences.user_register.lastname') }}
                    </label>
                </div>
                <input class="register-input" id="lastname" type="text" name="lastname" value="{{ old('lastname') }}" placeholder="例）山田"/>
                @if ($errors->has('lastname'))
                    <div class="register-error">
                        {{$errors->first('lastname')}}
                    </div>
                @endif
            </div>
            <div class="register-parts">
                <div class="register-label">
                    <label for="firstname">
                        <span class="register-require">{{ __('sentences.user_register.require') }}</span>
                        {{ __('sentences.user_register.firstname') }}
                    </label>
                </div>
                <input class="register-input" id="firstname" type="text" name="firstname" value="{{ old('firstname') }}"  placeholder="例）太郎"/>
                @if ($errors->has('firstname'))
                <div class="register-error">
                    {{$errors->first('firstname')}}
                </div>
                @endif
            </div>
            <div class="register-parts">
                <p class="register-label"><label for="lastnamekana">{{ __('sentences.user_register.lastnamekana') }}</label></p>
                <input class="register-input" id="lastnamekana" type="text" name="lastnamekana" value="{{ old('lastnamekana' ) }}" placeholder="例）ヤマダ"/>
                @if ($errors->has('lastnamekana'))
                    <div class="register-error">
                        {{$errors->first('lastnamekana')}}
                    </div>
                @endif
            </div>
            <div class="register-parts">
                <p class="register-label"><label for="firstnamekana">{{ __('sentences.user_register.firstnamekana') }}</label></p>
                <input class="register-input" id="firstnamekana" type="text" name="firstnamekana" value="{{ old('firstnamekana') }}"  placeholder="例）タロウ"/>
                @if ($errors->has('firstnamekana'))
                <div class="register-error">
                    {{$errors->first('firstnamekana')}}
                </div>
                @endif
            </div>
            <div class="register-parts">
                <p class="register-label"><label for="gender">{{ __('sentences.user_register.gender') }}</label></p>
                <input type="radio" id="gender0" name="gender" value="2" {{ old('gender',2) == 2 ? 'checked' : '' }}><label for="gender0" class="radio">未選択</label>
                <input type="radio" id="gender1" name="gender" value="0" {{ old('gender',2) == 0 ? 'checked' : '' }}><label for="gender1" class="radio">男性</label>
                <input type="radio" id="gender2" name="gender" value="1" {{ old('gender',2) == 1 ? 'checked' : '' }}><label for="gender2" class="radio">女性</label>
            </div>
            <div class="register-parts">
                <p class="register-label"><label for="birth">{{ __('sentences.user_register.birth') }}</label></p>
                <input class="register-input" id="birth" type="date" name="birth" value="{{ old('birth') }}"/>
                @if ($errors->has('birth'))
                <div class="register-error">
                    {{$errors->first('birth')}}
                </div>
                @endif
            </div>
            <div class="register-parts">
                <p class="register-label"><label for="postcode">{{ __('sentences.user_register.postcode') }}</label></p>
                <input class="register-input" id="postcode" type="text" name="postcode" value="{{ old('postcode') }}"/>
                @if ($errors->has('postcode'))
                <div class="register-error">
                    {{$errors->first('postcode')}}
                </div>
                @endif
            </div>
            <div class="register-parts">
                <p class="register-label"><label for="prefectures">{{ __('sentences.user_register.prefectures') }}</label></p>
                <select class="register-prefectures" name="prefecture">
                    @foreach(config('pref') as $pref_id => $name)
                        <option value="{{ $name }}" {{ old('prefecture','') === $name  ? "selected" : ""}}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="register-parts">
                <p class="register-label"><label for="city">{{ __('sentences.user_register.city') }}</label></p>
                <input class="register-input" id="city" type="text" name="city" value="{{ old('city') }}"/>
                @if ($errors->has('city'))
                <div class="register-error">
                    {{$errors->first('city')}}
                </div>
                @endif
            </div>
            <div class="register-parts">
                <p class="register-label"><label for="address">{{ __('sentences.user_register.address') }}</label></p>
                <input class="register-input" id="address" type="text" name="address" value="{{ old('address') }}"/>
                @if ($errors->has('address'))
                <div class="register-error">
                    {{$errors->first('address')}}
                </div>
                @endif
            </div>
            <div class="register-parts">
                <div class="register-label">
                    <label for="tel">
                        <span class="register-require">{{ __('sentences.user_register.require') }}</span>
                        {{ __('sentences.user_register.tel') }}
                    </label>
                </div>
                <input class="register-input" id="phone" type="tel" name="phone" value="{{ old('phone') }}" placeholder="例）090000000"/>
                @if ($errors->has('phone'))
                <div class="register-error">
                    {{$errors->first('phone')}}
                </div>
                @endif
            </div>
            <div class="register-parts">
                <p class="register-label"><label for="cellphone">{{ __('sentences.user_register.phone') }}</label></p>
                <input class="register-input" id="cellphone" type="tel" name="cellphone" value="{{ old('cellphone') }}"  placeholder="例）000000000"/>
                @if ($errors->has('cellphone'))
                <div class="register-error">
                    {{$errors->first('cellphone')}}
                </div>
                @endif
            </div>
            <div class="register-parts">
                <div class="register-label">
                    <label for="email">
                        <span class="register-notrequire">任意</span>
                        {{ __('sentences.user_register.email') }}
                    </label>
                </div>
                <input class="register-input" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="例）xxx@rairacu.co.jp"/>
                @if ($errors->has('email'))
                <div class="register-error">
                    {{$errors->first('email')}}
                </div>
                @endif
            </div>
            <div class="register-parts">
                <div class="register-label">
                    <label for="password">
                        <span class="register-notrequire">任意</span>
                        {{ __('sentences.user_register.password') }}
                    </label>
                </div>
                <input class="register-input" id="password" type="password" name="password" value="" placeholder="8文字以上を入力"/>
                @if ($errors->has('password'))
                <div class="register-error">
                    {{$errors->first('password')}}
                </div>
                @endif
            </div>
            <div class="register-btn">
                <button type="submit">{{ __('sentences.user_register.btn') }}</button>
            </div>
        </form>
        <div class="register-back">
            <a href="{{ route('admin.user') }}">{{ __('sentences.admin_reservation_edit.back') }}</a></button>
        </div>
    </div>
</x-admin-layout>
