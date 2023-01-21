<x-admin-layout>
  <div class="admin-menu-box">
    <div class="admin-menu-flex">
      <div class="admin-menu-title">
        <h1>{{ __('sentences.admin_menu.title') }}</h1>
      </div>
      <div class="admin-menu-back">
        <p><a href="{{ route('admin.top') }}">{{ __('sentences.admin_menu.back') }}</a></p>
      </div>
    </div>
    <div class="admin-menu-create">
      <form action="{{ route('admin.menu.create') }}" method="post">
        @csrf
        <div class="admin-menu-parts">
          <p class="admin-menu-label"><label for="name">{{ __('sentences.admin_menu.name') }}</label></p>
          <input class="admin-menu-input-name" id="name" type="text" name="name" value="{{ old('name') }}" placeholder="30字以内で入力してください"/>
          @if ($errors->has('name'))
          <div class="admin-menu-error">
              {{$errors->first('name')}}
          </div>
          @endif
        </div>
        <div class="admin-menu-parts">
          <p class="admin-menu-label"><label for="time">{{ __('sentences.admin_menu.time') }}</label></p>
          <input class="admin-menu-input" id="time" type="text" name="time" value="{{ old('time') }}" placeholder="半角数字で記入して下さい" oninput="value = value.replace(/[^0-9]+/i,'');"/>
          <span>分</span>
          @if ($errors->has('time'))
          <div class="admin-menu-error">
              {{$errors->first('time')}}
          </div>
           @endif
        </div>
        <div class="admin-menu-parts">
          <p class="admin-menu-label"><label for="money">{{ __('sentences.admin_menu.money') }}</label></p>
          <input class="admin-menu-input" id="money" type="text" name="money" value="{{ old('money') }}" placeholder="半角数字で記入して下さい" oninput="value = value.replace(/[^0-9]+/i,'');"/>
          <span>円</span>
          @if ($errors->has('money'))
          <div class="admin-menu-error">
              {{$errors->first('money')}}
          </div>
          @endif
        </div>
        <div class="admin-menu-parts">
          <p class="admin-menu-label-textarea"><label for="overview">{{ __('sentences.admin_menu.overview') }}</label></p>
          <textarea class="admin-menu-textarea" id="overview" name="overview" placeholder="300字以内で記入してください">{{ old('overview','') }}</textarea>
          @if ($errors->has('overview'))
          <div class="admin-menu-error">
              {{$errors->first('overview')}}
          </div>
          @endif
        </div>
        <div class="admin-menu-btn">
          <button type="submit">{{ __('sentences.admin_menu.create') }}</button>
        </div>
      </form>
    </div>
    <div class="admin-menu-results">
      <table class="admin-menu-table">
        <thead class="admin-menu-table-head">
          <tr>
            <th>{{ __('sentences.admin_menu.name') }}</th>
            <th>{{ __('sentences.admin_menu.time') }}</th>
            <th>{{ __('sentences.admin_menu.money') }}</th>
            <th>{{ __('sentences.admin_menu.overview') }}</th>
            <th>{{ __('sentences.admin_menu.priority') }}</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        @foreach($menus as $menu)
        <tbody class="admin-menu-table-body">
        @if($menu->delete_flg == 0)
          <tr>
        @elseif($menu->delete_flg == 1)
          <tr class="admin-menu-table-delete">
        @endif
            <td>
              {{ Str::limit($menu->name,25)}}
            </td>
            <td>
              {{ $menu->time }}
              <span>分</span>
            </td>
            <td>
              {{ $menu->money }}
              <span>円</span>
            </td>
            <td>
              {{ Str::limit($menu->overview,30)}}
            </td>
          @if($menu->delete_flg == 0)
            <td>
              {{ $menu->priority }}
            </td>
            <td>
              <form methods="get" action="{{ route('admin.menu.edit', ['menuId' => $menu->id]) }}">
                <input type="submit" value="{{ __('sentences.admin_menu.edit') }}" />
              </form>
            </td>
            <td>
              <form methods="get" action="{{ route('admin.menu.delete', ['menuId' => $menu->id]) }}">
                <input id="menuDelete" type="submit" value="{{ __('sentences.admin_menu.delete') }}" />
              </form>
            </td>
          @elseif($menu->delete_flg == 1)
            <td>
              -
            </td>
            <td>
              <form methods="get" action="{{ route('admin.menu.revival', ['menuId' => $menu->id]) }}">
                <input type="submit" value="{{ __('sentences.admin_menu.revival') }}" />
              </form>
            </td>
            <td>
            </td>
          @endif
          </tr>
        </tbody>
        @endforeach
      </table>
    </div>
  </div>
</x-admin-layout>

