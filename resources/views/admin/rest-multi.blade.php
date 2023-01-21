<x-admin-layout>
  <div class="rest-multi-box">
    <div class="rest-multi-flex">
      <div class="rest-multi-title">
        <h1>{{ __('sentences.admin_multi.title') }}</h1>
      </div>
      <div class="rest-multi-back">
        <p><a href="{{ route('admin.top') }}">{{ __('sentences.admin_multi.back') }}</a></p>
      </div>
    </div>
    <div class="rest-multi-item">
      <div class="rest-multi-parts">
        <p class="rest-multi-sentence">
            対象のスタッフを選択して下さい
        </p>
        <form action="{{ route('admin.rest.multi') }}" method="post">
          @csrf
          <select class="rest-multi-parts-staff" name="staff" onchange="submit(this.form)">
            @foreach($staffs as $staff)
            <option value="{{ $staff->id }}" 
              {{ $firstStaff==$staff->id ? 'selected' : '' }}>{{ $staff->name }}
            </option>
            @endforeach
          </select>
        </form>
      </div>
      <p class="rest-multi-sentence">
        変更する曜日を選択してください
      </p>
      <form action="{{ route('admin.rest.multi.edit') }}" method="post" onsubmit="return updateComfirm()">
        @csrf
        <div class="rest-multi-parts">
          <label class="rest-multi-parts-label" for="sun">【　日曜日　】</label>
          <input class="rest-multi-input" type="radio" name="0" value='1' {{ $rests[0] == 1 ? 'checked' : '' }}/>休診日
          <input class="rest-multi-input" type="radio" name="0"  value='0' {{ $rests[0] == 0 ? 'checked' : '' }}/>営業日
        </div>
        <div class="rest-multi-parts">
          <label class="rest-multi-parts-label" for="mon">【　月曜日　】</label>
          <input class="rest-multi-input" type="radio" name="1" value='1' {{ $rests[1] == 1 ? 'checked' : '' }}/>休診日
          <input class="rest-multi-input" type="radio" name="1"  value='0' {{ $rests[1] == 0 ? 'checked' : '' }}/>営業日
        </div>
        <div class="rest-multi-parts">
          <label class="rest-multi-parts-label" for="tue">【　火曜日　】</label>
          <input class="rest-multi-input" type="radio" name="2" value='1' {{ $rests[2] == 1 ? 'checked' : '' }}/>休診日
          <input class="rest-multi-input" type="radio" name="2"  value='0' {{ $rests[2] == 0 ? 'checked' : '' }}/>営業日
        </div>
        <div class="rest-multi-parts">
          <label class="rest-multi-parts-label" for="wen">【　水曜日　】</label>
          <input class="rest-multi-input" type="radio" name="3" value='1' {{ $rests[3] == 1 ? 'checked' : '' }}/>休診日
          <input class="rest-multi-input" type="radio" name="3"  value='0' {{ $rests[3] == 0 ? 'checked' : '' }}/>営業日
        </div>
        <div class="rest-multi-parts">
          <label class="rest-multi-parts-label" for="thu">【　木曜日　】</label>
          <input class="rest-multi-input" type="radio" name="4" value='1' {{ $rests[4] == 1 ? 'checked' : '' }}/>休診日
          <input class="rest-multi-input" type="radio" name="4"  value='0' {{ $rests[4] == 0 ? 'checked' : '' }}/>営業日
        </div>
        <div class="rest-multi-parts">
          <label class="rest-multi-parts-label" for="fry">【　金曜日　】</label>
          <input class="rest-multi-input" type="radio" name="5" value='1' {{ $rests[5] == 1 ? 'checked' : '' }}/>休診日
          <input class="rest-multi-input" type="radio" name="5"  value='0' {{ $rests[5] == 0 ? 'checked' : '' }}/>営業日
        </div>
        <div class="rest-multi-parts">
          <label class="rest-multi-parts-label" for="sat">【　土曜日　】</label>
          <input class="rest-multi-input" type="radio" name="6" value='1' {{ $rests[6] == 1 ? 'checked' : '' }}/>休診日
          <input class="rest-multi-input" type="radio" name="6"  value='0' {{ $rests[6] == 0 ? 'checked' : '' }}/>営業日
        </div>
        <input type="hidden" name="staff" value="{{ $firstStaff }}">
        <div class="rest-multi-btn">
          <button type="submit">{{ __('sentences.admin_multi.edit') }}</button>
        </div>
    </form>
  </div>
  <script src="{{ asset('js/admin/available-time.js') }}"></script>
</x-admin-layout>

