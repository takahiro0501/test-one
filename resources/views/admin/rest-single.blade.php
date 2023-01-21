<x-admin-layout>
    <div class="rest-single-box">
        <div class="rest-single-flex">
            <div class="rest-single-title">
                <h1>{{ __('sentences.admin_single.title') }}</h1>
            </div>
            <div class="rest-single-back">
                <p><a href="{{ route('admin.top') }}">{{ __('sentences.admin_single.back') }}</a></p>
            </div>
        </div>
        <div class="rest-single-contents">

            <div class="rest-single-parts">
                <p class="rest-single-sentence">
                    対象のスタッフを選択して下さい
                </p>
                <form action="{{ route('admin.rest.single') }}" method="post">
                    @csrf
                    <select class="rest-single-parts-staff" name="staff" onchange="submit(this.form)">
                        @foreach($staffs as $staff)
                        <option value="{{ $staff->id }}" 
                        {{ $firstStaff==$staff->id ? 'selected' : '' }}>{{ $staff->name }}
                        </option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="wrapper">
                <h1 id="header"></h1>
                <div id="next-prev-button">
                    <button id="prev" onclick="changeMonth('prev')">＜＜ 前の月</button>
                    <button id="next" onclick="changeMonth('next')">次の月 ＞＞</button>
                </div>
                <div id="calendar"></div>
            </div>
            <form id="calenderForm" action="{{ route('admin.rest.single.edit') }}" method="post">
            @csrf
            <input type="hidden" id="staff" name="staff" value="{{ $firstStaff }}">
            <input type="hidden" id="restdata" name="restdata" value="">
                <div class="rest-single-btn">
                    <button type="submit">{{ __('sentences.admin_single.edit') }}</button>
                </div>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/admin/rest-calender.js') }}"></script>
</x-admin-layout>
