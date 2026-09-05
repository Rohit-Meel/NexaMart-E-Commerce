@extends('layouts.admin')

@section('title', 'Add Banner | NexaMart Admin')

@section('page-title', 'Add Banner')

@section('page-subtitle', 'Create a new promotional banner')

@section('content')

<style>

    .form-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        max-width: 1000px;
    }


    .form-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e5e7eb;
    }


    .form-card-header h2 {
        font-size: 18px;
        color: #1f2937;
        margin-bottom: 5px;
    }


    .form-card-header p {
        font-size: 13px;
        color: #6b7280;
    }


    .banner-form {
        padding: 24px;
    }


    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }


    .form-group {
        display: flex;
        flex-direction: column;
    }


    .form-group label {
        margin-bottom: 7px;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
    }


    .required {
        color: #dc3545;
    }


    .form-control {
        width: 100%;
        padding: 11px 13px;

        border: 1px solid #d1d5db;
        border-radius: 7px;

        outline: none;

        font-size: 13px;
        color: #374151;

        background: #ffffff;

        box-sizing: border-box;
    }


    .form-control:focus {
        border-color: #ff7a00;

        box-shadow: 0 0 0 3px rgba(255, 122, 0, 0.10);
    }


    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }


    .image-input {
        padding: 8px 10px;
    }


    .image-help {
        margin-top: 6px;
        font-size: 11px;
        color: #6b7280;
    }


    .full-width {
        grid-column: 1 / -1;
    }


    .status-box {
        display: flex;
        align-items: center;
        gap: 10px;
    }


    .status-box input {
        width: 17px;
        height: 17px;

        accent-color: #ff7a00;

        cursor: pointer;
    }


    .status-box label {
        margin: 0;
        cursor: pointer;
    }


    .error-message {
        margin-top: 6px;

        color: #dc3545;

        font-size: 12px;
    }


    .form-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;

        gap: 10px;

        margin-top: 25px;

        padding-top: 20px;

        border-top: 1px solid #e5e7eb;
    }


    .btn {
        border: none;

        border-radius: 7px;

        padding: 11px 18px;

        font-size: 13px;

        font-weight: 600;

        cursor: pointer;

        text-decoration: none;
    }


    .btn-primary {
        background: #ff7a00;
        color: #ffffff;
    }


    .btn-primary:hover {
        background: #e86f00;
        color: #ffffff;
    }


    .btn-secondary {
        background: #f3f4f6;
        color: #374151;
    }


    .btn-secondary:hover {
        background: #e5e7eb;
    }


    @media(max-width: 768px) {

        .form-grid {
            grid-template-columns: 1fr;
        }


        .full-width {
            grid-column: auto;
        }

    }


    @media(max-width: 576px) {

        .banner-form {
            padding: 18px;
        }


        .form-actions {
            justify-content: stretch;
        }


        .form-actions .btn {
            flex: 1;
            text-align: center;
        }

    }

</style>


<div class="form-card">


    <div class="form-card-header">

        <h2>
            Create Banner
        </h2>

        <p>
            Add a new promotional banner.
        </p>

    </div>


    <form
        action="{{ route('admin.banners.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="banner-form"
    >

        @csrf


        <div class="form-grid">


            {{-- TITLE --}}

            <div class="form-group">

                <label for="title">
                    Banner Title <span class="required">*</span>
                </label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    class="form-control"
                    value="{{ old('title') }}"
                    placeholder="Enter banner title"
                    required
                >

                @error('title')

                    <div class="error-message">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- IMAGE --}}

            <div class="form-group">

                <label for="image">
                    Banner Image <span class="required">*</span>
                </label>

                <input
                    type="file"
                    id="image"
                    name="image"
                    class="form-control image-input"
                    accept=".jpg,.jpeg,.png,.webp"
                    required
                >

                <div class="image-help">
                    Allowed: JPG, JPEG, PNG, WEBP. Maximum size: 2MB.
                </div>

                @error('image')

                    <div class="error-message">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- DESCRIPTION --}}

            <div class="form-group full-width">

                <label for="description">
                    Description
                </label>

                <textarea
                    id="description"
                    name="description"
                    class="form-control"
                    placeholder="Enter banner description"
                >{{ old('description') }}</textarea>

                @error('description')

                    <div class="error-message">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- BUTTON TEXT --}}

            <div class="form-group">

                <label for="button_text">
                    Button Text
                </label>

                <input
                    type="text"
                    id="button_text"
                    name="button_text"
                    class="form-control"
                    value="{{ old('button_text') }}"
                    placeholder="Shop Now"
                >

                @error('button_text')

                    <div class="error-message">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- BUTTON URL --}}

            <div class="form-group">

                <label for="button_url">
                    Button URL
                </label>

                <input
                    type="text"
                    id="button_url"
                    name="button_url"
                    class="form-control"
                    value="{{ old('button_url') }}"
                    placeholder="https://example.com"
                >

                @error('button_url')

                    <div class="error-message">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- SORT ORDER --}}

            <div class="form-group">

                <label for="sort_order">
                    Sort Order
                </label>

                <input
                    type="number"
                    id="sort_order"
                    name="sort_order"
                    class="form-control"
                    value="{{ old('sort_order', 0) }}"
                    min="0"
                >

                @error('sort_order')

                    <div class="error-message">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- START DATE --}}

            <div class="form-group">

                <label for="start_at">
                    Start Date
                </label>

                <input
                    type="datetime-local"
                    id="start_at"
                    name="start_at"
                    class="form-control"
                    value="{{ old('start_at') }}"
                >

                @error('start_at')

                    <div class="error-message">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- END DATE --}}

            <div class="form-group">

                <label for="end_at">
                    End Date
                </label>

                <input
                    type="datetime-local"
                    id="end_at"
                    name="end_at"
                    class="form-control"
                    value="{{ old('end_at') }}"
                >

                @error('end_at')

                    <div class="error-message">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- STATUS --}}

            <div class="form-group">

                <div class="status-box">

                    <input
                        type="checkbox"
                        id="status"
                        name="status"
                        value="1"
                        {{ old('status', 1) ? 'checked' : '' }}
                    >

                    <label for="status">
                        Active Banner
                    </label>

                </div>

            </div>


        </div>


        <div class="form-actions">

            <a
                href="{{ route('admin.banners.index') }}"
                class="btn btn-secondary"
            >
                Cancel
            </a>


            <button
                type="submit"
                class="btn btn-primary"
            >
                Save Banner
            </button>

        </div>


    </form>

</div>

@endsection