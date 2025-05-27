var table = {
    search: '',
    orderedColumn: "",
    orderBy: 'asc',
    type: null,
    paginate: null,
}
$(document).ready(function () {
    let search = new URLSearchParams(window.location.search).get("search");
    let orderedColumn = new URLSearchParams(window.location.search).get("orderedColumn");
    let orderBy = new URLSearchParams(window.location.search).get("orderBy");
    let type = new URLSearchParams(window.location.search).get("type");
    let paginate = new URLSearchParams(window.location.search).get("paginate");


    table.search = search ? search : '';
    $('#searchBox').val(search ? search : '');
    table.orderedColumn = orderedColumn ? orderedColumn : '';
    table.orderBy = orderBy ? orderBy : '';
    table.type = type ? type : null;
    table.paginate = paginate ? paginate : null;
    $('#per_page').val(paginate ? paginate : '10');

});


$(document).on('click', '.sorting', function () {
    var isSort = $(this).data('sort');
    var column = $(this).data('column');
    if (isSort) {
        let orderBy = new URLSearchParams(window.location.search).get("orderBy");
        if (!orderBy) {
            table.orderBy = 'asc';
        } else if (orderBy == 'asc') {
            table.orderBy = 'desc'
        } else {
            table.orderBy = 'asc';
        }
        table.orderedColumn = column;
        getRecords();
    }
});

$('#searchForm').submit(function (e) {
    e.preventDefault();
    table.search = $('#searchBox').val();
    getRecords();
});
$('#searchBox').on('change', function (e) {
    e.preventDefault();
    table.search = $(this).val();
    getRecords();
});

$('#per_page').on('change', function () {
    table.paginate = $(this).val();
    getRecords();
});

function getRecords() {
    let route_name = $('#current_route').val();
    let url = route_name + `?${$.param(table)}`;
    window.location.href = url;
}


$('#clearFilters').on('click', function () {
    window.location.href = $('#current_route').val()
})



//multiple selection

var masterCheck = $("#checkAll");
var listCheckItems = $(".single-item-check");
var getCheckedValues = [];

masterCheck.on("click", function () {
    var isMasterChecked = $(this).is(":checked");
    listCheckItems.prop("checked", isMasterChecked);
    $('#bulk-options').show();
    $('.sorting').hide()
    getSelectedItems();
});

listCheckItems.on("change", function () {
    console.log('changed');
    // Total Checkboxes in list
    var totalItems = listCheckItems.length;
    // Total Checked Checkboxes in list
    var checkedItems = listCheckItems.filter(":checked").length;

    //If all are checked
    if (totalItems == checkedItems) {
        $('#bulk-options').show();
        $('.sorting').hide()
    }
    // Not all but only some are checked
    else if (checkedItems > 0 && checkedItems < totalItems) {
        $('#bulk-options').show();
        $('.sorting').hide()
    } //If none is checked
    else {
        $('#bulk-options').hide();
        $('.sorting').show()
    }
    getSelectedItems();
})

function getSelectedItems() {
    getCheckedValues = [];
    listCheckItems.filter(":checked").each(function () {
        getCheckedValues.push($(this).val());
    });
    if (getCheckedValues.length == 0) {
        $('#bulk-options').hide();
        $('.sorting').show()
    }

}


$('#bulkOperation').on('change', function () {
    var value = $(this).val();
    handleSelectedOperation(parseInt(value));
})

$('#bulkStatus').on('change', function () {
    if (confirm('Are you you want to perform this operations?')) {
        handleBulkOperations()
    }
})

function handleSelectedOperation(type) {
    switch (type) {
        case 1:
            handleDelete();
            break;
        case 2:
            handleStatus();
            break;
    }
}

function handleDelete() {
    $('#bulkStatus').css('display', 'none')
    if (confirm('Are you sure you want to delete this')) {
        handleBulkOperations()
    }
    $('#bulkOperation').val('')
}

function handleStatus() {
    $('#bulkStatus').css('display', 'block')
}

function handleBulkOperations(type = null, status = null) {
    let deleteRoute = $('#bulk_route').val();
    let formData = {
        selectedIds: getCheckedValues,
        type: type ? type : $('#bulkOperation').val(),
        status: status ? status : $('#bulkStatus').val()
    }
    fetch(deleteRoute, {
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
        },
        method: 'DELETE',
        credentials: "same-origin",
        body: JSON.stringify(formData),

    })
        .then(res => res.json()) // or res.json()
        .then(res => {
            if (res.success) {
                window.location.reload()
            }
        })
}


//perform single operations
$('.singleItem').on('click', function () {
    if (confirm('Are you sure you want to perform this action?')) {
        var type = $(this).data('type')
        var id = $(this).data('id')
        var status = $(this).data('value')
        getCheckedValues = [];
        getCheckedValues.push(id);
        handleBulkOperations(type, String(status))
    }
})