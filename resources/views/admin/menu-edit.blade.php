<x-admin-layout>
    <div class="menu-edit-box">
        <div class="menu-edit-title">
            <h1>{{ __('sentences.admin_menu_edit.title') }}</h1>
        </div>
        <div class="admin-menu-create">
            <form method="POST" action="{{ route('admin.menu.edit.exe') }}">
                @csrf
                <div class="menu-edit-parts">
                    <div class="menu-edit-label">
                        <label for="name">
                            {{ __('sentences.admin_menu_edit.name') }}
                        </label>
                    </div>
                    <input class="menu-edit-input-name" id="name" type="text" name="name" value="{{ old('name', $menu->name) }}" placeholder="30文字以内で記入してください"/>
                    @if ($errors->has('name'))
                        <div class="menu-edit-error">
                            {{$errors->first('name')}}
                        </div>
                    @endif
                </div>

                <div class="menu-edit-parts">
                    <p class="menu-edit-label">
                        <label for="time">
                            {{ __('sentences.admin_menu_edit.time') }}
                        </label>
                    </p>
                    <input class="menu-edit-input" id="time" type="text" name="time" value="{{ old('time',$menu->time) }}" oninput="value = value.replace(/[^0-9]+/i,'');" placeholder="半角数字で記入してください"/>
                    @if ($errors->has('time'))
                    <div class="menu-edit-error">
                        {{$errors->first('time')}}
                    </div>
                    @endif
                </div>

                <div class="menu-edit-parts">
                    <p class="menu-edit-label">
                        <label for="money">
                            {{ __('sentences.admin_menu_edit.money') }}
                        </label>
                    </p>
                    <input class="menu-edit-input" id="money" type="text" name="money" value="{{ old('money',$menu->money) }}" oninput="value = value.replace(/[^0-9]+/i,'');" placeholder="半角数字で記入してください"/>
                    @if ($errors->has('money'))
                    <div class="menu-edit-error">
                        {{$errors->first('money')}}
                    </div>
                    @endif
                </div>
                <div class="menu-edit-parts">
                <p class="menu-edit-label-textarea"><label for="overview">{{ __('sentences.admin_menu.overview') }}</label></p>
                <textarea class="menu-edit-textarea" id="overview" name="overview" placeholder="300字以内で記入してください">{{ old('overview',$menu->overview) }}</textarea>
                </div>
                @if ($errors->has('overview'))
                <div class="menu-edit-error">
                    {{$errors->first('overview')}}
                </div>
                @endif

                <div class="menu-edit-parts">
                    <p class="menu-edit-label">
                        <label for="time">
                            {{ __('sentences.admin_menu_edit.priority') }}
                        </label>
                    </p>
                    <select name="priority" class="admin-menu-select">
                        @for ($i = 1; $i <= $count; $i++)
                        <option value="{{ $i }}" {{ $menu->priority == $i  ? 'selected' : ''}}>{{$i}}</option>
                        @endfor
                    </select>
                </div>
                <input type="hidden" name="id" value="{{ old('id',$menu->id) }}"></input>
                <div class="menu-edit-btn">
                    <button type="submit">{{ __('sentences.admin_menu_edit.edit') }}</button>
                </div>
                <div class="menu-edit-back">
                    <a href="{{ route('admin.menu') }}">{{ __('sentences.admin_menu_edit.back') }}</a></button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>

