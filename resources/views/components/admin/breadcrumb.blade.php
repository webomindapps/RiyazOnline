@props(['title', 'isCreate' => false, 'createLink' => '', 'isBack' => false, 'isBackLink' => url()->previous()])

<div class="py-3 bg-light border-bottom breadcrumb-admin">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 d-flex align-items-center">
                @if (isset($isBack) && $isBack)
                    <a href="{{ $isBackLink }}" class="me-2"><i class="bi bi-arrow-left-circle"></i></a>
                @endif
                <h5>{{ $title }}</h5>
            </div>
            <div class="col-lg-8 d-flex align-items-center justify-content-end">
                @if (isset($isCreate) && $isCreate)
                    <a href="{{ $createLink }}" class="add-btn">Add</a>
                @endif
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
