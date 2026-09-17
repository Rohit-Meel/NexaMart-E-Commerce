@extends('layouts.admin')

@section('title', 'Contacts | NexaMart Admin')

@section('page-title', 'Contacts')

@section('page-subtitle', 'Manage customer contact messages')
{{-- DataTables CSS --}}
<link
    rel="stylesheet"
    href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css"
>
@section('content')

<style>

    /* =========================================================
       PAGE HEADER
    ========================================================= */

    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 25px;
    }

    .page-title h2 {
        font-size: 25px;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .page-title p {
        color: #6b7280;
        font-size: 13px;
    }


    /* =========================================================
       CONTACT CARD
    ========================================================= */

    .contact-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
    }


    .card-top {
        padding: 18px 20px;
        border-bottom: 1px solid #e5e7eb;

        display: flex;
        align-items: center;
        justify-content: space-between;
    }


    .card-top h3 {
        font-size: 17px;
        color: #1f2937;
        margin: 0;
    }


    .total-count {
        color: #6b7280;
        font-size: 13px;
    }


    /* =========================================================
       TABLE
    ========================================================= */

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }


    .contact-table {
        width: 100% !important;
        min-width: 1050px;
        border-collapse: collapse;
    }


    .contact-table th {
        background: #fafafa !important;
        color: #6b7280;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;

        padding: 14px 18px;

        text-align: left;

        border-bottom: 1px solid #e5e7eb;
    }


    .contact-table td {
        padding: 14px 18px;

        border-bottom: 1px solid #f0f0f0;

        font-size: 13px;

        vertical-align: middle;
    }


    .contact-table tbody tr:hover {
        background: #fffaf5;
    }


    /* =========================================================
       CONTACT DATA
    ========================================================= */

    .contact-name {
        color: #1f2937;
        font-weight: 600;
    }


    .contact-email {
        color: #6b7280;
        font-size: 12px;
        margin-top: 3px;
    }


    .contact-subject {
        color: #374151;
        font-weight: 600;
    }


    .message-preview {
        color: #6b7280;
        font-size: 12px;
        max-width: 280px;
    }


    /* =========================================================
       STATUS
    ========================================================= */

    .status-badge {
        display: inline-block;

        padding: 5px 10px;

        border-radius: 20px;

        font-size: 11px;
        font-weight: 700;
    }


    .status-read {
        background: #e9f8ef;
        color: #198754;
    }


    .status-unread {
        background: #fff3e8;
        color: #ff7a00;
    }


    /* =========================================================
       ACTION BUTTONS
    ========================================================= */

    .action-wrapper {
        display: flex;
        align-items: center;
        gap: 7px;
        white-space: nowrap;
    }


    .action-wrapper form {
        margin: 0;
    }


    .action-btn {
        border: none;

        border-radius: 6px;

        padding: 7px 10px;

        font-size: 12px;

        cursor: pointer;

        text-decoration: none;

        display: inline-block;

        transition: 0.2s;
    }


    .view-btn {
        background: #eef2ff;
        color: #4f46e5;
    }


    .view-btn:hover {
        background: #4f46e5;
        color: #ffffff;
    }


    .toggle-btn {
        background: #fff3e8;
        color: #ff7a00;
    }


    .toggle-btn:hover {
        background: #ff7a00;
        color: #ffffff;
    }


    .delete-btn {
        background: #fdecec;
        color: #dc3545;
    }


    .delete-btn:hover {
        background: #dc3545;
        color: #ffffff;
    }


    /* =========================================================
       EMPTY STATE
    ========================================================= */

    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: #6b7280;
    }


    .empty-state h3 {
        margin-bottom: 6px;
        color: #374151;
    }


    /* =========================================================
       DATATABLE
    ========================================================= */

    .dataTables_wrapper {
        padding: 18px 20px 20px;
    }


    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 18px;
    }


    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_filter label {
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
    }


    .dataTables_wrapper .dataTables_length select {
        margin: 0 6px;

        padding: 7px 30px 7px 10px;

        border: 1px solid #d1d5db;

        border-radius: 6px;

        background: #ffffff;

        color: #374151;

        outline: none;

        cursor: pointer;
    }


    .dataTables_wrapper .dataTables_filter input {
        margin-left: 7px;

        padding: 8px 12px;

        width: 220px;

        border: 1px solid #d1d5db;

        border-radius: 6px;

        outline: none;

        font-size: 13px;
    }


    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #ff7a00;

        box-shadow: 0 0 0 3px rgba(255, 122, 0, 0.10);
    }


    .dataTables_wrapper .dataTables_info {
        padding-top: 16px;

        font-size: 12px;

        color: #6b7280;
    }


    .dataTables_wrapper .dataTables_paginate {
        padding-top: 12px;
    }


    .dataTables_wrapper .dataTables_paginate .paginate_button {
        min-width: 34px;

        height: 34px;

        line-height: 32px;

        padding: 0 9px !important;

        margin-left: 4px;

        border: 1px solid #e5e7eb !important;

        border-radius: 6px !important;

        background: #ffffff !important;

        color: #374151 !important;

        font-size: 12px;

        cursor: pointer;
    }


    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #fff3e8 !important;

        border-color: #ff7a00 !important;

        color: #ff7a00 !important;
    }


    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #ff7a00 !important;

        border-color: #ff7a00 !important;

        color: #ffffff !important;
    }


    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        background: #f9fafb !important;

        border-color: #e5e7eb !important;

        color: #c1c5ca !important;
    }


    table.dataTable.no-footer {
        border-bottom: 0 !important;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media(max-width: 768px) {

        .dataTables_wrapper {
            padding: 15px;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            width: 100%;
            text-align: left;
            margin-bottom: 12px;
        }

        .dataTables_wrapper .dataTables_filter input {
            width: 100%;
            margin-left: 0;
            margin-top: 7px;
        }

        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            width: 100%;
            text-align: left;
            margin-top: 8px;
        }

    }


    @media(max-width: 576px) {

        .page-header {
            flex-direction: column;
            align-items: stretch;
            gap: 15px;
        }

        .card-top {
            padding: 15px;
        }

    }

</style>


{{-- =========================================================
     PAGE HEADER
========================================================= --}}

<div class="page-header">

    <div class="page-title">

        <h2>
            Contacts
        </h2>

        <p>
            Manage customer contact messages
        </p>

    </div>

</div>


{{-- =========================================================
     SUCCESS MESSAGE
========================================================= --}}

@if(session('success'))

    <div class="alert alert-success">

        {{ session('success') }}

    </div>

@endif


{{-- =========================================================
     CONTACT CARD
========================================================= --}}

<div class="contact-card">


    <div class="card-top">

        <h3>
            All Contact Messages
        </h3>

        <span class="total-count">
            Total: {{ $contacts->count() }}
        </span>

    </div>


    @if($contacts->count())


        <div class="table-wrapper">

            <table
                id="contactsTable"
                class="contact-table display"
                style="width:100%"
            >

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Customer</th>

                        <th>Phone</th>

                        <th>Subject</th>

                        <th>Message</th>

                        <th>Status</th>

                        <th>Created</th>

                        <th>Actions</th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($contacts as $contact)

                        <tr>

                            {{-- ID --}}

                            <td>
                                {{ $contact->id }}
                            </td>


                            {{-- CUSTOMER --}}

                            <td>

                                <div class="contact-name">
                                    {{ $contact->name }}
                                </div>

                                <div class="contact-email">
                                    {{ $contact->email }}
                                </div>

                            </td>


                            {{-- PHONE --}}

                            <td>
                                {{ $contact->phone ?? 'N/A' }}
                            </td>


                            {{-- SUBJECT --}}

                            <td>

                                <div class="contact-subject">

                                    {{ $contact->subject ?? 'No Subject' }}

                                </div>

                            </td>


                            {{-- MESSAGE --}}

                            <td>

                                <div class="message-preview">

                                    {{ Str::limit($contact->message, 55) }}

                                </div>

                            </td>


                            {{-- STATUS --}}

                            <td>

                                @if($contact->status)

                                    <span class="status-badge status-read">
                                        Read
                                    </span>

                                @else

                                    <span class="status-badge status-unread">
                                        Unread
                                    </span>

                                @endif

                            </td>


                            {{-- CREATED --}}

                            <td data-order="{{ $contact->created_at->timestamp }}">

                                {{ $contact->created_at->format('d M Y') }}

                            </td>


                            {{-- ACTIONS --}}

                            <td>

                                <div class="action-wrapper">


                                    {{-- VIEW --}}

                                    <a
                                        href="{{ route('admin.contacts.show', $contact) }}"
                                        class="action-btn view-btn"
                                    >
                                        View
                                    </a>


                                    {{-- TOGGLE --}}

                                    <form
                                        action="{{ route('admin.contacts.toggle-status', $contact) }}"
                                        method="POST"
                                    >

                                        @csrf

                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="action-btn toggle-btn"
                                        >
                                            Toggle
                                        </button>

                                    </form>


                                    {{-- DELETE --}}

                                    <form
                                        action="{{ route('admin.contacts.destroy', $contact) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this contact?')"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="action-btn delete-btn"
                                        >
                                            Delete
                                        </button>

                                    </form>


                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


    @else


        <div class="empty-state">

            <h3>
                No Contact Messages Found
            </h3>

            <p>
                Customer contact messages will appear here.
            </p>

        </div>


    @endif


</div>
{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

{{-- DataTables JS --}}
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>

{{-- =========================================================
     DATATABLE
========================================================= --}}

<script>

    $(document).ready(function () {

        $('#contactsTable').DataTable({

            responsive: false,

            autoWidth: false,

            scrollX: true,

            scrollCollapse: true,

            pageLength: 10,

            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],

            order: [
                [0, 'desc']
            ],

            columnDefs: [

                {
                    orderable: false,
                    searchable: false,
                    targets: [7]
                }

            ],

            language: {

                search: "Search:",

                lengthMenu: "Show _MENU_ entries",

                info: "Showing _START_ to _END_ of _TOTAL_ contacts",

                infoEmpty: "Showing 0 to 0 of 0 contacts",

                infoFiltered: "(filtered from _MAX_ total contacts)",

                zeroRecords: "No matching contacts found",

                emptyTable: "No contacts available",

                paginate: {
                    first: "First",
                    last: "Last",
                    previous: "Previous",
                    next: "Next"
                }

            }

        });

    });

</script>

@endsection