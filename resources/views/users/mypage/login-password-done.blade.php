<x-default-layout>
  <div class="thanks-box">
    <div class="thanks-title">
      <h1>{{ __('sentences.user_mypage_password_reset.title') }}</h1>
    </div>
    <div class="thanks-link">
      <a href="{{ route('reservation.mypage.mail') }}">{{ __('sentences.user_mypage_password_reset.btn') }}</a>
    </div>
  </div>
</x-default-layout>
