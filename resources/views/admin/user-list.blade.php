<x-admin-layout>
  <div class="admin-user-box">
    <div class="admin-user-flex">
      <div class="admin-user-title">
        <h1>{{ __('sentences.admin_user.title') }}</h1>
      </div>
      <div class="admin-user-back">
        <p><a href="{{ route('admin.top') }}">{{ __('sentences.admin_user.back') }}</a></p>
      </div>
    </div>
    <div class="admin-user-serch">
      <form action="{{ route('admin.user.search') }}" method="get">
        @csrf
        <div class="admin-user-flex">
          <div class="admin-user-parts">
            <p class="admin-user-label"><label for="karte">{{ __('sentences.admin_user.karte') }}</label></p>
            <input class="admin-user-input" id="karte" type="text" name="karte" value="{{ isset($karte) ? $karte : '' }}" />
          </div>
          <div class="admin-user-parts">
            <p class="admin-user-label"><label for="name">{{ __('sentences.admin_user.name') }}</label></p>
            <input class="admin-user-input" id="name" type="text"  name="name"  value="{{ isset($name) ? $name : '' }}"/>
          </div>
          <div class="admin-user-parts">
            <p class="admin-user-label"><label for="phone">{{ __('sentences.admin_user.phone') }}</label></p>
            <input class="admin-user-input" id="phone" type="text"  name="phone"  value="{{ isset($phone) ? $phone : '' }}"/>
          </div>
          <div class="admin-user-parts">
            <p class="admin-user-label"><label for="email">{{ __('sentences.admin_user.email') }}</label></p>
            <input class="admin-user-input" id="email" type="text"  name="email"  value="{{ isset($email) ? $email : '' }}"/>
          </div>
        </div>
        <div class="admin-user-parts">
          <p class="admin-user-label"><label for="inputKarte">{{ __('sentences.admin_user.inputKarte') }}</label></p>
          <input type="radio" name="inputKarte" value="1"  {{ (isset($inputKarte) ?  ($inputKarte==1 ? 'checked' : '') : '') }}>
          <label>すべて</label>
          <input type="radio" name="inputKarte" value="2"  {{ (isset($inputKarte) ?  ($inputKarte==2 ? 'checked' : '') : '') }}>
          <label>カルテ番号未入力</label>
        </div>
        <div class="admin-user-parts">
          <p class="admin-user-label"><label for="guest">{{ __('sentences.admin_user.guest') }}</label></p>
          <input type="radio" name="guest" value="1"  {{ (isset($guest) ?  ($guest==1 ? 'checked' : '') : '') }}>
          <label>ゲストユーザ以外</label>
          <input type="radio" name="guest" value="2"  {{ (isset($guest) ?  ($guest==2 ? 'checked' : '') : '') }}>
          <label>ゲストユーザのみ</label>
          <p class="admin-user-attention">※【ゲストユーザのみ】検索では、「カルテ番号」「メールアドレス」に関する検索は行えません。</p>
        </div>
        <div class="admin-user-btn">
          <button type="submit">{{ __('sentences.admin_user.btn') }}</button>
        </div>
      </form>
      <div class="admin-user-clear">
        <a href="{{ route('admin.user') }}">{{ __('sentences.admin_user.clear') }}</a></button>
      </div>
    </div>
    <div class="admin-user-results">
      <div class="admin-user-ctrl">
        <div class="admin-user-register">
          <form action="{{ route('admin.user.register') }}" method="get">
            <button type="submit">{{ __('sentences.admin_user.register') }}</button>
          </form>
        </div>
        <div class="admin-user-csv">
          <form action="{{ route('admin.user.csv') }}" method="post">
            @csrf
            <input type="hidden" name="csv" value="{{ $results }}"></input>
            <button type="submit">{{ __('sentences.admin_user.csv') }}</button>
          </form>
        </div>
      </div>      
      <table class="admin-user-table">
        <thead class="admin-user-table-head">
          <tr>
            <th>{{ __('sentences.admin_user.karte') }}</th>
            <th>{{ __('sentences.admin_user.first') }}</th>
            <th>{{ __('sentences.admin_user.name') }}</th>
            <th>{{ __('sentences.admin_user.phone') }}</th>
            <th>{{ __('sentences.admin_user.email') }}</th>
            <th>{{ __('sentences.admin_user.adress') }}</th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
        </thead>
      @foreach($results as $user)
      <tbody class="admin-user-table-body">
        <tr>
          <td>
            @if(!empty($user->karte_no))
              {{$user->karte_no}}
            @else
              -
            @endif
          </td>
          <td>
            @if(!empty($user->first_day))
              {{ \Carbon\Carbon::create($user->first_day)->format('Y/n/j') }}
            @else
              -
            @endif
          </td>
          <td>
            @if(!empty($user->name))
              {{$user->name}}
            @else
              -
            @endif
          </td>
          <td>
            @if(!empty($user->phone))
              {{$user->phone}}
            @else
              -
            @endif
          </td>
          <td>
            @if(!empty($user->email))
              {{Str::limit($user->email,15)}}
            @else
              -
            @endif
          </td>
          <td>
            @if(!empty($user->prefecture))
              {{Str::limit($user->prefecture.$user->city.$user->address,22) }}
            @else
              -
            @endif
          </td>
          @if(isset($guest) && $guest==1) 
            <td>
              <form methods="get" action="{{ route('admin.user.edit', ['userId' => $user->id]) }}">
                <input type="submit" value="{{ __('sentences.admin_user.edit') }}" />
              </form>
            </td>
            <td>
              <form methods="get" action="{{ route('admin.user.agency', ['userId' => $user->id]) }}">
                <input type="submit" value="{{ __('sentences.admin_user.agency') }}" />
              </form>
            </td>
            <td>
              <form methods="get"
                    action="{{ route('admin.user.delete', ['userId' => $user->id]) }}" 
                    id="userDelete"
                    onsubmit="return deleteComfirm()"
                >
                <input type="submit" value="{{ __('sentences.admin_user.delete') }}" />
              </form>
            </td>
            <td></td>
            @elseif(isset($guest) && $guest==2)
            <td>
              <form methods="get" action="{{ route('admin.user.guest.edit', ['guestId' => $user->id]) }}">
                <input type="submit" value="{{ __('sentences.admin_user_guest.edit') }}" />
              </form>
            </td>
            <td>
              <form methods="get"
                    action="{{ route('admin.user.guest.delete', ['guestId' => $user->id]) }}" 
                    id="userDelete"
                    onsubmit="return deleteComfirm()"
                >
                <input type="submit" value="{{ __('sentences.admin_user_guest.delete') }}" />
              </form>
            </td>
            <td></td>
            @endif
        </tr>
      </tbody>
      @endforeach
    </table>
    </div>
  </div>
  <script src="{{ asset('js/admin/user-list.js') }}"></script>
</x-admin-layout>

