@extends('layouts.admin')

@section('title', 'Add Coupon | NexaMart Admin')

@section('page-title', 'Add Coupon')

@section('page-subtitle', 'Create a new discount coupon')

@section('content')


<style>

/* =========================================================
   COUPON FORM CARD
========================================================= */

.coupon-form-card {
    background: #ffffff;

    border: 1px solid #e5e7eb;

    border-radius: 12px;

    overflow: hidden;
}


/* =========================================================
   FORM CARD HEADER
========================================================= */

.form-card-header {
    padding: 18px 20px;

    border-bottom: 1px solid #e5e7eb;

    display: flex;
    align-items: center;
    justify-content: space-between;
}


.form-card-header h3 {
    font-size: 17px;

    color: #1f2937;

    margin: 0;
}


.back-btn {
    display: inline-flex;

    align-items: center;

    gap: 7px;

    padding: 8px 12px;

    border-radius: 6px;

    background: #f1f5f9;

    color: #334155;

    text-decoration: none;

    font-size: 12px;

    font-weight: 600;

    transition: 0.2s;
}


.back-btn:hover {
    background: #ff7a00;

    color: #ffffff;
}


/* =========================================================
   FORM
========================================================= */

.coupon-form {
    padding: 20px;
}


.form-grid {
    display: grid;

    grid-template-columns: repeat(2, 1fr);

    gap: 18px 20px;
}


.form-group {
    display: flex;

    flex-direction: column;
}


.form-group label {
    margin-bottom: 6px;

    font-size: 13px;

    font-weight: 600;

    color: #334155;
}


.form-group input,
.form-group select,
.form-group textarea {

    width: 100%;

    padding: 9px 11px;

    border: 1px solid #d1d5db;

    border-radius: 6px;

    outline: none;

    background: #ffffff;

    color: #374151;

    font-size: 13px;

    box-sizing: border-box;

    transition: 0.2s;
}


.form-group textarea {
    resize: vertical;
}


.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {

    border-color: #ff7a00;

    box-shadow: 0 0 0 3px rgba(255, 122, 0, 0.10);
}


.form-group input::placeholder,
.form-group textarea::placeholder {

    color: #9ca3af;
}


/* =========================================================
   FULL WIDTH
========================================================= */

.full-width {
    grid-column: 1 / -1;
}


/* =========================================================
   CHECKBOX
========================================================= */

.checkbox-group {
    flex-direction: row;
}


.checkbox-label {

    display: flex;

    align-items: center;

    gap: 8px;

    margin: 0 !important;

    cursor: pointer;

    font-size: 13px !important;

    font-weight: 600 !important;

    color: #334155;
}


.checkbox-label input {

    width: 15px !important;

    height: 15px;

    margin: 0;

    accent-color: #ff7a00;

    cursor: pointer;
}


/* =========================================================
   FORM ACTIONS
========================================================= */

.form-actions {

    display: flex;

    justify-content: flex-end;

    align-items: center;

    gap: 8px;

    margin-top: 22px;

    padding-top: 18px;

    border-top: 1px solid #e5e7eb;
}


.cancel-btn,
.save-btn {

    border: none;

    border-radius: 6px;

    padding: 8px 13px;

    font-size: 12px;

    font-weight: 600;

    text-decoration: none;

    cursor: pointer;

    transition: 0.2s;
}


.cancel-btn {

    background: #f1f5f9;

    color: #334155;
}


.cancel-btn:hover {

    background: #e2e8f0;

    color: #334155;
}


.save-btn {

    background: #ff7a00;

    color: #ffffff;
}


.save-btn:hover {

    background: #e86f00;

    color: #ffffff;
}


/* =========================================================
   ERROR MESSAGE
========================================================= */

.coupon-error {

    margin-bottom: 18px;

    padding: 12px 15px;

    border: 1px solid #f5c2c7;

    border-radius: 7px;

    background: #fdecec;

    color: #dc3545;

    font-size: 13px;
}


.coupon-error ul {

    margin: 0;

    padding-left: 18px;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width: 768px) {

    .form-grid {

        grid-template-columns: 1fr;

    }


    .full-width {

        grid-column: auto;

    }


    .form-card-header {

        padding: 15px;
    }


    .coupon-form {

        padding: 15px;
    }

}


@media(max-width: 576px) {

    .form-card-header {

        flex-direction: column;

        align-items: stretch;

        gap: 12px;
    }


    .back-btn {

        justify-content: center;
    }


    .form-actions {

        flex-direction: column-reverse;

        align-items: stretch;
    }


    .cancel-btn,
    .save-btn {

        text-align: center;

        width: 100%;

        box-sizing: border-box;
    }

}

</style>



{{-- =========================================================
     ERROR MESSAGE
========================================================= --}}

@if($errors->any())

    <div class="coupon-error">

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
     COUPON FORM CARD
========================================================= --}}

<div class="coupon-form-card">


    {{-- CARD HEADER --}}

    <div class="form-card-header">

        <h3>
            Coupon Information
        </h3>


        <a
            href="{{ route('admin.coupons.index') }}"
            class="back-btn"
        >

            <i class="fa-solid fa-arrow-left"></i>

            Back

        </a>

    </div>



    {{-- FORM --}}

    <form
        action="{{ route('admin.coupons.store') }}"
        method="POST"
        class="coupon-form"
    >

        @csrf


        <div class="form-grid">


            {{-- COUPON CODE --}}

            <div class="form-group">

                <label>
                    Coupon Code
                </label>

                <input
                    type="text"
                    name="code"
                    value="{{ old('code') }}"
                    placeholder="SAVE20"
                    required
                >

            </div>



            {{-- DISCOUNT TYPE --}}

            <div class="form-group">

                <label>
                    Discount Type
                </label>

                <select
                    name="discount_type"
                    required
                >

                    <option
                        value="percentage"
                        @selected(old('discount_type', 'percentage') === 'percentage')
                    >
                        Percentage
                    </option>

                    <option
                        value="fixed"
                        @selected(old('discount_type') === 'fixed')
                    >
                        Fixed Amount
                    </option>

                </select>

            </div>



            {{-- DISCOUNT VALUE --}}

            <div class="form-group">

                <label>
                    Discount Value
                </label>

                <input
                    type="number"
                    name="discount_value"
                    step="0.01"
                    min="0"
                    value="{{ old('discount_value') }}"
                    placeholder="20"
                    required
                >

            </div>



            {{-- MINIMUM ORDER --}}

            <div class="form-group">

                <label>
                    Minimum Order Amount
                </label>

                <input
                    type="number"
                    name="minimum_order_amount"
                    step="0.01"
                    min="0"
                    value="{{ old('minimum_order_amount', 0) }}"
                    placeholder="0"
                >

            </div>



            {{-- MAXIMUM DISCOUNT --}}

            <div class="form-group">

                <label>
                    Maximum Discount
                </label>

                <input
                    type="number"
                    name="maximum_discount"
                    step="0.01"
                    min="0"
                    value="{{ old('maximum_discount') }}"
                    placeholder="500"
                >

            </div>



            {{-- USAGE LIMIT --}}

            <div class="form-group">

                <label>
                    Usage Limit
                </label>

                <input
                    type="number"
                    name="usage_limit"
                    min="1"
                    value="{{ old('usage_limit') }}"
                    placeholder="100"
                >

            </div>



            {{-- START DATE --}}

            <div class="form-group">

                <label>
                    Start Date
                </label>

                <input
                    type="datetime-local"
                    name="start_at"
                    value="{{ old('start_at') }}"
                >

            </div>



            {{-- END DATE --}}

            <div class="form-group">

                <label>
                    End Date
                </label>

                <input
                    type="datetime-local"
                    name="end_at"
                    value="{{ old('end_at') }}"
                >

            </div>



            {{-- DESCRIPTION --}}

            <div class="form-group full-width">

                <label>
                    Description
                </label>

                <textarea
                    name="description"
                    rows="4"
                    placeholder="Coupon description"
                >{{ old('description') }}</textarea>

            </div>



            {{-- STATUS --}}

            <div class="form-group checkbox-group">

                <label class="checkbox-label">

                    <input
                        type="checkbox"
                        name="status"
                        value="1"
                        {{ old('status', 1) ? 'checked' : '' }}
                    >

                    Active Coupon

                </label>

            </div>


        </div>



        {{-- FORM ACTIONS --}}

        <div class="form-actions">

            <a
                href="{{ route('admin.coupons.index') }}"
                class="cancel-btn"
            >
                Cancel
            </a>


            <button
                type="submit"
                class="save-btn"
            >
                Save Coupon
            </button>

        </div>


    </form>

</div>


@endsection