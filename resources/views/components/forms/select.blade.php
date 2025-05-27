<div class="{{ $attributes->get('size') }}" id="form-group-{{ $attributes->get('id') }}">

    <label for="{{ $attributes->get('id') }}" class="form-lable">{{ $label }}@if ($attributes->get('required'))
            <span style="color: red">*</span>
        @endif
    </label>
    <select class="w-100 {{ $attributes->get('class') }}" id="{{ $attributes->get('id') }}"
        name="{{ $attributes->get('name') }}" @if ($attributes->get('required')) required @endif>
        @if (!isset($showSelect))
            <option value="">Select</option>
        @endif

        @foreach ($options as $option)
            <option value="{{ $option['value'] }}" @if ($attributes->get('value') == $option['value']) selected @endif>
                {{ $option['label'] }}</option>
        @endforeach
    </select>
    @error($attributes->get('name'))
        <small id="{{ $attributes->get('id') }}" class="form-text text-danger">{{ $message }}</small>
    @enderror


</div>
