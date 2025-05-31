<div class="col-lg-12 mt-4 pb-4">
    <input type="hidden" id="current_route" value="{{ $route }}">
    <input type="hidden" id="bulk_route" value="{{ $bulk }}">
    <div class="row mb-2">
        <div class="col-md-9">
            {{ $filters ?? '' }}
        </div>
        <div class="col-md-3">
            <form id="searchForm">
                <label class="search_sec">
                    Search:
                    <input type="search" id="searchBox" class="" placeholder="">
                </label>
            </form>
        </div>
    </div>
    <div class="row custom_table">
        <div class="col-lg-12">
            <table class="table">
                <thead>
                    <tr>
                        @if (isset($checkAll) && $checkAll)
                            <th>
                                <input type="checkbox" id="checkAll" class="checkALl">
                            </th>
                        @endif

                        <th colspan="{{ count($columns) }}" id="bulk-options" style="display: none;">
                            <div class="row">
                                <div class="col-lg-3">
                                    <select id="bulkOperation">
                                        <option value="">Select</option>
                                        <option value="1">Delete</option>
                                        <option value="2">Status Change</option>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <select name="" id="bulkStatus" style="display: none;">
                                        <option value="">Select</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </th>

                        @foreach ($columns as $column)
                            <th class="sorting {{ $column['sort']?'ar':'' }}" data-sort="{{ $column['sort'] }}" data-column="{{ $column['column'] }}"
                                scope="col">
                                {{ $column['label'] }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    {{ $slot }}
                </tbody>
            </table>
        </div>
    </div>
    <div class="row text-center">
        <div class="col-lg-12">
            {{ $data->links() }}
        </div>
    </div>

</div>

@push('scripts')
    <script src="{{ asset('backend/js/table.js') }}"></script>
@endpush
