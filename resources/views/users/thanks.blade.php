<x-default-layout>
  <div class="thanks-box">
    <div class="thanks-title">
      <h1>{{ __('sentences.user_thanks.title') }}</h1>
    </div>
    <div class="thanks-item">
      <div class="thanks-date">
        <p>{{ \Carbon\Carbon::create($date. ' ' .$time)->format('Y年n月j日  H時i分') }}</p>
      </div>
      <div class="thanks-menu">
        <p>{{ $menuName }}</p>
      </div>
      <div class="thanks-staff">
        <p>{{ $staffName }}</p>
      </div>
      <div class="thanks-link">
        <a href="{{ route('reservation.top') }}">{{ __('sentences.user_thanks.btn') }}</a>
      </div>
    </div>
  </div>
</x-default-layout>
