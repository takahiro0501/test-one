<x-default-layout>
  <div class="confirm-box">
    <div class="confirm-title">
      <h1>{{ __('sentences.user_confirm.title') }}</h1>
    </div>
    <div class="confirm-item">
      <div class="confirm-date">
        <p>{{ \Carbon\Carbon::create($date. ' ' .$time)->format('Y年n月j日  H時i分') }}</p>
      </div>
      <div class="confirm-menu">
        <p>{{ $menuName }}</p>
      </div>
      <div class="confirm-staff">
        <p>{{ $staffName }}</p>
      </div>
      <form action="{{ route('reservation.confirmExe') }}" method="post">
        @csrf
        <input type="hidden" name="user" value="{{ Auth::id() }}"></input>
        <input type="hidden" name="date" value="{{ $date }}"></input>
        <input type="hidden" name="time" value="{{ $time }}"></input>
        <input type="hidden" name="staff" value="{{ $staff }}"></input>
        <input type="hidden" name="menu" value="{{ $menu }}"></input>
        <input type="hidden" name="staffName" value="{{ $staffName }}"></input>
        <input type="hidden" name="menuName" value="{{ $menuName }}"></input>
        <div class="confirm-btn">
          <button>{{ __('sentences.user_confirm.btn') }}</button>
        </div>
      </form>
    </div>
  </div>
</x-default-layout>
