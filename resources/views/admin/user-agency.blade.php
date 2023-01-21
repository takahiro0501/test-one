<x-admin-layout>
  <div class="admin-user-agency-box">
    <div class="admin-user-agency-title">
      <h1>{{ __('sentences.admin_reservation_edit.agency') }}</h1>
    </div>
    <div class="admin-user-agency-search">
      <form action="{{ route('admin.user.agency.exe') }}" method="post">
        @csrf
          <div class="admin-user-agency-parts">
            <p class="admin-user-agency-label"><label for="karte">{{ __('sentences.admin_reservation_edit.karte') }}</label></p>
            <p class="admin-user-agency-sentence">
              @if(isset($user->karte_no))
                {{ $user->karte_no }}
              @else
                -
              @endif
              </p>
          </div>
          <div class="admin-user-agency-parts">
            <p class="admin-user-agency-label"><label for="name">{{ __('sentences.admin_reservation_edit.name') }}</label></p>
            <p class="admin-user-agency-sentence">
              @if(isset($user->name))
                {{ $user->name }}
              @else
                -
              @endif
            </p>
          </div>
          <div class="admin-user-agency-parts">
            <p class="admin-user-agency-label"><label for="menu">{{ __('sentences.admin_reservation_edit.menu') }}</label></p>
            <select class="admin-user-agency-menu" name="menu">
            @foreach($menus as $item)
              <option value="{{ $item->id }}" {{ old('menu') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
            @endforeach
            </select>
          </div>
          <div class="admin-user-agency-parts">
            <p class="admin-user-agency-label"><label for="staff">{{ __('sentences.admin_reservation_edit.staff') }}</label></p>
            <select class="admin-user-agency-staff" name="staff">
              @foreach($staffs as $item)
              <option value="{{ $item->id }}"  {{ old('staff') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="admin-user-agency-parts">
            <p class="admin-user-agency-label"><label for="date">{{ __('sentences.admin_reservation_edit.date') }}</label></p>
            <input class="admin-user-agency-input" id="date" type="date"  name="date" value="{{ old('date') }}"/>
            @if ($errors->has('date'))
              <div class="admin-user-agency-error">
                {{$errors->first('date')}}
              </div>
            @endif
          </div>
          <div class="admin-user-agency-parts">
            <p class="admin-user-agency-label"><label for="time">{{ __('sentences.admin_reservation_edit.time') }}</label></p>
            <select class="admin-user-agency-time" name="time">
              @foreach($times as $item)
              <option value="{{ $item }}"  {{ old('time')==$item ? 'selected' : '' }}>{{ $item }}</option>
              @endforeach
            </select>
            @if ($errors->has('reserveCheck'))
              <div class="admin-user-agency-error">
                {{$errors->first('reserveCheck')}}
              </div>
            @endif
          </div>
          <input type="hidden" name="user_id" value="{{ $user->id }}">
          <div class="admin-user-agency-btn">
            <button type="submit">{{ __('sentences.admin_reservation_edit.btn') }}</button>
          </div>
          <div class="admin-user-agency-clear">
            <a href="{{ route('admin.user') }}">{{ __('sentences.admin_reservation_edit.back') }}</a></button>
          </div>
        </form>
      </div>
  </div>
</x-admin-layout>

