<x-admin-layout>
  <link rel="stylesheet" href="{{ asset('css/admin/header.css') }}">
  <div class="admin-header-box">
    <div class="admin-header-title">
      <h1>{{ __('sentences.admin_header.title') }}</h1>
    </div>
    <div class="admin-header-form">
      <form action="{{ route('admin.header.exe') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="admin-header-parts">
          <div class="admin-header-label">
              <label for="file">{{ __('sentences.admin_header.logo') }}</label>
          </div>
          <input class="admin-header-input" id="file" type="file" name="file" accept=".png" />
          @if ($errors->has('file'))
              <div class="admin-header-error">
                  {{$errors->first('file')}}
              </div>
          @endif
        </div>
        <div class="admin-header-parts">
          <div class="admin-header-label">
              <label for="sentence1">{{ __('sentences.admin_header.sentence1') }}</label>
          </div>
          <input class="admin-header-input" id="sentence1" type="text" name="sentence1" value="{{ old('sentence1',$sentence1->sentence) }}" />
          @if ($errors->has('sentence1'))
              <div class="admin-header-error">
                  {{$errors->first('sentence1')}}
              </div>
          @endif
        </div>
        <div class="admin-header-parts">
          <div class="admin-header-label">
              <label for="sentence2">{{ __('sentences.admin_header.sentence2') }}</label>
          </div>
          <input class="admin-header-input" id="sentence2" type="text" name="sentence2" value="{{ old('sentence2',$sentence2->sentence) }}" />
          @if ($errors->has('sentence2'))
              <div class="admin-header-error">
                  {{$errors->first('sentence2')}}
              </div>
          @endif
        </div>
        @if ($errors->has('headerCheck'))
          <div class="admin-header-error">
            {{$errors->first('headerCheck')}}
          </div>
        @endif
        <div class="admin-header-btn">
          <button type="submit">{{ __('sentences.admin_header.btn') }}</button>
        </div>
      </form>
      <div class="admin-header-back">
        <a href="{{ route('admin.top') }}">{{ __('sentences.admin_header.back') }}</a>
      </div>
    </div>
  </div>
</x-admin-layout>
