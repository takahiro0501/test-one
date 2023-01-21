<x-admin-layout>
    <div class="staff-edit-box">
        <div class="staff-edit-title">
            <h1>{{ __('sentences.admin_staff_edit.title') }}</h1>
        </div>
        <div class="admin-staff-create">
            <form method="POST" action="{{ route('admin.staff.edit.exe') }}">
                @csrf
                <div class="staff-edit-parts">
                    <div class="staff-edit-label">
                        <label for="name">
                            {{ __('sentences.admin_staff_edit.name') }}
                        </label>
                    </div>
                    <input class="staff-edit-input" id="name" type="text" name="name" value="{{ old('name', $staff->name) }}" placeholder="30文字以内で記入してください"/>
                    @if ($errors->has('name'))
                        <div class="staff-edit-error">
                            {{$errors->first('name')}}
                        </div>
                    @endif
                </div>
                <div class="staff-edit-parts">
                    <div class="staff-edit-label">
                        <label for="pripority">
                            {{ __('sentences.admin_staff_edit.priority') }}
                        </label>
                    </div>
                    <select name="priority" class="admin-staff-select">
                        @for ($i = 1; $i <= $count; $i++)
                        <option value="{{ $i }}" {{ $staff->priority == $i  ? 'selected' : ''}}>{{$i}}</option>
                        @endfor
                    </select>
                </div>
                <input type="hidden" name="id" value="{{ old('id',$staff->id) }}"></input>
                <div class="staff-edit-btn">
                    <button type="submit">{{ __('sentences.admin_staff_edit.edit') }}</button>
                </div>
                <div class="staff-edit-back">
                    <a href="{{ route('admin.staff') }}">{{ __('sentences.admin_staff_edit.back') }}</a></button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>

