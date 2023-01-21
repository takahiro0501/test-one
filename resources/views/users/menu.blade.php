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

    <div class="menu-box">
        <div class="menu-title">
            <h1>{{ __('sentences.user_menu.title') }}</h1>
        </div>
        <div class="menu-contents">
          @foreach($menus as  $menu)
          <div class="menu-item">
            <div class="menu-item-content">
              <div>【{{ $menu['name'] }}】</div>
              <div>{{ $menu['overview'] }}</div>
              <div>時間：{{ $menu['time'] }}分</div>
              <div>料金：{{ $menu['money'] }}円</div>
            </div>
            <div class="menu-item-select">
              @if( !isset($menu['judge']) || $menu['judge'] == 'ok')
                @if(isset($date) && isset($staff))
                  <form action="{{ route('reservation.login') }}" method="post">
                @elseif(isset($staff))
                  <form action="{{ route('reservation.thirdStaffCalender') }}" method="post">
                @else
                  <form action="{{ route('reservation.staffSecond') }}" method="post">
                @endif
                  @csrf
                  @if(isset($date))
                    <input type="hidden" name="date" value="{{ $date }}"></input>
                  @endif
                  @if(isset($time))
                    <input type="hidden" name="time" value="{{ $time }}"></input>
                  @endif
                  @if(isset($staff))
                    <input type="hidden" name="staff" value="{{ $staff }}"></input>
                    <input type="hidden" name="staffName" value="{{ $staffName }}"></input>
                  @endif
                  <input type="hidden" name="menu" value="{{ $menu['id'] }}"></input>
                  <input type="hidden" name="menuName" value="{{ $menu['name'] }}"></input>
                  <div class="menuBtn">
                      <button type="submit" class="menuBtnHover">{{ __('sentences.user_menu.select') }}</button>
                  </div>
                </form>
              @else
                  <div class="menuBtn">
                      <button disabled>{{ __('sentences.user_menu.nonselect') }}</button>
                  </div>
              @endif
              </div>
          </div>
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
