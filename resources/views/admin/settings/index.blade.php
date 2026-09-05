@extends('layouts.admin')

@section('title', 'Settings | NexaMart Admin')

@section('page-title', 'Settings')

@section('page-subtitle', 'Manage application settings')

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
   ALERTS
========================================================= */

.success-message {
    margin-bottom: 20px;
    padding: 12px 15px;
    border-radius: 7px;

    background: #e9f8ef;
    color: #198754;

    border: 1px solid #c9ecd7;

    font-size: 13px;
}

.error-message {
    margin-bottom: 20px;
    padding: 12px 15px;
    border-radius: 7px;

    background: #fdecec;
    color: #dc3545;

    border: 1px solid #f5caca;

    font-size: 13px;
}

.error-message ul {
    margin: 0;
    padding-left: 18px;
}


/* =========================================================
   SETTINGS CARD
========================================================= */

.settings-card {
    background: #ffffff;

    border: 1px solid #e5e7eb;

    border-radius: 12px;

    overflow: hidden;
}


/* =========================================================
   CARD TOP
========================================================= */

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
   SETTINGS TABLE
========================================================= */

.table-wrapper {
    width: 100%;

    overflow-x: auto;
}

.settings-table {
    width: 100%;

    min-width: 900px;

    border-collapse: collapse;
}

.settings-table th {
    background: #fafafa;

    color: #6b7280;

    font-size: 12px;

    font-weight: 700;

    text-transform: uppercase;

    padding: 14px 18px;

    text-align: left;

    border-bottom: 1px solid #e5e7eb;
}

.settings-table td {
    padding: 14px 18px;

    border-bottom: 1px solid #f0f0f0;

    font-size: 13px;

    vertical-align: middle;
}

.settings-table tbody tr:hover {
    background: #fffaf5;
}


/* =========================================================
   SETTING KEY
========================================================= */

.setting-key {
    color: #1f2937;

    font-weight: 600;

    word-break: break-word;
}

.setting-group {
    display: inline-block;

    margin-top: 5px;

    padding: 4px 8px;

    border-radius: 15px;

    background: #f3f4f6;

    color: #6b7280;

    font-size: 10px;

    font-weight: 600;
}


/* =========================================================
   VALUE INPUT
========================================================= */

.setting-input {
    width: 100%;

    min-width: 300px;

    padding: 10px 12px;

    border: 1px solid #d1d5db;

    border-radius: 7px;

    outline: none;

    font-size: 13px;

    color: #374151;

    background: #ffffff;

    box-sizing: border-box;
}

.setting-input:focus {
    border-color: #ff7a00;

    box-shadow:
        0 0 0 3px rgba(255, 122, 0, 0.10);
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

.status-active {
    background: #e9f8ef;

    color: #198754;
}

.status-inactive {
    background: #fdecec;

    color: #dc3545;
}


/* =========================================================
   STATUS CHECKBOX
========================================================= */

.status-box {
    display: flex;

    align-items: center;

    gap: 8px;
}

.status-box input {
    width: 17px;

    height: 17px;

    accent-color: #ff7a00;

    cursor: pointer;
}

.status-box label {
    font-size: 12px;

    color: #374151;

    cursor: pointer;
}


/* =========================================================
   ACTION
========================================================= */

.action-wrapper {
    display: flex;

    align-items: center;

    gap: 7px;

    white-space: nowrap;
}

.update-btn {
    border: none;

    border-radius: 6px;

    padding: 7px 11px;

    background: #fff3e8;

    color: #ff7a00;

    font-size: 12px;

    font-weight: 600;

    cursor: pointer;

    transition: 0.2s;
}

.update-btn:hover {
    background: #ff7a00;

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
   RESPONSIVE
========================================================= */

@media(max-width: 768px) {

    .page-header {
        flex-direction: column;

        align-items: stretch;

        gap: 15px;
    }

    .settings-table {
        min-width: 850px;
    }

}

@media(max-width: 576px) {

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
            Settings
        </h2>

        <p>
            Manage application settings
        </p>

    </div>

</div>


{{-- =========================================================
     SUCCESS MESSAGE
========================================================= --}}

@if(session('success'))

    <div class="success-message">

        {{ session('success') }}

    </div>

@endif


{{-- =========================================================
     ERROR MESSAGE
========================================================= --}}

@if($errors->any())

    <div class="error-message">

        <ul>

            @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif


{{-- =========================================================
     SETTINGS CARD
========================================================= --}}

<div class="settings-card">


    {{-- CARD HEADER --}}

    <div class="card-top">

        <h3>
            All Settings
        </h3>

        <span class="total-count">
            Total: {{ $settings->count() }}
        </span>

    </div>


    @if($settings->count())


        <div class="table-wrapper">


            <table class="settings-table">


                <thead>

                    <tr>

                        <th>
                            #
                        </th>

                        <th>
                            Setting
                        </th>

                        <th>
                            Value
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>


                    @foreach($settings as $setting)


                        <tr>


                            {{-- ID --}}

                            <td>

                                {{ $setting->id }}

                            </td>


                            {{-- SETTING --}}

                            <td>

                                <div class="setting-key">

                                    {{ $setting->key }}

                                </div>


                                <span class="setting-group">

                                    {{ $setting->group }}

                                </span>

                            </td>


                            {{-- VALUE --}}

                            <td>

                                <form
                                    action="{{ route('admin.settings.update', $setting) }}"
                                    method="POST"
                                    id="setting-form-{{ $setting->id }}"
                                >

                                    @csrf

                                    @method('PUT')


                                    <input
                                        type="text"
                                        name="value"
                                        class="setting-input"
                                        value="{{ $setting->value }}"
                                        placeholder="Enter setting value"
                                    >

                                </form>

                            </td>


                            {{-- STATUS --}}

                            <td>

                                @if($setting->status)

                                    <span class="status-badge status-active">
                                        Active
                                    </span>

                                @else

                                    <span class="status-badge status-inactive">
                                        Inactive
                                    </span>

                                @endif

                            </td>


                            {{-- ACTION --}}

                            <td>

                                <div class="action-wrapper">


                                    {{-- STATUS CONTROL --}}

                                    <div class="status-box">

                                        <input
                                            type="checkbox"
                                            id="status-{{ $setting->id }}"
                                            name="status"
                                            value="1"
                                            form="setting-form-{{ $setting->id }}"
                                            {{ $setting->status ? 'checked' : '' }}
                                        >

                                        <label
                                            for="status-{{ $setting->id }}"
                                        >
                                            Active
                                        </label>

                                    </div>


                                    {{-- UPDATE --}}

                                    <button
                                        type="submit"
                                        class="update-btn"
                                        form="setting-form-{{ $setting->id }}"
                                    >

                                        Update

                                    </button>


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
                No Settings Found
            </h3>

            <p>
                No application settings are available.
            </p>

        </div>


    @endif


</div>

@endsection