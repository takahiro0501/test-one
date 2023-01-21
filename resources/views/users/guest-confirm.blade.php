<x-default-layout>
  <div class="guest-box">
    <div class="guest-title">
      <h1>{{ __('sentences.user_guest.title') }}</h1>
    </div>
    <div class="guest-item">
      <div class="guest-date">
        <p>{{ \Carbon\Carbon::create(old('date',$date). ' ' .old('time',$time))->format('Y年n月j日  H時i分') }}</p>
      </div>
      <div class="guest-menu">
        <p>{{ old('menuName',$menuName) }}</p>
      </div>
      <div class="guest-staff">
        <p>{{ old('staffName',$staffName) }}</p>
      </div>
      <div class="guest-sentence">
        <p>{{ __('sentences.user_guest.sentence') }}</p>
      </div>
      <form action="{{ route('reservation.guestExe') }}" method="post">
        @csrf
        <div class="guest-item">
          <div class="guest-parts">
            <input class="guest-input" id="lastname" type="text" name="lastname" value="{{ old('lastname') }}" placeholder="お名前（姓）" autofocus />
            @if ($errors->has('lastname'))
              <div class="guest-error">
                  {{$errors->first('lastname')}}
              </div>
            @endif
          </div>
          <div class="guest-parts">
            <input class="guest-input" id="firstname" type="text" name="firstname" value="{{ old('firstname') }}"  placeholder="お名前（名）"/>
            @if ($errors->has('firstname'))
            <div class="guest-error">
                {{$errors->first('firstname')}}
            </div>
            @endif
          </div>
          <div class="guest-parts">
            <input class="guest-input" id="phone" type="text" name="phone" value="{{ old('phone') }}"  placeholder="電話番号" />
            @if ($errors->has('phone'))
                <div class="guest-error">
                    {{$errors->first('phone')}}
                </div>
            @endif
          </div>
        <input type="hidden" name="date" value="{{ old('date',$date) }}"></input>
        <input type="hidden" name="time" value="{{ old('time',$time) }}"></input>
        <input type="hidden" name="staff" value="{{ old('staff',$staff) }}"></input>
        <input type="hidden" name="menu" value="{{ old('menu',$menu) }}"></input>
        <input type="hidden" name="staffName" value="{{ old('staffName',$staffName) }}"></input>
        <input type="hidden" name="menuName" value="{{ old('menuName',$menuName) }}"></input>
        <div class="guest-btn">
          <button>{{ __('sentences.user_guest.btn') }}</button>
        </div>
      </form>
    </div>
  </div>
</x-default-layout>
