<x-admin-layout>
  <div class="admin-reservation-box">
    <div class="admin-reservation-flex">
      <div class="admin-reservation-title">
        <h1>{{ __('sentences.admin_reservation.title') }}</h1>
      </div>
      <div class="admin-reservation-back">
        <p><a href="{{ route('admin.top') }}">{{ __('sentences.admin_reservation.back') }}</a></p>
      </div>
    </div>
    <div class="admin-reservation-serch">
      <form action="{{ route('admin.reservation.search') }}" method="get">
      @csrf
      <div class="admin-reservation-flex">
        <div class="admin-reservation-parts">
          <p class="admin-reservation-label"><label for="karte">{{ __('sentences.admin_reservation.karte') }}</label></p>
          <input class="admin-reservation-input" id="karte" type="text" name="karte" value="{{ isset($karte) ? $karte : '' }}" />
        </div>
        <div class="admin-reservation-parts">
          <p class="admin-reservation-label"><label for="name">{{ __('sentences.admin_reservation.name') }}</label></p>
          <input class="admin-reservation-input" id="name" type="text"  name="name"  value="{{ isset($userName) ? $userName : '' }}"/>
        </div>
        <div class="admin-reservation-parts">
          <p class="admin-reservation-label"><label for="menu">{{ __('sentences.admin_reservation.menu') }}</label></p>
          <select class="admin-reservation-menu" name="menu">
            <option value=""></option>
          @foreach($menus as $item)
            <option value="{{ $item->id }}" {{ (isset($menu) ?  ($menu==$item->id ? 'selected' : '') : '')}}>{{ $item->name }}</option>
          @endforeach
          </select>
        </div>
        <div class="admin-reservation-parts">
          <p class="admin-reservation-label"><label for="staff">{{ __('sentences.admin_reservation.staff') }}</label></p>
          <select class="admin-reservation-staff" name="staff">
            <option value=""></option>
          @foreach($staffs as $item)
            <option value="{{ $item->id }}"  {{ (isset($staff) ?  ($staff==$item->id ? 'selected' : '') : '')}}>{{ $item->name }}</option>
          @endforeach
          </select>
        </div>
      </div>
        <div class="admin-reservation-parts">
          <p class="admin-reservation-label"><label for="fromDate">{{ __('sentences.admin_reservation.date') }}</label></p>
          <input class="admin-reservation-input" id="fromDate" type="date"  name="fromDate" value="{{ isset($fromDate) ? $fromDate : '' }}"/>
          <span>～</span>
          <input class="admin-reservation-input" id="toDate" type="date"  name="toDate" value="{{ isset($toDate) ? $toDate : '' }}"/>
        </div>
        <div class="admin-reservation-flexbtn">
          <div class="admin-reservation-btn">
            <button type="submit">{{ __('sentences.admin_reservation.btn') }}</button>
          </div>
        </div>
      </form>
      <div class="admin-reservation-clear">
        <a href="{{ route('admin.reservation') }}">{{ __('sentences.admin_reservation.clear') }}</a></button>
      </div>
    </div>
    <div class="admin-reservation-results">
      <table class="admin-reservation-table">
        <thead class="admin-reservation-table-head">
          <tr>
            <th>{{ __('sentences.admin_reservation.karte') }}</th>
            <th>{{ __('sentences.admin_reservation.name') }}</th>
            <th>{{ __('sentences.admin_reservation.date') }}</th>
            <th>{{ __('sentences.admin_reservation.menu') }}</th>
            <th>{{ __('sentences.admin_reservation.staff') }}</th>
            <th>{{ __('sentences.admin_reservation.type') }}</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
      @foreach($reservations as $reservation)
      <tbody class="admin-reservation-table-body">
        <tr>
          <td>
            @if(!empty($reservation->user_id))
              @if(!empty($reservation->user->karte_no))
                {{$reservation->user->karte_no}}
              @else
                -
              @endif
            @else
              -
            @endif
          </td>
          <td>
            @if(!empty($reservation->user_id))
              {{$reservation->user->name}}
            @elseif(!empty($reservation->guest_id))
              {{$reservation->guest->name}}
            @endif
          </td>
          <td>
            {{\Carbon\Carbon::create($reservation->reservation_datetime)->format('Y/n/j H:i')}}
          </td>
          <td>
            {{$reservation->menu->name}}
          </td>
          <td>
            {{$reservation->staff->name}}
          </td>
          <td>
            @if(!empty($reservation->user_id))
              ×
            @elseif(!empty($reservation->guest_id))
              〇
            @else
              -
            @endif
          </td>
          <td>
            <form methods="get" action="{{ route('admin.reservation.edit', ['reservationId' => $reservation->id]) }}">
              <input type="submit" value="{{ __('sentences.admin_reservation.edit') }}" />
            </form>
          </td>
          <td>
            <form methods="get" 
                  action="{{ route('admin.reservation.delete', ['reservationId' => $reservation->id]) }}" 
                  id="reservationDelete"
                  onsubmit="return deleteComfirm()"
              >
              <input type="submit" value="{{ __('sentences.admin_reservation.delete') }}" />
            </form>
          </td>
        </tr>
      </tbody>
      @endforeach
    </table>
    </div>
  </div>
  <script src="{{ asset('js/admin/reservation-list.js') }}"></script>
</x-admin-layout>

