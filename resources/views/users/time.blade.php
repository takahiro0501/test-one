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
    <div class="time-box">
        <div class="calender-title">
            <h1>{{ __('sentences.user_time.title') }}</h1>
        </div>
        <div class="time-contents">
            @foreach($times as  $time => $value )
                        
                @if(isset($menu) && isset($staff))
                    <form action="{{ route('reservation.login') }}" method="post">
                @else
                    <form action="{{ route('reservation.thirdStaff') }}" method="post">
                @endif
                        @csrf
                        @if(isset($date))
                            <input type="hidden" name="date" value="{{ $date }}"></input>
                        @endif
                        @if(isset($menu))
                            <input type="hidden" name="menu" value="{{ $menu }}"></input>
                            <input type="hidden" name="menuName" value="{{ $menuName }}"></input>
                        @endif
                        @if(isset($staff))
                            <input type="hidden" name="staff" value="{{ $staff }}"></input>
                            <input type="hidden" name="staffName" value="{{ $staffName }}"></input>
                        @endif
                        <input type="hidden" name="time" value="{{ $time }}"></input>
                        @if($value == 'ok')
                            <div class="timeBtn">
                                <button type="submit" class="timeBtnHover">{{ $time }}</button>
                            </div>
                        @else
                            <div class="timeBtn">
                                <button disabled>{{ $time }}</button>
                            </div>
                        @endif
                    </form>
            @endforeach
        </div>
    </div>
    <div class="confirm-box">
        <div class="confirm-btn">
            <div><a href="#" onclick="history.back(-1);return false;">前に戻る</a></div>
            <div><a href="{{ route('reservation.top') }}">最初からやり直す</a></div>
        </div>
    </div>
</x-default-layout>
