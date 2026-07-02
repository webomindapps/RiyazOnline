<x-app-layout>
    <div class="m-3 bg-white p-2 rounded">
        <div class="d-flex bg-primary text-white p-2 justify-content-between align-items-center rounded">
            <p>Email Panel</p>
            <a class="btn btn-sm border text-white" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
                aria-controls="collapseExample">
                <i class="bi bi-caret-down"></i>
            </a>
        </div>
        <div class="collapse mt-2" id="collapseExample">
            <div class="card card-body">
                <div class="form-group">
                    <label class="form-label" style="padding-top:1%">Template</label>
                    <div class="">
                        <select name="email_template" id="email_template" class="form-control"
                            onchange="get_email_content();">
                            <option value="">Select</option>
                            @foreach ($emailtemplates as $template)
                                <option value="{{ $template->id }}">{{ $template->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" style="padding-top:1%">Message</label>
                    <div class="">
                        <textarea class="form-control" name="mail_message" id="mail_message" rows="4" placeholder="Message *"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary float-end mt-3" value="Send Mail" onclick="sendMail()"
                        name="send_mail">
                </div>
            </div>
        </div>
    </div>

    <div class="m-3 bg-white">

        <x-admin.breadcrumb title="Penalty Payments" isCreate="{{ false }}" />



        @php

            $columns = [
                ['label' => 'Sl No', 'column' => 'id', 'sort' => true],

                ['label' => 'Roll No', 'column' => 'id', 'sort' => true],

                ['label' => 'Name', 'column' => 'f_name', 'sort' => true],

                ['label' => 'Mobile', 'column' => 'phone', 'sort' => true],

                ['label' => 'Course & Fees', 'column' => 'course_id', 'sort' => false],

                ['label' => 'Due Date', 'column' => 'due_date', 'sort' => true],

                ['label' => 'Penalty', 'column' => 'penalty', 'sort' => false],

                ['label' => 'Actions', 'column' => 'action', 'sort' => false],
            ];

        @endphp



        <x-table :columns="$columns" :data="$students" checkAll="{{ true }}" :bulk="route('admin.payments.penalty', ['customer' => 'bulk'])" :route="route('admin.payments.penalty')">

            @foreach ($students as $key => $item)
                @php

                    $actions = [
                        [
                            'code' => 'view',

                            'id' => $item->id,
                        ],
                    ];

                    $date1 = date_create($item->studentcourse?->due_date);

                    $date2 = date_create(date('d-m-Y'));

                    $diff = date_diff($date1, $date2);

                    $day_diff = $diff->format('%R%a');

                    if ($day_diff >= 1 && $day_diff <= 7) {
                        $penalty = '200';
                    } elseif ($day_diff >= 8 && $day_diff <= 14) {
                        $penalty = '400';
                    } elseif ($day_diff >= 15 && $day_diff <= 21) {
                        $penalty = '600';
                    } elseif ($day_diff >= 22 && $day_diff <= 28) {
                        $penalty = '800';
                    } elseif ($day_diff >= 29) {
                        $penalty = '1000';
                    }

                @endphp

                <tr>
                    <td>
                        <input type="checkbox" name="selected_items[]" class="student_check single-item-check" value="{{ $item->id }}">
                    </td>

                    <td>{{ $students->firstItem() + $key }}</td>

                    <td>{{ $item->id }}</td>

                    <td>{{ $item->f_name . ' ' . $item->l_name }}</td>

                    <td>{{ $item->phone }}</td>

                    <td>

                        {{ $item->studentcourse?->course_name }}<br>

                        <p>(RS. {{ $item->studentcourse?->course?->old_student_fees }})</p>

                    </td>

                    <td>

                        {{ date('d-m-Y', strtotime($item->studentcourse?->due_date)) }}<br>

                        {{ $diff->format('%a') }} Days

                    </td>

                    <td>

                        Rs. {{ $penalty }}<br>
                        <input type="number" style="width: 100px;height:30px;"
                            value="{{ $item->penalty_amount?$item->penalty_amount:''}}" onchange="change_penalty_amt({{ $item->id }}, this);">

                    </td>

                    <td>

                        <x-actions :item="$item" :options="$actions" />

                    </td>

                </tr>
            @endforeach

        </x-table>

    </div>
    @push('scripts')
        <script>
            function change_penalty_amt(id, el) {
                var penalty = $(el).val();
                
                $.ajax({
                    url: "{{ route('admin.student.penalty.change') }}",
                    type: "POST",
                    data: {
                        id: id,
                        penalty: penalty,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status == "success") {
                            location.reload();
                        } else {
                            alert('Failed to Join Date');
                        }
                    }
                });
            }
            function get_email_content() {
                id = $("#email_template").val();
                if (id == "") {
                    $("#mail_message").val("");
                    return;
                }
                jQuery.ajax({
                    type: "GET",
                    url: "{{ route('admin.get.email.content') }}",
                    datatype: "text",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        $("#mail_message").val("" + response.content + "");
                    },
                    error: function(xhr, ajaxOptions, thrownError) {}
                });
            }

            function sendMail() {
                student = [];
                content = $("#mail_message").val();
                mail_id = $("#email_template").val();                
                $('.student_check:checkbox:checked').each(function() {
                    student.push($(this).val());
                });
                if (student.length === 0) {
                    alert("Please select at least one student.");
                    return;
                }
                if (mail_id === "") {
                    alert("Please select one template.");
                    return;
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    type: "POST",
                    url: "{{ route('admin.student.bulk.mail') }}",
                    datatype: "text",
                    data: {
                        content: content,
                        student: student,
                        template_id:mail_id,
                    },
                    success: function(response) {
                        window.location.reload();
                    },
                    error: function(xhr, ajaxOptions, thrownError) {}
                });
            }
        </script>
    @endpush

</x-app-layout>
