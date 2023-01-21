<x-admin-layout>
    <div class="user-edit-box">
        <div class="user-edit-title">
            <h1>{{ __('sentences.admin_user_edit.title') }}</h1>
        </div>
        <form method="POST" action="{{ route('admin.user.edit.exe') }}">
            @csrf
            <div class="user-edit-parts">
                <div class="user-edit-label">
                    <label for="karte">
                        <span class="user-edit-notrequire">任意</span>
                        {{ __('sentences.admin_user_edit.karte') }}
                    </label>
                </div>
                <input class="user-edit-input" id="karte" type="text" name="karte" value="{{ old('karte', $user->karte_no) }}"/>
                @if ($errors->has('karte'))
                    <div class="user-edit-error">
                        {{$errors->first('karte')}}
                    </div>
                @endif
            </div>
            <div class="user-edit-parts">
                <p class="user-edit-label"><label for="first"><span class="user-edit-notrequire">任意</span>{{ __('sentences.admin_user_edit.first') }}</label></p>
                <input class="user-edit-input" id="first" type="date" name="first" value="{{ old('first',$user->first_day) }}"/>
                @if ($errors->has('first'))
                <div class="user-edit-error">
                    {{$errors->first('first')}}
                </div>
                @endif
            </div>
            <div class="user-edit-parts">
                <div class="user-edit-label">
                    <label for="lastname">
                        <span class="user-edit-require">必須</span>
                        {{ __('sentences.admin_user_edit.lastname') }}
                    </label>
                </div>
                <input class="user-edit-input" id="lastname" type="text" name="lastname" value="{{ old('lastname', Str::beforeLast($user->name,' ')) }}"/>
                @if ($errors->has('lastname'))
                    <div class="user-edit-error">
                        {{$errors->first('lastname')}}
                    </div>
                @endif
            </div>
            <div class="user-edit-parts">
                <div class="user-edit-label">
                    <label for="firstname">
                        <span class="user-edit-require">必須</span>
                        {{ __('sentences.admin_user_edit.firstname') }}
                    </label>
                </div>
                <input class="user-edit-input" id="firstname" type="text" name="firstname" value="{{ old('firstname',Str::afterLast($user->name,' ')) }}"/>
                @if ($errors->has('firstname'))
                <div class="user-edit-error">
                    {{$errors->first('firstname')}}
                </div>
                @endif
            </div>

            <div class="user-edit-parts">
                <p class="user-edit-label"><label for="lastnamekana"><span class="user-edit-notrequire">任意</span>{{ __('sentences.admin_user_edit.lastnamekana') }}</label></p>
                <input class="user-edit-input" id="lastnamekana" type="text" name="lastnamekana" value="{{ old('lastnamekana' ,Str::beforeLast($user->name_kana,' ')) }}"/>
                @if ($errors->has('lastnamekana'))
                    <div class="user-edit-error">
                        {{$errors->first('lastnamekana')}}
                    </div>
                @endif
            </div>
            <div class="user-edit-parts">
                <p class="user-edit-label"><label for="firstnamekana"><span class="user-edit-notrequire">任意</span>{{ __('sentences.admin_user_edit.firstnamekana') }}</label></p>
                <input class="user-edit-input" id="firstnamekana" type="text" name="firstnamekana" value="{{ old('firstnamekana',Str::afterLast($user->name_kana,' ')) }}"/>
                @if ($errors->has('firstnamekana'))
                <div class="user-edit-error">
                    {{$errors->first('firstnamekana')}}
                </div>
                @endif
            </div>
            <div class="user-edit-parts">
                <p class="user-edit-label"><label for="gender"><span class="user-edit-notrequire">任意</span>{{ __('sentences.admin_user_edit.gender') }}</label></p>
                <input type="radio" id="gender0" name="gender" value="2" {{ old('gender',2) == 2 ? 'checked' : '' }}><label for="gender0" class="radio">未選択</label>
                <input type="radio" id="gender1" name="gender" value="0" {{ old('gender',2) == 0 ? 'checked' : '' }}><label for="gender1" class="radio">男性</label>
                <input type="radio" id="gender2" name="gender" value="1" {{ old('gender',2) == 1 ? 'checked' : '' }}><label for="gender2" class="radio">女性</label>
            </div>
            <div class="user-edit-parts">
                <p class="user-edit-label"><label for="birth"><span class="user-edit-notrequire">任意</span>{{ __('sentences.admin_user_edit.birth') }}</label></p>
                <input class="user-edit-input" id="birth" type="date" name="birth" value="{{ old('birth',$user->birthday) }}"/>
                @if ($errors->has('birth'))
                <div class="user-edit-error">
                    {{$errors->first('birth')}}
                </div>
                @endif
            </div>
            <div class="user-edit-parts">
                <p class="user-edit-label"><label for="postcode"><span class="user-edit-notrequire">任意</span>{{ __('sentences.admin_user_edit.postcode') }}</label></p>
                <input class="user-edit-input" id="postcode" type="text" name="postcode" value="{{ old('postcode',$user->postcode) }}"/>
                @if ($errors->has('postcode'))
                <div class="user-edit-error">
                    {{$errors->first('postcode')}}
                </div>
                @endif
            </div>
            <div class="user-edit-parts">
                <p class="user-edit-label"><label for="prefectures"><span class="user-edit-notrequire">任意</span>{{ __('sentences.admin_user_edit.prefectures') }}</label></p>
                <select class="user-edit-prefectures" name="prefecture">
                    @foreach(config('pref') as $pref_id => $name)
                        <option value="{{ $name }}" {{ $name == $user->prefecture  ? "selected" : ""}}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="user-edit-parts">
                <p class="user-edit-label"><label for="city"><span class="user-edit-notrequire">任意</span>{{ __('sentences.admin_user_edit.city') }}</label></p>
                <input class="user-edit-input" id="city" type="text" name="city" value="{{ old('city',$user->city) }}"/>
                @if ($errors->has('city'))
                <div class="user-edit-error">
                    {{$errors->first('city')}}
                </div>
                @endif
            </div>
            <div class="user-edit-parts">
                <p class="user-edit-label"><label for="address"><span class="user-edit-notrequire">任意</span>{{ __('sentences.admin_user_edit.address') }}</label></p>
                <input class="user-edit-input" id="address" type="text" name="address" value="{{ old('address',$user->address) }}"/>
                @if ($errors->has('address'))
                <div class="user-edit-error">
                    {{$errors->first('address')}}
                </div>
                @endif
            </div>
            <div class="user-edit-parts">
                <div class="user-edit-label">
                    <label for="phone">
                        <span class="user-edit-require">必須</span>
                        {{ __('sentences.admin_user_edit.tel') }}
                    </label>
                </div>
                <input class="user-edit-input" id="phone" type="tel" name="phone" value="{{ old('phone',$user->phone) }}"/>
                @if ($errors->has('phone'))
                <div class="user-edit-error">
                    {{$errors->first('phone')}}
                </div>
                @endif
            </div>
            <div class="user-edit-parts">
                <p class="user-edit-label"><label for="cellphone"><span class="user-edit-notrequire">任意</span>{{ __('sentences.admin_user_edit.phone') }}</label></p>
                <input class="user-edit-input" id="cellphone" type="tel" name="cellphone" value="{{ old('cellphone',$user->cellphone) }}"/>
                @if ($errors->has('cellphone'))
                <div class="user-edit-error">
                    {{$errors->first('cellphone')}}
                </div>
                @endif
            </div>
            <div class="user-edit-parts">
                <div class="user-edit-label">
                    <label for="email">
                        <span class="user-edit-notrequire">任意</span>
                        {{ __('sentences.admin_user_edit.email') }}
                    </label>
                </div>
                <input class="user-edit-input" id="email" type="email" name="email" value="{{ old('email',$user->email) }}"/>
                @if ($errors->has('email'))
                <div class="user-edit-error">
                    {{$errors->first('email')}}
                </div>
                @endif
            </div>
            <div class="user-edit-parts">
                <div class="user-edit-label">
                    <label for="password">
                        <span class="user-edit-notrequire">任意</span>
                        {{ __('sentences.admin_user_edit.password') }}
                    </label>
                </div>
                <input class="user-edit-input" id="password" type="text" name="password" value="" />
                @if ($errors->has('password'))
                <div class="user-edit-error">
                    {{$errors->first('password')}}
                </div>
                @endif
            </div>
            <input type="hidden" name="id" value="{{ old('id',$user->id) }}"></input>
            <div class="user-edit-btn">
                <button type="submit">{{ __('sentences.admin_user_edit.btn') }}</button>
            </div>
            <div class="user-edit-back">
                <a href="{{ route('admin.user') }}">{{ __('sentences.admin_reservation_edit.back') }}</a></button>
            </div>
        </form>
    </div>
</x-admin-layout>

