@extends('layouts.admin')

@section('title', 'Edit Review | NexaMart Admin')

@section('page-title', 'Edit Review')

@section('page-subtitle', 'Update customer product review')

@section('content')


<style>

.review-form-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    max-width: 900px;
}

.form-card-header {
    padding: 20px 24px;
    border-bottom: 1px solid #e5e7eb;
}

.form-card-header h2 {
    font-size: 18px;
    color: #1f2937;
    margin: 0 0 5px;
}

.form-card-header p {
    font-size: 13px;
    color: #6b7280;
    margin: 0;
}

.review-form {
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

.form-group.full-width {
    grid-column: 1 / -1;
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

.error-message {
    margin-top: 6px;
    color: #dc3545;
    font-size: 12px;
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
}

.btn-secondary {
    background: #f3f4f6;
    color: #374151;
}

.btn-secondary:hover {
    background: #e5e7eb;
}

@media(max-width:768px) {

    .form-grid {
        grid-template-columns: 1fr;
    }

    .form-group.full-width {
        grid-column: auto;
    }

}

</style>


<div class="review-form-card">


    <div class="form-card-header">

        <h2>
            Edit Review
        </h2>

        <p>
            Update the details of this customer review.
        </p>

    </div>


    <form
        action="{{ route('admin.reviews.update', $review) }}"
        method="POST"
        class="review-form"
    >

        @csrf

        @method('PUT')


        <div class="form-grid">


            <div class="form-group">

                <label for="customer_id">
                    Customer <span class="required">*</span>
                </label>

                <select
                    id="customer_id"
                    name="customer_id"
                    class="form-control"
                    required
                >

                    <option value="">
                        Select Customer
                    </option>

                    @foreach($customers as $customer)

                        <option
                            value="{{ $customer->id }}"
                            @selected(
                                old(
                                    'customer_id',
                                    $review->customer_id
                                ) == $customer->id
                            )
                        >
                            {{ $customer->name ?? 'Customer #' . $customer->id }}
                        </option>

                    @endforeach

                </select>

                @error('customer_id')

                    <div class="error-message">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            <div class="form-group">

                <label for="product_id">
                    Product <span class="required">*</span>
                </label>

                <select
                    id="product_id"
                    name="product_id"
                    class="form-control"
                    required
                >

                    <option value="">
                        Select Product
                    </option>

                    @foreach($products as $product)

                        <option
                            value="{{ $product->id }}"
                            @selected(
                                old(
                                    'product_id',
                                    $review->product_id
                                ) == $product->id
                            )
                        >
                            {{ $product->name ?? 'Product #' . $product->id }}
                        </option>

                    @endforeach

                </select>

                @error('product_id')

                    <div class="error-message">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            <div class="form-group">

                <label for="order_id">
                    Order
                </label>

                <select
                    id="order_id"
                    name="order_id"
                    class="form-control"
                >

                    <option value="">
                        No Order
                    </option>

                    @foreach($orders as $order)

                        <option
                            value="{{ $order->id }}"
                            @selected(
                                old(
                                    'order_id',
                                    $review->order_id
                                ) == $order->id
                            )
                        >
                            Order #{{ $order->id }}
                        </option>

                    @endforeach

                </select>

                @error('order_id')

                    <div class="error-message">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            <div class="form-group">

                <label for="rating">
                    Rating <span class="required">*</span>
                </label>

                <select
                    id="rating"
                    name="rating"
                    class="form-control"
                    required
                >

                    @for($i = 5; $i >= 1; $i--)

                        <option
                            value="{{ $i }}"
                            @selected(
                                old(
                                    'rating',
                                    $review->rating
                                ) == $i
                            )
                        >
                            {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                        </option>

                    @endfor

                </select>

                @error('rating')

                    <div class="error-message">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            <div class="form-group full-width">

                <label for="comment">
                    Comment
                </label>

                <textarea
                    id="comment"
                    name="comment"
                    class="form-control"
                    placeholder="Enter review comment"
                >{{ old('comment', $review->comment) }}</textarea>

                @error('comment')

                    <div class="error-message">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            <div class="form-group">

                <div class="status-box">

                    <input
                        type="checkbox"
                        id="status"
                        name="status"
                        value="1"
                        @checked(
                            old(
                                'status',
                                $review->status
                            )
                        )
                    >

                    <label for="status">
                        Active Review
                    </label>

                </div>

            </div>


        </div>


        <div class="form-actions">

            <a
                href="{{ route('admin.reviews.index') }}"
                class="btn btn-secondary"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="btn btn-primary"
            >
                Update Review
            </button>

        </div>


    </form>

</div>


@endsection