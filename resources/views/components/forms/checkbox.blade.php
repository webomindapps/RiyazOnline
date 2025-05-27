<div class="{{ $attributes->get('size') }}"  id="form-group-{{ $attributes->get('id') }}">
    <div class="form-group">
        <label class="form-label" for="{{ $attributes->get('id') }}">{{ $label }}@if ($attributes->get('required'))
                <span style="color: red">*</span>
            @endif
        </label>

        @if ($attributes->get('multiple'))

            @foreach ($attributes->get('checkbox-values') as $option)
                <div>
                    <label>
                        <input type="checkbox" name="{{ $attributes->get('name') }}"
                            @if (in_array($option['value'], $attributes->get('value'))) checked @endif value="{{ $option['value'] }}">
                        {{ $option['label'] }}
                    </label>
                </div>
            @endforeach
        @else
            @foreach ($attributes->get('checkbox-values') as $option)
                <div>
                    <label for="{{ $option['value'] }}">
                        <input type="checkbox" id="{{ $option['value'] }}" name="{{ $attributes->get('name') }}"
                            value="{{ $option['value'] }}" @if ($attributes->get('value') == $option['value']) checked @endif
                            onclick="selectOne(this)">
                        {{ $option['label'] }}
                    </label>
                </div>
            @endforeach

        @endif

        @error($attributes->get('name'))
            <small id="{{ $attributes->get('id') }}" class="form-text text-danger">{{ $message }}</small>
        @enderror

    </div>
</div>
