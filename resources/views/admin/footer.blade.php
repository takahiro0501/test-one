<x-admin-layout>
<link rel="stylesheet" href="{{ asset('css/admin/footer.css') }}">
<div class="admin-footer-box">
    <div class="admin-footer-title">
    <h1>{{ __('sentences.admin_footer.title') }}</h1>
    </div>
    <div class="admin-footer-form">
    <form action="{{ route('admin.footer.exe') }}" method="post">
        @csrf
            @foreach($links as $key => $link)
            <div class="admin-footer-parts">
                <div class="admin-footer-label">
                    <label for="sentence1">表示{{ $key }}</label>
                </div>
                <input class="admin-footer-input-name" type="text" name="{{ 'name' . $key }}" value="{{ old('name' . $key , $link->link_name ) }}" />
                <input class="admin-footer-input-link" type="text" name="{{ 'link' . $key }}" value="{{ old('link' . $key , $link->link ) }}" />
            </div>
            @if ($errors->has('name'. $key))
                <div class="admin-footer-error">
                    {{$errors->first('name'. $key)}}
                </div>
            @endif
            @if ($errors->has('link'. $key))
                <div class="admin-footer-error">
                    {{$errors->first('link'. $key)}}
                </div>
            @endif
            @endforeach
        <div class="admin-footer-btn">
            <button type="submit">{{ __('sentences.admin_footer.btn') }}</button>
        </div>
        </form>
        <div class="admin-footer-back">
        <a href="{{ route('admin.top') }}">{{ __('sentences.admin_footer.back') }}</a>
        </div>
    </div>
    </div>
</x-admin-layout>
