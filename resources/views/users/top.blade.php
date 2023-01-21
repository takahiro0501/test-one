<x-default-layout>
    <div class="top-title">
        <h1>{{ __('sentences.user_top.title') }}</h1>
    </div>
    <div class="top-contents">
        <div class="top-contents-clender">
            <form method="get" action="{{ route('reservation.firstCalender') }}">
                @csrf
                <input type="submit" value="{{ __('sentences.user_top.link_calender') }}" class="commonBtn"></input>
            </form>
        </div>
        <div class="top-contents-menu">
            <form method="get" action="{{ route('reservation.menuFirst') }}">
                @csrf
                <input type="submit" value="{{ __('sentences.user_top.link_menu') }}" class="commonBtn"></input>
            </form>
        </div>
        <div class="top-contents-staff">
            <form method="get" action="{{ route('reservation.staffFirst') }}">
                @csrf
                <input type="submit" value="{{ __('sentences.user_top.link_staff') }}" class="commonBtn"></input>
            </form>
        </div>   
    </div>
    <div class="top-mypage">
        <a href="{{ route('reservation.mypage.mail') }}">{{ __('sentences.user_top.link_mypage') }}</a>
    </div>
</x-default-layout>
