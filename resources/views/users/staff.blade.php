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

    <div class="staff-box">
        <div class="staff-title">
            <h1>{{ __('sentences.user_staff.title') }}</h1>
        </div>
        <div class="staff-contents">
            @foreach($staffs as  $staff )
                @if($staff['judge'] == 'ok')
                  @if(isset($date))
                    <form action="{{ route('reservation.forthMenu') }}" method="post">
                  @elseif(isset($menu))
                    <form action="{{ route('reservation.thirdCalender') }}" method="post">
                  @else
                    <form action="{{ route('reservation.secondMenu') }}" method="post">
                  @endif
                    @csrf
                    @if(isset($date))
                      <input type="hidden" name="date" value="{{ $date }}"></input>
                    @endif
                    @if(isset($time))
                      <input type="hidden" name="time" value="{{ $time }}"></input>
                    @endif
                    @if(isset($menu))
                      <input type="hidden" name="menu" value="{{ $menu }}"></input>
                      <input type="hidden" name="menuName" value="{{ $menuName }}"></input>
                    @endif
                    <input type="hidden" name="staff" value="{{ $staff['id'] }}"></input>
                    <input type="hidden" name="staffName" value="{{ $staff['name'] }}"></input>
                    <div class="staffBtn">
                      <button type="submit" class="staffBtnHover">{{ $staff['name'] }}</button>
                    </div>
                  </form>
                @else
                    <div class="staffBtn">
                        <button disabled>{{ $staff['name'] }}</button>
                    </div>
                @endif
            @endforeach
            @if(isset($date))
              <form action="{{ route('reservation.forthMenu') }}" method="post">
            @elseif(isset($menu))
              <form action="{{ route('reservation.thirdCalender') }}" method="post">
            @else
              <form action="{{ route('reservation.secondMenu') }}" method="post">
            @endif
            @csrf
              @if(isset($date))
                <input type="hidden" name="date" value="{{ $date }}"></input>
              @endif
              @if(isset($time))
                <input type="hidden" name="time" value="{{ $time }}"></input>
              @endif
              @if(isset($menu))
                <input type="hidden" name="menu" value="{{ $menu }}"></input>
                <input type="hidden" name="menuName" value="{{ $menuName }}"></input>
              @endif
              <input type="hidden" name="staff" value="0"></input>
              <input type="hidden" name="staffName" value="指定しない"></input>
              <div class="staffBtn">
                <button type="submit" class="staffBtnHover">{{ __('sentences.user_staff.select') }}</button>
              </div>
            </form>
        </div>
    </div>
    <div class="confirm-box">
        <div class="confirm-btn">
            <div><a href="#" onclick="history.back(-1);return false;">前に戻る</a></div>
            <div><a href="{{ route('reservation.top') }}">最初からやり直す</a></div>
        </div>
    </div>
</x-default-layout>
