<x-admin-layout>
    <div class="user-guest-edit-box">
        <div class="user-guest-edit-title">
            <h1>{{ __('sentences.admin_user_guest_edit.title') }}</h1>
        </div>
        <form method="POST" action="{{ route('admin.user.guest.edit.exe') }}">
            @csrf
            <div class="user-guest-edit-parts">
                <div class="user-guest-edit-label">
                    <label for="karte">
                        <span class="user-guest-edit-notrequire">任意</span>
                        {{ __('sentences.admin_user_guest_edit.karte') }}
                    </label>
                </div>
                <input class="user-guest-edit-input" id="karte" type="text" name="karte" value="{{ old('karte') }}"/>
                @if ($errors->has('karte'))
                    <div class="user-guest-edit-error">
                        {{$errors->first('karte')}}
                    </div>
                @endif
            </div>
            <div class="user-guest-edit-parts">
                <div class="user-guest-edit-label">
                    <label for="lastname">
                        <span class="user-guest-edit-require">必須</span>
                        {{ __('sentences.admin_user_guest_edit.lastname') }}
                    </label>
                </div>
                <input class="user-guest-edit-input" id="lastname" type="text" name="lastname" value="{{ old('lastname', Str::beforeLast($guest->name,' ')) }}"/>
                @if ($errors->has('lastname'))
                    <div class="user-guest-edit-error">
                        {{$errors->first('lastname')}}
                    </div>
                @endif
            </div>
            <div class="user-guest-edit-parts">
                <div class="user-guest-edit-label">
                    <label for="firstname">
                        <span class="user-guest-edit-require">必須</span>
                        {{ __('sentences.admin_user_guest_edit.firstname') }}
                    </label>
                </div>
                <input class="user-guest-edit-input" id="firstname" type="text" name="firstname" value="{{ old('firstname',Str::afterLast($guest->name,' ')) }}"/>
                @if ($errors->has('firstname'))
                <div class="user-guest-edit-error">
                    {{$errors->first('firstname')}}
                </div>
                @endif
            </div>
            <div class="user-guest-edit-parts">
                <p class="user-guest-edit-label"><label for="lastnamekana"><span class="user-guest-edit-notrequire">任意</span>{{ __('sentences.admin_user_guest_edit.lastnamekana') }}</label></p>
                <input class="user-guest-edit-input" id="lastnamekana" type="text" name="lastnamekana" value="{{ old('lastnamekana') }}"/>
                @if ($errors->has('lastnamekana'))
                    <div class="user-guest-edit-error">
                        {{$errors->first('lastnamekana')}}
                    </div>
                @endif
            </div>
            <div class="user-guest-edit-parts">
                <p class="user-guest-edit-label"><label for="firstnamekana"><span class="user-guest-edit-notrequire">任意</span>{{ __('sentences.admin_user_guest_edit.firstnamekana') }}</label></p>
                <input class="user-guest-edit-input" id="firstnamekana" type="text" name="firstnamekana" value="{{ old('firstnamekana') }}"/>
                @if ($errors->has('firstnamekana'))
                <div class="user-guest-edit-error">
                    {{$errors->first('firstnamekana')}}
                </div>
                @endif
            </div>
            <div class="user-guest-edit-parts">
                <p class="user-guest-edit-label"><label for="gender"><span class="user-guest-edit-notrequire">任意</span>{{ __('sentences.admin_user_guest_edit.gender') }}</label></p>
                <input type="radio" id="gender0" name="gender" value="2" {{ old('gender',2) == 2 ? 'checked' : '' }}><label for="gender0" class="radio">未選択</label>
                <input type="radio" id="gender1" name="gender" value="0" {{ old('gender',2) == 0 ? 'checked' : '' }}><label for="gender1" class="radio">男性</label>
                <input type="radio" id="gender2" name="gender" value="1" {{ old('gender',2) == 1 ? 'checked' : '' }}><label for="gender2" class="radio">女性</label>
            </div>
            <div class="user-guest-edit-parts">
                <p class="user-guest-edit-label"><label for="birth"><span class="user-guest-edit-notrequire">任意</span>{{ __('sentences.admin_user_guest_edit.birth') }}</label></p>
                <input class="user-guest-edit-input" id="birth" type="date" name="birth" value="{{ old('birth') }}"/>
                @if ($errors->has('birth'))
                <div class="user-guest-edit-error">
                    {{$errors->first('birth')}}
                </div>
                @endif
            </div>
            <div class="user-guest-edit-parts">
                <p class="user-guest-edit-label"><label for="postcode"><span class="user-guest-edit-notrequire">任意</span>{{ __('sentences.admin_user_guest_edit.postcode') }}</label></p>
                <input class="user-guest-edit-input" id="postcode" type="text" name="postcode" value="{{ old('postcode') }}"/>
                @if ($errors->has('postcode'))
                <div class="user-guest-edit-error">
                    {{$errors->first('postcode')}}
                </div>
                @endif
            </div>
            <div class="user-guest-edit-parts">
                <p class="user-guest-edit-label"><label for="prefectures"><span class="user-guest-edit-notrequire">任意</span>{{ __('sentences.admin_user_guest_edit.prefectures') }}</label></p>
                <select class="user-guest-edit-prefectures" name="prefecture">
                    @foreach(config('pref') as $pref_id => $name)
                        <option value="{{ $name }}" {{ old('prefecture','') === $name  ? "selected" : ""}}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="user-guest-edit-parts">
                <p class="user-guest-edit-label"><label for="city"><span class="user-guest-edit-notrequire">任意</span>{{ __('sentences.admin_user_guest_edit.city') }}</label></p>
                <input class="user-guest-edit-input" id="city" type="text" name="city" value="{{ old('city') }}"/>
                @if ($errors->has('city'))
                <div class="user-guest-edit-error">
                    {{$errors->first('city')}}
                </div>
                @endif
            </div>
            <div class="user-guest-edit-parts">
                <p class="user-guest-edit-label"><label for="address"><span class="user-guest-edit-notrequire">任意</span>{{ __('sentences.admin_user_guest_edit.address') }}</label></p>
                <input class="user-guest-edit-input" id="address" type="text" name="address" value="{{ old('address') }}"/>
                @if ($errors->has('address'))
                <div class="user-guest-edit-error">
                    {{$errors->first('address')}}
                </div>
                @endif
            </div>
            <div class="user-guest-edit-parts">
                <div class="user-guest-edit-label">
                    <label for="phone">
                        <span class="user-guest-edit-require">必須</span>
                        {{ __('sentences.admin_user_guest_edit.tel') }}
                    </label>
                </div>
                <input class="user-guest-edit-input" id="phone" type="tel" name="phone" value="{{ old('phone',$guest->phone) }}"/>
                @if ($errors->has('phone'))
                <div class="user-guest-edit-error">
                    {{$errors->first('phone')}}
                </div>
                @endif
            </div>
            <div class="user-guest-edit-parts">
                <p class="user-guest-edit-label"><label for="cellphone"><span class="user-guest-edit-notrequire">任意</span>{{ __('sentences.admin_user_guest_edit.phone') }}</label></p>
                <input class="user-guest-edit-input" id="cellphone" type="tel" name="cellphone" value="{{ old('cellphone') }}"/>
                @if ($errors->has('cellphone'))
                <div class="user-guest-edit-error">
                    {{$errors->first('cellphone')}}
                </div>
                @endif
            </div>
            <div class="user-guest-edit-parts">
                <div class="user-guest-edit-label">
                    <label for="email">
                        <span class="user-guest-edit-notrequire">任意</span>
                        {{ __('sentences.admin_user_guest_edit.email') }}
                    </label>
                </div>
                <input class="user-guest-edit-input" id="email" type="email" name="email" value="{{ old('email') }}"/>
                @if ($errors->has('email'))
                <div class="user-guest-edit-error">
                    {{$errors->first('email')}}
                </div>
                @endif
            </div>
            <div class="user-guest-edit-parts">
                <div class="user-guest-edit-label">
                    <label for="password">
                        <span class="user-guest-edit-notrequire">任意</span>
                        {{ __('sentences.admin_user_guest_edit.password') }}
                    </label>
                </div>
                <input class="user-guest-edit-input" id="password" type="text" name="password" value="" />
                @if ($errors->has('password'))
                <div class="user-guest-edit-error">
                    {{$errors->first('password')}}
                </div>
                @endif
            </div>
            @if ($errors->has('guestCheck'))
                <div class="user-guest-edit-error">
                    {{$errors->first('guestCheck')}}
                </div>
            @endif
            <input type="hidden" name="id" value="{{ old('id',$guest->id) }}"></input>
            <div class="user-guest-edit-btn">
                <button type="submit">{{ __('sentences.admin_user_guest_edit.btn') }}</button>
            </div>
            <div class="user-guest-edit-back">
                <a href="{{ route('admin.user') }}">{{ __('sentences.admin_reservation_edit.back') }}</a></button>
            </div>
        </form>
    </div>
</x-admin-layout>

