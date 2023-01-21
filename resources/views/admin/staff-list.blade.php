<x-admin-layout>
  <div class="admin-staff-box">
    <div class="admin-staff-flex">
      <div class="admin-staff-title">
        <h1>{{ __('sentences.admin_staff.title') }}</h1>
      </div>
      <div class="admin-staff-back">
        <p><a href="{{ route('admin.top') }}">{{ __('sentences.admin_staff.back') }}</a></p>
      </div>
    </div>
    <div class="admin-staff-create">
      <form action="{{ route('admin.staff.create') }}" method="post">
        @csrf
        <div class="admin-staff-parts">
          <p class="admin-staff-label"><label for="name">{{ __('sentences.admin_staff.name') }}</label></p>
          <input class="admin-staff-input-name" id="name" type="text" name="name" value="{{ old('name') }}" placeholder="30字以内で入力してください"/>
          @if ($errors->has('name'))
          <div class="admin-staff-error">
            {{$errors->first('name')}}
          </div>
          @endif
        </div>
        <div class="admin-staff-btn">
          <button type="submit">{{ __('sentences.admin_staff.create') }}</button>
        </div>
      </form>
    </div>
    <div class="admin-staff-results">
      <table class="admin-staff-table">
        <thead class="admin-staff-table-head">
          <tr>
            <th>{{ __('sentences.admin_staff.name') }}</th>
            <th>{{ __('sentences.admin_staff.priority') }}</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
      @foreach($staffs as $staff)
        <tbody class="admin-staff-table-body">
        @if($staff->delete_flg == 0)
          <tr>
        @elseif($staff->delete_flg == 1)
          <tr class="admin-staff-table-delete">
        @endif
            <td>
              {{ $staff->name,20 }}
            </td>
          @if($staff->delete_flg == 0)
          <td>
            {{ $staff->priority }}
          </td>
          <td>
              <form methods="get" action="{{ route('admin.staff.edit', ['staffId' => $staff->id]) }}">
                <input type="submit" value="{{ __('sentences.admin_staff.edit') }}" />
              </form>
            </td>
            <td>
              <form methods="get" action="{{ route('admin.staff.delete', ['staffId' => $staff->id]) }}">
                <input id="menuDelete" type="submit" value="{{ __('sentences.admin_staff.delete') }}" />
              </form>
            </td>
          @elseif($staff->delete_flg == 1)
          <td>
            -
          </td>
          <td>
              <form methods="get" action="{{ route('admin.staff.revival', ['staffId' => $staff->id]) }}">
                <input type="submit" value="{{ __('sentences.admin_staff.revival') }}" />
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
</x-admin-layout>

