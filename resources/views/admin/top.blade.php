<x-admin-layout>
  <div class="admin-top-box">
    <div class="admin-top-title">
      <h1>{{ __('sentences.admin_top.title') }}</h1>
    </div>
    <div class="admin-top-contents">
      <div class="admin-top-item">
        <div class="admin-top-subttitle">
          <p>{{ __('sentences.admin_top.reservation') }}</p>
        </div>
        <div class="admin-top-menu">
            <a href="{{ route('admin.reservation') }}">{{ __('sentences.admin_top.reservation_list') }}</a>
        </div>
      </div>
      <div class="admin-top-item">
        <div class="admin-top-subttitle">
          <p>{{ __('sentences.admin_top.user') }}</p>
        </div>
        <div class="admin-top-menu">
            <a href="{{ route('admin.user') }}">{{ __('sentences.admin_top.user_list') }}</a>
        </div>
      </div>
      <div class="admin-top-item">
        <div class="admin-top-subttitle">
          <p>{{ __('sentences.admin_top.setting') }}</p>
        </div>
        <div class="admin-flex">
          <div class="admin-top-menu">
              <a href="{{ route('admin.menu') }}">{{ __('sentences.admin_top.setting_menu') }}</a>
          </div>
          <div class="admin-top-menu">
              <a href="{{ route('admin.staff') }}">{{ __('sentences.admin_top.setting_staff') }}</a>
          </div>
          <div class="admin-top-menu">
              <a href="{{ route('admin.time') }}">{{ __('sentences.admin_top.setting_time') }}</a>
          </div>
          <div class="admin-top-menu">
              <a href="{{ route('admin.rest.multi') }}">{{ __('sentences.admin_top.setting_multi_rest') }}</a>
          </div>
          <div class="admin-top-menu">
              <a href="{{ route('admin.rest.single') }}">{{ __('sentences.admin_top.setting_single_rest') }}</a>
          </div>
        </div>
      </div>
      <div class="admin-top-item">
        <div class="admin-top-subttitle">
          <p>{{ __('sentences.admin_top.etc') }}</p>
        </div>
        <div class="admin-flex">
          <div class="admin-top-menu">
            <a href="{{ route('admin.header') }}">{{ __('sentences.admin_top.etc_header') }}</a>
          </div>
          <div class="admin-top-menu">
            <a href="{{ route('admin.footer') }}">{{ __('sentences.admin_top.etc_footer') }}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-admin-layout>

