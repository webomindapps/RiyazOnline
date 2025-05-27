<div class="{{ $attributes->get('size') }}" id="form-group-{{ $attributes->get('id') }}">
    <label for="{{ $attributes->get('id') }}" class="form-lable">{{ $label }}@if ($attributes->get('required'))
            <span style="color: red">*</span>
        @endif
    </label>
    <input value="{{ $attributes->get('value') }}" class="{{ $attributes->get('class') }} form-control"
        type="{{ $attributes->get('type') }}" id="{{ $attributes->get('id') }}" name="{{ $attributes->get('name') }}"
        placeholder="{{ $attributes->get('placeholder') }}" @if ($attributes->get('required')) required @endif
        @if ($attributes->get('readonly')) readonly @endif @if ($attributes->get('multiple')) multiple @endif>

    @error($attributes->get('name'))
        <small id="{{ $attributes->get('id') }}" class="form-text text-danger">{{ $message }}</small>
    @enderror

    @if (isset($image))
        @if ($attributes->get('multiple'))
            <div id="image-section">
            </div>
        @else
            <img id="preview-image-{{ $attributes->get('id') }}"
                @if (isset($imageValue)) src="{{ $imageValue }}" @endif height="100px" width="100px" />
        @endif

    @endif

    @if (isset($file))
        <div>
            <a target="_blank" href="{{ $file }}">{{ $fileTitle ?? 'Uploaded File' }}</a>
        </div>
    @endif


</div>
