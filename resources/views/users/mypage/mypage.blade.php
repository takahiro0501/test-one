<x-default-layout>
  <div class="mypage-box">
      <div class="mypage-title">
        <h1>{{ $user->name }}様の予約状況</h1>
        <form action="{{ route('logout') }}" method="post" class="mypage-logout">
          @csrf
          <button>ログアウトする</button>
        </form>
      </div>
      <div class="mypage-subtitle">
          <p>◆ 予約中 ◆</p>
        </div>
        @if($futures->isEmpty())
        <div  class="mypage-nodata">
            <p>予約がありません</p>
          </div>
        @else
          @foreach($futures as $item)
          <div class="mypage-item">
            <p>
              予約日時：{{ \Carbon\Carbon::createFromTimeString($item->reservation_datetime)->format("Y年m月d日 H時i分") }}
            </p>
            <p>
              施術名：{{ $item->menu->name }}
            </p>
            <p>
              スタッフ：{{ $item->staff->name }}
            </p>
          </div>
          @endforeach
        @endif
        <div class="mypage-subtitle">
          <p>◆ 過去の予約 ◆</p>
        </div>
        @if($pasts->isEmpty())
          <div  class="mypage-nodata">
            <p>予約履歴はありません</p>
          </div>
        @else
          @foreach($pasts as $item)
          <div class="mypage-item">
            <p>
              予約日時：{{ \Carbon\Carbon::createFromTimeString($item->reservation_datetime)->format("Y年m月d日 H時i分") }}
            </p>
            <p>
              施術名：{{ $item->menu->name }}
            </p>
            <p>
              スタッフ：{{ $item->staff->name }}
            </p>
          </div>
          @endforeach
        @endif
      </div>
    </div>
</x-default-layout>
