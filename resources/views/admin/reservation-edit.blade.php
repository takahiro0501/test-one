<x-admin-layout>
  <div class="admin-reservation-edit-box">
    <div class="admin-reservation-edit-title">
      <h1>{{ __('sentences.admin_reservation_edit.title') }}</h1>
    </div>
    <div class="admin-reservation-edit-search">
      <form action="{{ route('admin.reservation.edit.exe') }}" method="post">
        @csrf
          <div class="admin-reservation-edit-parts">
            <p class="admin-reservation-edit-label"><label for="karte">{{ __('sentences.admin_reservation_edit.karte') }}</label></p>
            <p class="admin-reservation-edit-sentence">
              @if(isset($reserve->user->karte_no))
                {{ $reserve->user->karte_no }}
              @else
                -
              @endif
              </p>
          </div>
          <div class="admin-reservation-edit-parts">
            <p class="admin-reservation-edit-label"><label for="name">{{ __('sentences.admin_reservation_edit.name') }}</label></p>
            <p class="admin-reservation-edit-sentence">
              @if(isset($reserve->user->name))
                {{ $reserve->user->name }}
              @elseif(isset($reserve->guest->name))
                {{ $reserve->guest->name }}
              @endif
            </p>
          </div>
          <div class="admin-reservation-edit-parts">
              <p class="admin-reservation-edit-label"><label for="menu">{{ __('sentences.admin_reservation_edit.menu') }}</label></p>
              <select class="admin-reservation-edit-menu" name="menu">
              @foreach($menus as $item)
                <option value="{{ $item->id }}" {{ old('menu',$reserve->menu_id) == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
              @endforeach
              </select>
          </div>
          <div class="admin-reservation-edit-parts">
            <p class="admin-reservation-edit-label"><label for="staff">{{ __('sentences.admin_reservation_edit.staff') }}</label></p>
            <select class="admin-reservation-edit-staff" name="staff">
              @foreach($staffs as $item)
              <option value="{{ $item->id }}"  {{ old('staff',$reserve->staff_id) == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="admin-reservation-edit-parts">
            <p class="admin-reservation-edit-label"><label for="date">{{ __('sentences.admin_reservation_edit.date') }}</label></p>
            <input class="admin-reservation-edit-input" id="date" type="date"  name="date" value="{{ old('date',substr($reserve->reservation_datetime,0,10)) }}"/>
            @if ($errors->has('date'))
              <div class="admin-reservation-edit-error">
                {{$errors->first('date')}}
              </div>
            @endif
          </div>
          <div class="admin-reservation-edit-parts">
            <p class="admin-reservation-edit-label"><label for="time">{{ __('sentences.admin_reservation_edit.time') }}</label></p>
            <select class="admin-reservation-edit-time" name="time">
              @foreach($times as $item)
              <option value="{{ $item }}"  {{ old('time',substr($reserve->reservation_datetime,11,5))==$item ? 'selected' : '' }}>{{ $item }}</option>
              @endforeach
            </select>
            @if ($errors->has('reserveCheck'))
              <div class="admin-reservation-edit-error">
                {{$errors->first('reserveCheck')}}
              </div>
            @endif
          </div>
          <input type="hidden" name="reservation_id" value="{{ $reserve->id }}"></input>

          <div class="admin-reservation-edit-btn">
            <button type="submit">{{ __('sentences.admin_reservation_edit.btn') }}</button>
          </div>
          <div class="admin-reservation-edit-clear">
            <a href="{{ route('admin.reservation') }}">{{ __('sentences.admin_reservation_edit.back') }}</a>
          </div>
        </form>
      </div>
  </div>
</x-admin-layout>

