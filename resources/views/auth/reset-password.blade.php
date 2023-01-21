<x-default-layout>
    <div class="password-update-box">
    <div class="password-update-title">
        <h1>{{ __('sentences.user_password_update.title') }}</h1>
    </div>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <div class="password-update-parts">
            <p class="password-update-label"><label for="password">{{ __('sentences.user_password_update.email') }}</label></p>
            <input class="password-update-input readonly" id="email" type="text" name="email" value="{{ old('email',$request->email) }}" readonly />
        </div>
        <div class="password-update-parts">
            <p class="password-update-label"><label for="password">{{ __('sentences.user_password_update.password') }}</label></p>
            <input class="password-update-input" id="password" type="password" name="password" autofocus />
            @if ($errors->has('password'))
                <div class="password-update-error">
                    {{$errors->first('password')}}
                </div>
            @endif
        </div>
        <div class="password-update-parts">
            <p class="password-update-label"><label for="password_confirmation">{{ __('sentences.user_password_update.comfirm') }}</label></p>
            <input class="password-update-input" id="password_confirmation" type="password" name="password_confirmation"/>
            @if ($errors->has('password_confirmation'))
                <div class="password-update-error">
                    {{$errors->first('password_confirmation')}}
                </div>
            @endif
        </div>
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <input type="hidden" name="id" value="{{ $request->id }}">
        <div class="password-update-btn">
            <button type="submit">{{ __('sentences.user_password_update.btn') }}</button>
        </div>

    </form>

    </div>
</x-default-layout>
