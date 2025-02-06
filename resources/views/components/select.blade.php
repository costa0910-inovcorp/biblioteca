@props(['options' => [], 'multiple' => true, 'model' => 'form.authors', 'default'=> 'Select author (one or more)'])

<select {{ $attributes }} }} wire:model="{{ $model }}"  class="select select-bordered w-full max-w-xs" @if($multiple) multiple @endif>
    <option disabled selected>{{ $default }}</option>

    @foreach($options as $option)
        {{--        <option value="{{ $option->value }}">{{ $option->label }}</option>--}}
                <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
    @endforeach
</select>
