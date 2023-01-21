<x-admin-layout>
  <div class="available-time-box">
    <div class="available-time-flex">
      <div class="available-time-title">
        <h1>{{ __('sentences.admin_time.title') }}</h1>
      </div>
      <div class="available-time-back">
        <p><a href="{{ route('admin.top') }}">{{ __('sentences.admin_time.back') }}</a></p>
      </div>
    </div>
    <div class="available-time-item">
      <form action="{{ route('admin.edit') }}" method="post">
        @csrf
        <table class="available-time-table">
          <thead class="available-time-table-head">
            <tr>
              <th class="available-time-table-row">時間/曜日</th>
              <th>日</th>
              <th>月</th>
              <th>火</th>
              <th>水</th>
              <th>木</th>
              <th>金</th>
              <th>土</th>
            </tr>
          </thead>
          <tbody class="available-time-table-body">
            @foreach($results as $time => $values )
            <tr>
              <td>
                {{ $time }}
              </td>
              @foreach($values as $week => $value)
                <td>
                  <input type="text" value="{{ $value }}" class="available-time-input" name="{{ $time.'-'.$week}}" onclick="changeValue(this);return false;" readonly>
                </td>
              @endforeach
            </tr>
            @endforeach
          </tbody>
      </table>
      <div class="available-time-btn">
        <button type="submit">更新する</button>
      </div>
    </form>
  </div>
  <script src="{{ asset('js/admin/available-time.js') }}"></script>
</x-admin-layout>

