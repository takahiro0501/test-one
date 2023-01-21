<x-default-layout>
    <div class="password-reset-box">
        <div class="password-reset-title">
            <h1>{{ __('sentences.user_password_reset.title') }}</h1>
        </div>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div>
                <div class="password-reset-parts">
                    <p class="password-reset-label">
                        <label for="email">{{ __('sentences.user_password_reset.input') }}</label>
                    </p>
                    <input class="password-reset-input" id="email" type="email" name="email" value="{{ old('email') }}" autofocus />
                    @if ($errors->has('email'))
                        <div class="password-reset-error">
                            {{$errors->first('email')}}
                        </div>
                    @endif
                </div>
            </div>
            <input type="hidden" name="date" value="{{ old('date', $date) }}"></input>
            <input type="hidden" name="time" value="{{ old('time', $time) }}"></input>
            <input type="hidden" name="staff" value="{{ old('staff', $staff) }}"></input>
            <input type="hidden" name="staffName" value="{{ old('staffName', $staffName) }}"></input>
            <input type="hidden" name="menu" value="{{ old('menu', $menu) }}"></input>
            <input type="hidden" name="menuName" value="{{ old('menuName', $menuName) }}"></input>
            <div class="password-reset-btn">
                <button type="submit">{{ __('sentences.user_password_reset.btn') }}</button>
            </div>
        </form>
    </div>
</x-default-layout>




