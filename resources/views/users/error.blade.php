<x-default-layout>
  <div class="error-box">
    <div class="error-title">
      <h1>{{ $errorMsg }}</h1>
    </div>
    <div  class="error-btn">
      <a href="{{ route('reservation.top') }}">{{ __('sentences.user_error.button') }}</a>
    </div>
  </div>
</x-default-layout>
