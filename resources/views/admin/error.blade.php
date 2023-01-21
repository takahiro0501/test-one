<x-admin-layout>
  <div class="admin-error-box">
    <div class="admin-error-title">
      <h1>{{ $errorMsg }}</h1>
    </div>
    <div  class="admin-error-btn">
      <a href="{{ route('admin.login') }}">{{ __('sentences.admin_error.button') }}</a>
    </div>
  </div>
</x-admin-layout>
