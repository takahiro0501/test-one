<x-default-layout>
    <div class="confirm-box">
        <div class="confirm-item">
            @if(isset($date))
                <div class="confirm-date">
                    <p>{{ \Carbon\Carbon::create($date)->format('Y年n月j日') }}</p>
                </div>
            @endif
            @if(isset($time))
                <div class="confirm-time">
                    <p>{{ \Carbon\Carbon::create($time)->format('g時i分') }}</p>
                </div>
            @endif
            @if(isset($staffName))
                <div class="confirm-staff">
                    <p>{{ $staffName }}</p>
                </div>
            @endif
            @if(isset($menuName))
                <div class="confirm-menu">
                    <p>{{ $menuName }}</p>
                </div>
            @endif
        </div>
    </div>
    <div class="calender-box">
        <div class="calender-title">
            <h1>{{ __('sentences.user_calender.title') }}</h1>
        </div>
        <div class="calender-contents">
            <div class="wrapper">
                <h1 id="header"></h1>
                <div id="next-prev-button">
                    <button id="prev" onclick="changeMonth('prev')">＜＜ 前の月</button>
                    <button id="next" onclick="changeMonth('next')">次の月 ＞＞</button>
                </div>
                <div id="calendar"></div>
            </div>
        </div>
    </div>
    @if(isset($menu))
        <form id="calenderForm" action="{{ route('reservation.fourthStaffTime') }}" method="post">
    @else
        <form id="calenderForm" action="{{ route('reservation.secondTime') }}" method="post">
    @endif
        @csrf
        @if(isset($menu))
        <input type="hidden" name="menu" value="{{ $menu }}" id="menuParam"></input>
        <input type="hidden" name="menuName" value="{{ $menuName }}"></input>
        @endif
        @if(isset($staff))
        <input type="hidden" name="staff" value="{{ $staff }}"  id="staffParam"></input>
        <input type="hidden" name="staffName" value="{{ $staffName }}"></input>
        @endif
        <input type="hidden" name="date" value="" id="cParam"></input>
    </form>
    <div class="confirm-box">
        <div class="confirm-btn">
            <div><a href="#" onclick="history.back(-1);return false;">前に戻る</a></div>
            <div><a href="{{ route('reservation.top') }}">最初からやり直す</a></div>
        </div>
    </div>
    <script src="{{ asset('js/users/calender.js') }}"></script>
</x-default-layout>
