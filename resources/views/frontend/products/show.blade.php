@extends('layouts.frontend')

@section('title', $product->name . ' - NexaMart')

@section('content')

@php

    /* =========================================================
       PRICE / DISCOUNT
    ========================================================= */

    $originalPrice = (float) $product->price;

    $salePrice = $product->sale_price !== null
        ? (float) $product->sale_price
        : $originalPrice;

    $discount = 0;

    if ($originalPrice > 0 && $salePrice < $originalPrice) {

        $discount = round(
            (($originalPrice - $salePrice) / $originalPrice) * 100
        );

    }


    /* =========================================================
       REVIEWS
    ========================================================= */

    $reviewCount = $product->reviews->count();

    $averageRating = $reviewCount > 0
        ? $product->reviews->avg('rating')
        : 0;


    /* =========================================================
       WISHLIST
    ========================================================= */

    $isWishlisted = false;

    if (auth('customer')->check()) {

        $isWishlisted = auth('customer')
            ->user()
            ->wishlists()
            ->where('product_id', $product->id)
            ->exists();

    }


    /* =========================================================
       PRODUCT IMAGES
    ========================================================= */

    $productImages = collect();

    if ($product->thumbnail) {

        $productImages->push($product->thumbnail);

    }

    foreach ($product->images as $productImage) {

        if (
            !empty($productImage->image) &&
            !$productImages->contains($productImage->image)
        ) {

            $productImages->push($productImage->image);

        }

    }

    if ($productImages->isEmpty()) {

        $productImages->push('banner.png');

    }

@endphp


<style>

/* =========================================================
   PRODUCT DETAIL PAGE
========================================================= */

.product-detail-page{
    width:100%;
    padding:20px 0 40px;
    background:#fff;
}

.product-detail-container{
    width:100%;
    max-width:1120px;
    margin:0 auto;
    padding:0 18px;
}


/* =========================================================
   BREADCRUMB
========================================================= */

.product-breadcrumb{
    display:flex;
    align-items:center;
    flex-wrap:wrap;
    gap:5px;
    margin-bottom:14px;
    font-size:10px;
    color:#003680;
}

.product-breadcrumb a{
    color:#003680;
    text-decoration:none;
}

.product-breadcrumb a:hover{
    color:#cd001c;
}

.product-breadcrumb .current{
    color:#777;
}


/* =========================================================
   MAIN PRODUCT AREA
========================================================= */

.product-detail-main{
    display:grid;
    grid-template-columns:48% 52%;
    gap:24px;
    align-items:start;
}


/* =========================================================
   GALLERY
========================================================= */

.product-gallery{
    width:100%;
}

.product-main-image-box{
    position:relative;
    width:100%;
    height:315px;
    border:1px solid #dce4ed;
    border-radius:8px;
    background:#f8fbff;
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
}

.product-main-image-box > img{
    width:100%;
    height:100%;
    padding:15px;
    object-fit:contain;
}


/* DISCOUNT */

.product-detail-discount{
    position:absolute;
    top:9px;
    left:9px;
    z-index:5;
    padding:4px 7px;
    border-radius:3px;
    background:#cd001c;
    color:#fff;
    font-size:8px;
    font-weight:700;
}


/* WISHLIST */

.product-detail-wishlist{
    position:absolute;
    top:8px;
    right:8px;
    z-index:10;
}

.product-detail-wishlist-form{
    margin:0;
    padding:0;
}

.product-detail-wishlist-btn{
    width:30px;
    height:30px;
    padding:0;
    border:0;
    border-radius:50%;
    background:#fff;
    color:#003680;
    box-shadow:0 2px 8px rgba(0,0,0,.10);
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    text-decoration:none;
    font-size:12px;
}

.product-detail-wishlist-btn:hover{
    color:#cd001c;
}

.product-detail-wishlist-btn.active{
    color:#cd001c;
}


/* THUMBNAILS */

.product-thumbnails{
    display:flex;
    align-items:center;
    gap:7px;
    margin-top:8px;
    overflow-x:auto;
}

.product-thumbnail{
    flex:0 0 48px;
    width:48px;
    height:48px;
    padding:3px;
    border:1px solid #dce4ed;
    border-radius:6px;
    background:#fff;
    cursor:pointer;
}

.product-thumbnail.active{
    border:2px solid #003680;
}

.product-thumbnail img{
    width:100%;
    height:100%;
    object-fit:contain;
}


/* =========================================================
   PRODUCT INFORMATION
========================================================= */

.product-detail-info{
    min-width:0;
    padding-top:1px;
}

.product-detail-category{
    margin-bottom:2px;
    color:#003680;
    font-size:9px;
    font-weight:700;
}

.product-detail-title{
    margin:0 0 5px;
    color:#003680;
    font-size:21px;
    line-height:1.2;
    font-weight:700;
}


/* RATING */

.product-detail-rating{
    display:flex;
    align-items:center;
    gap:5px;
    margin-bottom:7px;
}

.product-stars{
    color:#ff7a00;
    font-size:10px;
    letter-spacing:1px;
}

.product-rating-number{
    color:#003680;
    font-size:10px;
    font-weight:600;
}

.product-review-link{
    color:#777;
    font-size:9px;
}


/* PRICE */

.product-detail-price-box{
    display:flex;
    align-items:center;
    flex-wrap:wrap;
    gap:7px;
    margin-bottom:8px;
}

.product-detail-sale-price{
    color:#cd001c;
    font-size:18px;
    font-weight:700;
}

.product-detail-old-price{
    color:#999;
    font-size:9px;
    text-decoration:line-through;
}

.product-detail-off{
    padding:3px 5px;
    border-radius:3px;
    background:#fff1f3;
    color:#cd001c;
    font-size:8px;
    font-weight:700;
}


/* SHORT DESCRIPTION */

.product-detail-short-description{
    padding-bottom:8px;
    margin-bottom:8px;
    border-bottom:1px solid #e6ebf1;
    color:#555;
    font-size:9px;
    line-height:1.45;
}


/* =========================================================
   META
========================================================= */

.product-detail-meta{
    padding-bottom:8px;
    margin-bottom:8px;
    border-bottom:1px solid #e6ebf1;
}

.product-meta-item{
    display:grid;
    grid-template-columns:85px 1fr;
    gap:7px;
    margin-bottom:4px;
    font-size:9px;
    line-height:1.3;
}

.product-meta-item:last-child{
    margin-bottom:0;
}

.product-meta-label{
    color:#003680;
    font-weight:700;
}

.product-meta-value{
    color:#555;
    font-weight:400;
}


/* =========================================================
   STOCK
========================================================= */

.product-stock{
    display:inline-flex;
    align-items:center;
    gap:4px;
    margin-bottom:8px;
    padding:4px 7px;
    border-radius:12px;
    font-size:8px;
    font-weight:600;
}

.product-stock.in-stock{
    background:#eefaf2;
    color:#16803c;
}

.product-stock.out-stock{
    background:#fff1f3;
    color:#cd001c;
}


/* =========================================================
   QUANTITY
========================================================= */

.product-quantity-wrapper{
    display:flex;
    align-items:center;
    gap:7px;
    margin-bottom:8px;
}

.product-quantity-label{
    color:#003680;
    font-size:9px;
    font-weight:700;
}

.product-quantity{
    display:flex;
    align-items:center;
    height:27px;
    border:1px solid #d9e2ec;
    border-radius:5px;
    overflow:hidden;
}

.product-quantity button{
    width:26px;
    height:27px;
    padding:0;
    border:0;
    background:#f7f9fc;
    color:#003680;
    cursor:pointer;
    font-size:11px;
    font-weight:700;
}

.product-quantity input{
    width:34px;
    height:27px;
    padding:0;
    border:0;
    border-left:1px solid #d9e2ec;
    border-right:1px solid #d9e2ec;
    outline:none;
    text-align:center;
    color:#003680;
    font-size:9px;
    font-weight:600;
}


/* =========================================================
   ACTION BUTTONS
========================================================= */

.product-detail-actions{
    display:flex;
    align-items:center;
    gap:6px;
    flex-wrap:wrap;
}

.product-action-form{
    margin:0;
}

.product-add-cart-btn,
.product-buy-now-btn,
.product-login-btn{
    min-height:32px;
    padding:0 11px;
    border:0;
    border-radius:4px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:5px;
    font-size:9px;
    font-weight:700;
    text-decoration:none;
    cursor:pointer;
}

.product-add-cart-btn{
    background:#003680;
    color:#fff;
}

.product-buy-now-btn{
    background:#ff7a00;
    color:#fff;
}

.product-login-btn{
    background:#003680;
    color:#fff;
}

.product-add-cart-btn:hover,
.product-buy-now-btn:hover,
.product-login-btn:hover{
    color:#fff;
}


/* =========================================================
   INFORMATION CARDS
========================================================= */

.product-information-section{
    margin-top:20px;
}

.product-information-card{
    margin-bottom:8px;
    border:1px solid #dce4ed;
    border-radius:6px;
    overflow:hidden;
    background:#fff;
}

.product-information-heading{
    padding:7px 10px;
    border-bottom:1px solid #dce4ed;
    background:#f7faff;
}

.product-information-heading h2{
    margin:0;
    color:#003680;
    font-size:10px;
    font-weight:700;
}

.product-information-body{
    padding:8px 10px;
}


/* =========================================================
   PRODUCT DETAILS TABLE
========================================================= */

.product-details-table{
    width:100%;
    border-collapse:collapse;
}

.product-details-table tr{
    border-bottom:1px solid #f0f2f5;
}

.product-details-table tr:last-child{
    border-bottom:0;
}

.product-details-table td{
    padding:3px 2px;
    font-size:9px;
    line-height:1.3;
}

.product-details-table td:first-child{
    width:130px;
    color:#003680;
    font-weight:700;
}

.product-details-table td:last-child{
    color:#555;
    font-weight:400;
}


/* =========================================================
   DESCRIPTION
========================================================= */

.product-description-section .product-information-body{
    padding:8px 10px;
}

.product-description{
    color:#555;
    font-size:9px;
    line-height:1.45;
}


/* =========================================================
   REVIEWS
========================================================= */

.product-reviews-section{
    margin-top:0;
}

.product-review-summary{
    padding:8px 10px;
}

.product-review-score{
    display:flex;
    align-items:center;
    gap:6px;
}

.product-review-score-number{
    color:#003680;
    font-size:15px;
    font-weight:700;
}

.product-review-score-stars{
    color:#ff7a00;
    font-size:9px;
    letter-spacing:1px;
}

.product-review-score-count{
    color:#777;
    font-size:8px;
}

.product-review-list{
    margin-top:6px;
}

.product-review-item{
    padding:7px 0;
    border-top:1px solid #edf0f4;
}

.product-review-top{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:10px;
}

.product-review-user{
    color:#003680;
    font-size:9px;
    font-weight:700;
}

.product-review-stars{
    margin-top:2px;
    color:#ff7a00;
    font-size:8px;
}

.product-review-date{
    color:#999;
    font-size:8px;
}

.product-review-text{
    margin-top:4px;
    color:#555;
    font-size:9px;
    line-height:1.4;
}

.product-no-reviews{
    padding:8px 0 2px;
    color:#888;
    font-size:8px;
    text-align:center;
}


/* =========================================================
   RELATED PRODUCTS
========================================================= */

.related-products-section{
    margin-top:22px;
}

.related-products-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:10px;
}

.related-products-header h2{
    margin:0;
    color:#003680;
    font-size:17px;
    font-weight:700;
}

.related-products-view-all{
    color:#003680;
    font-size:9px;
    font-weight:600;
    text-decoration:none;
}

.related-products-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:12px;
}


/* RELATED CARD */

.related-product-card{
    position:relative;
    overflow:hidden;
    border:1px solid #dce4ed;
    border-radius:7px;
    background:#fff;
    transition:.2s ease;
}

.related-product-card:hover{
    transform:translateY(-2px);
    box-shadow:0 5px 14px rgba(0,0,0,.08);
}


/* RELATED IMAGE */

.related-product-image{
    position:relative;
    width:100%;
    height:155px;
    background:#f8fbff;
    overflow:hidden;
}

.related-product-image a{
    display:block;
    width:100%;
    height:100%;
}

.related-product-image img{
    width:100%;
    height:100%;
    padding:9px;
    object-fit:contain;
}

.related-product-discount{
    position:absolute;
    top:7px;
    left:7px;
    z-index:2;
    padding:3px 5px;
    border-radius:3px;
    background:#cd001c;
    color:#fff;
    font-size:7px;
    font-weight:700;
}


/* RELATED CONTENT */

.related-product-content{
    padding:8px;
}

.related-product-category{
    margin-bottom:3px;
    color:#003680;
    font-size:7px;
    font-weight:600;
}

.related-product-name{
    margin:0;
    min-height:28px;
    font-size:10px;
    line-height:1.35;
}

.related-product-name a{
    color:#003680;
    text-decoration:none;
}

.related-product-name a:hover{
    color:#cd001c;
}

.related-product-price{
    display:flex;
    align-items:center;
    gap:5px;
    margin-top:5px;
}

.related-product-sale-price{
    color:#cd001c;
    font-size:11px;
    font-weight:700;
}

.related-product-old-price{
    color:#999;
    font-size:8px;
    text-decoration:line-through;
}


/* =========================================================
   NO RELATED PRODUCTS
========================================================= */

.no-related-products{
    padding:18px;
    border:1px solid #dce4ed;
    border-radius:6px;
    background:#f8fbff;
    color:#777;
    text-align:center;
    font-size:9px;
}


/* =========================================================
   TOAST
========================================================= */

.product-detail-toast{
    position:fixed;
    top:20px;
    right:20px;
    z-index:99999;
    min-width:220px;
    padding:9px 12px;
    border-radius:6px;
    background:#16803c;
    color:#fff;
    display:flex;
    align-items:center;
    gap:6px;
    font-size:10px;
    box-shadow:0 5px 18px rgba(0,0,0,.14);
    opacity:0;
    visibility:hidden;
    transform:translateY(-10px);
    transition:.25s ease;
}

.product-detail-toast.show{
    opacity:1;
    visibility:visible;
    transform:translateY(0);
}

.product-detail-toast.error{
    background:#cd001c;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width:991px){

    .product-detail-main{
        grid-template-columns:1fr 1fr;
        gap:18px;
    }

    .product-main-image-box{
        height:285px;
    }

    .related-products-grid{
        grid-template-columns:repeat(2,1fr);
    }

}


@media(max-width:700px){

    .product-detail-main{
        grid-template-columns:1fr;
    }

    .product-main-image-box{
        height:290px;
    }

    .product-detail-title{
        font-size:19px;
    }

    .related-products-grid{
        grid-template-columns:repeat(2,1fr);
        gap:9px;
    }

    .related-product-image{
        height:140px;
    }

}


@media(max-width:480px){

    .product-detail-container{
        padding:0 12px;
    }

    .product-detail-page{
        padding-top:15px;
    }

    .product-main-image-box{
        height:250px;
    }

    .product-detail-sale-price{
        font-size:17px;
    }

    .product-information-heading{
        padding:6px 8px;
    }

    .product-information-body{
        padding:7px 8px;
    }

    .product-details-table td{
        font-size:8px;
    }

    .product-details-table td:first-child{
        width:105px;
    }

    .related-product-image{
        height:125px;
    }

    .related-product-content{
        padding:7px;
    }

}
/* =========================================================
   PRODUCT REVIEWS
========================================================= */

.product-reviews-section {
    padding: 45px 0 10px;
}


.product-reviews-container {
    width: calc(100% - 72px);
    max-width: 1280px;
    margin: 0 auto;
}


/* =========================================================
   HEADER
========================================================= */

.product-reviews-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 25px;

    margin-bottom: 25px;
}


.product-section-label {
    display: block;

    margin-bottom: 7px;

    color: #FF7A00;

    font-size: 12px;
    font-weight: 700;

    letter-spacing: 2px;
}


.product-reviews-header h2 {
    margin: 0;

    color: #003680;

    font-size: 28px;
    font-weight: 700;
}


/* =========================================================
   AVERAGE RATING
========================================================= */

.product-average-rating {
    min-width: 150px;

    padding: 14px 18px;

    border: 1px solid #d9e2f0;

    border-radius: 12px;

    background: #fff;

    text-align: center;
}


.product-average-rating strong {
    display: block;

    color: #003680;

    font-size: 26px;
    line-height: 1;
}


.product-average-stars {
    margin: 7px 0 4px;

    color: #FF7A00;

    font-size: 15px;
}


.product-average-rating small {
    color: #64748b;

    font-size: 12px;
}


/* =========================================================
   WRITE REVIEW BOX
========================================================= */

.write-review-box {
    margin-bottom: 28px;

    padding: 24px;

    border: 1px solid #dce5f1;

    border-radius: 14px;

    background: #fff;
}


.write-review-heading {
    margin-bottom: 20px;
}


.write-review-heading h3 {
    margin: 0 0 5px;

    color: #003680;

    font-size: 21px;
}


.write-review-heading p {
    margin: 0;

    color: #64748b;

    font-size: 14px;
}


/* =========================================================
   FORM
========================================================= */

.review-form-group {
    position: relative;

    margin-bottom: 20px;
}


.review-form-group label {
    display: block;

    margin-bottom: 9px;

    color: #003680;

    font-size: 14px;
    font-weight: 700;
}


.review-form-group label span {
    color: #DC001C;
}


.review-star-selector {
    display: flex;
    align-items: center;

    gap: 5px;
}


.review-star-btn {
    width: 38px;
    height: 38px;

    padding: 0;

    border: 1px solid #d8e1ee;

    border-radius: 8px;

    background: #fff;

    color: #FF7A00;

    font-size: 18px;

    cursor: pointer;

    transition: .2s ease;
}


.review-star-btn:hover {
    border-color: #FF7A00;

    transform: translateY(-1px);
}


.review-star-btn.selected {
    border-color: #FF7A00;

    background: #fff7ef;

    color: #FF7A00;
}


.review-form-group textarea {
    display: block;

    width: 100%;

    min-height: 130px;

    padding: 13px 15px;

    border: 1px solid #d8e1ee;

    border-radius: 10px;

    outline: none;

    resize: vertical;

    color: #334155;

    font-family: inherit;

    font-size: 14px;

    box-sizing: border-box;

    transition: .2s ease;
}


.review-form-group textarea:focus {
    border-color: #003680;

    box-shadow: 0 0 0 3px rgba(0, 54, 128, .08);
}


.review-character-count {
    margin-top: 5px;

    color: #94a3b8;

    font-size: 12px;

    text-align: right;
}


.submit-review-btn {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    gap: 8px;

    padding: 11px 20px;

    border: 0;

    border-radius: 8px;

    background: #003680;

    color: #fff;

    font-size: 14px;
    font-weight: 700;

    cursor: pointer;

    transition: .2s ease;
}


.submit-review-btn:hover {
    background: #DC001C;

    transform: translateY(-1px);
}


/* =========================================================
   LOGIN BOX
========================================================= */

.review-login-box {
    display: flex;

    align-items: center;
    justify-content: space-between;

    gap: 20px;

    margin-bottom: 28px;

    padding: 18px 20px;

    border: 1px solid #dce5f1;

    border-radius: 12px;

    background: #fff;
}


.review-login-box > div {
    display: flex;

    align-items: center;

    gap: 13px;
}


.review-login-box > div > i {
    color: #FF7A00;

    font-size: 25px;
}


.review-login-box strong {
    display: block;

    margin-bottom: 3px;

    color: #003680;

    font-size: 15px;
}


.review-login-box span {
    display: block;

    color: #64748b;

    font-size: 13px;
}


.review-login-box a {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    padding: 9px 16px;

    border-radius: 7px;

    background: #003680;

    color: #fff;

    font-size: 13px;
    font-weight: 700;

    text-decoration: none;
}


.review-login-box a:hover {
    background: #DC001C;
}


/* =========================================================
   ALREADY REVIEWED
========================================================= */

.review-already-submitted {
    display: flex;

    align-items: center;

    gap: 13px;

    margin-bottom: 28px;

    padding: 16px 20px;

    border: 1px solid #cfe0f3;

    border-radius: 11px;

    background: #f7faff;
}


.review-already-submitted > i {
    color: #16A34A;

    font-size: 22px;
}


.review-already-submitted strong {
    display: block;

    margin-bottom: 3px;

    color: #003680;

    font-size: 14px;
}


.review-already-submitted span {
    display: block;

    color: #64748b;

    font-size: 13px;
}


/* =========================================================
   MESSAGE
========================================================= */

.review-message {
    display: flex;

    align-items: center;

    gap: 9px;

    margin-bottom: 22px;

    padding: 12px 15px;

    border-radius: 8px;

    font-size: 13px;
    font-weight: 600;
}


.review-message-success {
    border: 1px solid #bbf7d0;

    background: #f0fdf4;

    color: #16A34A;
}


.review-message-error {
    border: 1px solid #fecaca;

    background: #fef2f2;

    color: #DC001C;
}


.review-error {
    display: block;

    margin-top: 6px;

    color: #DC001C;

    font-size: 12px;
}


/* =========================================================
   REVIEWS LIST
========================================================= */

.product-reviews-list {
    display: flex;

    flex-direction: column;

    gap: 14px;
}


.customer-review-card {
    padding: 18px 20px;

    border: 1px solid #dce5f1;

    border-radius: 12px;

    background: #fff;
}


.customer-review-top {
    display: flex;

    align-items: center;
    justify-content: space-between;

    gap: 20px;

    margin-bottom: 12px;
}


.customer-review-user {
    display: flex;

    align-items: center;

    gap: 11px;
}


.customer-review-avatar {
    display: flex;

    align-items: center;
    justify-content: center;

    width: 42px;
    height: 42px;

    overflow: hidden;

    border-radius: 50%;

    background: #003680;

    color: #fff;

    font-size: 15px;
    font-weight: 700;
}


.customer-review-avatar img {
    width: 100%;
    height: 100%;

    object-fit: cover;
}


.customer-review-user strong {
    display: block;

    margin-bottom: 3px;

    color: #003680;

    font-size: 14px;
}


.customer-review-user small {
    display: block;

    color: #94a3b8;

    font-size: 11px;
}


.customer-review-rating {
    color: #FF7A00;

    font-size: 13px;

    white-space: nowrap;
}


.customer-review-comment {
    margin: 0;

    color: #475569;

    font-size: 14px;

    line-height: 1.7;
}


/* =========================================================
   NO REVIEWS
========================================================= */

.no-product-reviews {
    padding: 35px 20px;

    border: 1px dashed #d5dfed;

    border-radius: 12px;

    background: #fff;

    text-align: center;
}


.no-product-reviews i {
    margin-bottom: 10px;

    color: #FF7A00;

    font-size: 28px;
}


.no-product-reviews h3 {
    margin: 0 0 5px;

    color: #003680;

    font-size: 17px;
}


.no-product-reviews p {
    margin: 0;

    color: #64748b;

    font-size: 13px;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 768px) {

    .product-reviews-container {
        width: calc(100% - 30px);
    }


    .product-reviews-header {
        align-items: flex-start;

        flex-direction: column;
    }


    .product-average-rating {
        width: 100%;

        box-sizing: border-box;
    }


    .review-login-box {
        align-items: flex-start;

        flex-direction: column;
    }


    .review-login-box a {
        width: 100%;

        box-sizing: border-box;
    }


    .customer-review-top {
        align-items: flex-start;

        flex-direction: column;
    }

}

</style>


<section class="product-detail-page">

    <div class="product-detail-container">


        {{-- =====================================================
             BREADCRUMB
        ====================================================== --}}

        <div class="product-breadcrumb">

            <a href="{{ route('home') }}">
                Home
            </a>

            <span>/</span>

            <a href="{{ route('products') }}">
                Products
            </a>

            @if($product->category)

                <span>/</span>

                <a
                    href="{{ route('products', ['category' => $product->category->slug]) }}"
                >
                    {{ $product->category->name }}
                </a>

            @endif

            <span>/</span>

            <span class="current">
                {{ $product->name }}
            </span>

        </div>


        {{-- =====================================================
             MAIN PRODUCT
        ====================================================== --}}

        <div class="product-detail-main">


            {{-- =================================================
                 GALLERY
            ================================================== --}}

            <div class="product-gallery">

                <div class="product-main-image-box">


                    {{-- DISCOUNT --}}

                    @if($discount > 0)

                        <span class="product-detail-discount">
                            -{{ $discount }}%
                        </span>

                    @endif


                    {{-- WISHLIST --}}

                    <div class="product-detail-wishlist">

                        @auth('customer')

                            @if($isWishlisted)

                                <form
                                    action="{{ route('wishlist.remove', $product->id) }}"
                                    method="POST"
                                    class="product-detail-wishlist-form"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="product-detail-wishlist-btn active"
                                        title="Remove from Wishlist"
                                    >

                                        <i class="fa-solid fa-heart"></i>

                                    </button>

                                </form>

                            @else

                                <form
                                    action="{{ route('wishlist.add', $product->id) }}"
                                    method="POST"
                                    class="product-detail-wishlist-form"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="product-detail-wishlist-btn"
                                        title="Add to Wishlist"
                                    >

                                        <i class="fa-regular fa-heart"></i>

                                    </button>

                                </form>

                            @endif

                        @else

                            <a
                                href="{{ route('login') }}"
                                class="product-detail-wishlist-btn"
                                title="Login to add Wishlist"
                            >

                                <i class="fa-regular fa-heart"></i>

                            </a>

                        @endauth

                    </div>


                    {{-- MAIN IMAGE --}}

                    @php
                        $firstImage = $productImages->first();
                    @endphp

                    <img
                        id="productMainImage"
                        src="{{ $firstImage === 'banner.png'
                            ? asset('assets/images/logo/banner.png')
                            : asset('assets/images/products/' . $firstImage) }}"
                        alt="{{ $product->name }}"
                    >

                </div>


                {{-- =================================================
                     THUMBNAILS
                ================================================== --}}

                <div class="product-thumbnails">

                    @foreach($productImages as $index => $image)

                        <button
                            type="button"
                            class="product-thumbnail {{ $index === 0 ? 'active' : '' }}"
                            data-image="{{ $image === 'banner.png'
                                ? asset('assets/images/logo/banner.png')
                                : asset('assets/images/products/' . $image) }}"
                        >

                            <img
                                src="{{ $image === 'banner.png'
                                    ? asset('assets/images/logo/banner.png')
                                    : asset('assets/images/products/' . $image) }}"
                                alt="{{ $product->name }}"
                            >

                        </button>

                    @endforeach

                </div>

            </div>


            {{-- =================================================
                 PRODUCT INFORMATION
            ================================================== --}}

            <div class="product-detail-info">


                {{-- CATEGORY --}}

                @if($product->category)

                    <div class="product-detail-category">
                        {{ $product->category->name }}
                    </div>

                @endif


                {{-- TITLE --}}

                <h1 class="product-detail-title">
                    {{ $product->name }}
                </h1>


                {{-- RATING --}}

                <div class="product-detail-rating">

                    <div class="product-stars">

                        @for($i = 1; $i <= 5; $i++)

                            @if($averageRating >= $i)

                                <i class="fa-solid fa-star"></i>

                            @elseif($averageRating >= ($i - 0.5))

                                <i class="fa-solid fa-star-half-stroke"></i>

                            @else

                                <i class="fa-regular fa-star"></i>

                            @endif

                        @endfor

                    </div>

                    <span class="product-rating-number">
                        {{ number_format($averageRating, 1) }}
                    </span>

                    <span class="product-review-link">
                        ({{ $reviewCount }} Reviews)
                    </span>

                </div>


                {{-- PRICE --}}

                <div class="product-detail-price-box">

                    <span class="product-detail-sale-price">
                        ₹{{ number_format($salePrice, 2) }}
                    </span>

                    @if($discount > 0)

                        <span class="product-detail-old-price">
                            ₹{{ number_format($originalPrice, 2) }}
                        </span>

                        <span class="product-detail-off">
                            {{ $discount }}% OFF
                        </span>

                    @endif

                </div>


                {{-- SHORT DESCRIPTION --}}

                @if($product->description)

                    <div class="product-detail-short-description">
                        {{ $product->description }}
                    </div>

                @endif


                {{-- PRODUCT META --}}

                <div class="product-detail-meta">


                    {{-- BRAND --}}

                    <div class="product-meta-item">

                        <span class="product-meta-label">
                            Brand:
                        </span>

                        <span class="product-meta-value">
                            {{ $product->brand?->name ?? 'N/A' }}
                        </span>

                    </div>


                    {{-- SKU --}}

                    <div class="product-meta-item">

                        <span class="product-meta-label">
                            SKU:
                        </span>

                        <span class="product-meta-value">
                            {{ $product->sku }}
                        </span>

                    </div>


                    {{-- SUB CATEGORY --}}

                    @if($product->subCategory)

                        <div class="product-meta-item">

                            <span class="product-meta-label">
                                Sub Category:
                            </span>

                            <span class="product-meta-value">
                                {{ $product->subCategory->name }}
                            </span>

                        </div>

                    @endif


                    {{-- SELLER --}}

                    @if($product->vendor)

                        <div class="product-meta-item">

                            <span class="product-meta-label">
                                Seller:
                            </span>

                            <span class="product-meta-value">
                                {{ $product->vendor->shop_name }}
                            </span>

                        </div>

                    @endif

                </div>


                {{-- STOCK --}}

                @if($product->stock > 0)

                    <div class="product-stock in-stock">

                        <i class="fa-solid fa-circle-check"></i>

                        <span>
                            In Stock ({{ $product->stock }} available)
                        </span>

                    </div>

                @else

                    <div class="product-stock out-stock">

                        <i class="fa-solid fa-circle-xmark"></i>

                        <span>
                            Out of Stock
                        </span>

                    </div>

                @endif


                {{-- QUANTITY --}}

                @if($product->stock > 0)

                    <div class="product-quantity-wrapper">

                        <span class="product-quantity-label">
                            Quantity:
                        </span>

                        <div class="product-quantity">

                            <button
                                type="button"
                                id="quantityMinus"
                            >
                                -
                            </button>

                            <input
                                type="number"
                                id="productQuantity"
                                value="1"
                                min="1"
                                max="{{ $product->stock }}"
                                readonly
                            >

                            <button
                                type="button"
                                id="quantityPlus"
                            >
                                +
                            </button>

                        </div>

                    </div>

                @endif


                {{-- ACTIONS --}}

                <div class="product-detail-actions">

                    @if($product->stock > 0)

                        @auth('customer')


                            {{-- ADD TO CART --}}

                            <form
                                action="{{ route('cart.add', $product->id) }}"
                                method="POST"
                                class="product-action-form"
                                id="addToCartForm"
                            >

                                @csrf

                                <input
                                    type="hidden"
                                    name="quantity"
                                    id="cartQuantity"
                                    value="1"
                                >

                                <button
                                    type="submit"
                                    class="product-add-cart-btn"
                                    id="addToCartButton"
                                >

                                    <i class="fa-solid fa-cart-shopping"></i>

                                    Add to Cart

                                </button>

                            </form>


                            {{-- BUY NOW --}}

                            <form
                                action="{{ route('buy.now', $product->id) }}"
                                method="POST"
                                class="product-action-form"
                            >

                                @csrf

                                <input
                                    type="hidden"
                                    name="quantity"
                                    id="buyNowQuantity"
                                    value="1"
                                >

                                <button
                                    type="submit"
                                    class="product-buy-now-btn"
                                >

                                    <i class="fa-solid fa-bolt"></i>

                                    Buy Now

                                </button>

                            </form>


                        @else

                            <a
                                href="{{ route('login') }}"
                                class="product-login-btn"
                            >

                                <i class="fa-solid fa-right-to-bracket"></i>

                                Login to Buy

                            </a>

                        @endauth

                    @else

                        <button
                            type="button"
                            class="product-add-cart-btn"
                            disabled
                            style="opacity:.55;cursor:not-allowed;"
                        >

                            <i class="fa-solid fa-cart-shopping"></i>

                            Out of Stock

                        </button>

                    @endif

                </div>

            </div>

        </div>


        {{-- =========================================================
             PRODUCT DETAILS
        ========================================================== --}}

        <div class="product-information-section">


            <div class="product-information-card">

                <div class="product-information-heading">

                    <h2>
                        Product Details
                    </h2>

                </div>


                <div class="product-information-body">

                    <table class="product-details-table">

                        <tbody>


                            {{-- PRODUCT NAME --}}

                            <tr>

                                <td>
                                    Product Name
                                </td>

                                <td>
                                    {{ $product->name }}
                                </td>

                            </tr>


                            {{-- CATEGORY --}}

                            @if($product->category)

                                <tr>

                                    <td>
                                        Category
                                    </td>

                                    <td>
                                        {{ $product->category->name }}
                                    </td>

                                </tr>

                            @endif


                            {{-- SUB CATEGORY --}}

                            @if($product->subCategory)

                                <tr>

                                    <td>
                                        Sub Category
                                    </td>

                                    <td>
                                        {{ $product->subCategory->name }}
                                    </td>

                                </tr>

                            @endif


                            {{-- BRAND --}}

                            @if($product->brand)

                                <tr>

                                    <td>
                                        Brand
                                    </td>

                                    <td>
                                        {{ $product->brand->name }}
                                    </td>

                                </tr>

                            @endif


                            {{-- SELLER --}}

                            @if($product->vendor)

                                <tr>

                                    <td>
                                        Seller
                                    </td>

                                    <td>
                                        {{ $product->vendor->shop_name }}
                                    </td>

                                </tr>

                            @endif


                            {{-- SKU --}}

                            <tr>

                                <td>
                                    SKU
                                </td>

                                <td>
                                    {{ $product->sku }}
                                </td>

                            </tr>


                            {{-- AVAILABILITY --}}

                            <tr>

                                <td>
                                    Availability
                                </td>

                                <td>

                                    @if($product->stock > 0)

                                        In Stock

                                    @else

                                        Out of Stock

                                    @endif

                                </td>

                            </tr>


                        </tbody>

                    </table>

                </div>

            </div>


            {{-- =====================================================
                 DESCRIPTION
            ====================================================== --}}

            @if($product->description)

                <div class="product-information-card product-description-section">

                    <div class="product-information-heading">

                        <h2>
                            Description
                        </h2>

                    </div>


                    <div class="product-information-body">

                        <div class="product-description">
                            {{ $product->description }}
                        </div>

                    </div>

                </div>

            @endif

        </div>


        {{-- =========================================================
             CUSTOMER REVIEWS
        ========================================================== --}}

        <!-- =========================================================
     PRODUCT REVIEWS
========================================================= -->

<section class="product-reviews-section">

    <div class="product-reviews-container">

        <!-- =====================================================
             REVIEW HEADER
        ====================================================== -->

        <div class="product-reviews-header">

            <div>

                <span class="product-section-label">
                    CUSTOMER REVIEWS
                </span>

                <h2>
                    What Customers Say
                </h2>

            </div>


            @php

                $reviewCollection = $product->reviews
                    ->where('status', true);

                $reviewCount = $reviewCollection->count();

                $averageRating = $reviewCount > 0
                    ? round($reviewCollection->avg('rating'), 1)
                    : 0;

            @endphp


            <div class="product-average-rating">

                <strong>
                    {{ number_format($averageRating, 1) }}
                </strong>

                <div class="product-average-stars">

                    @for($i = 1; $i <= 5; $i++)

                        @if($i <= round($averageRating))

                            <i class="fa-solid fa-star"></i>

                        @else

                            <i class="fa-regular fa-star"></i>

                        @endif

                    @endfor

                </div>

                <small>
                    {{ $reviewCount }}
                    {{ $reviewCount == 1 ? 'Review' : 'Reviews' }}
                </small>

            </div>

        </div>


        <!-- =====================================================
             WRITE REVIEW
        ====================================================== -->

        @auth('customer')

            @php

                $customerHasReviewed = $product->reviews
                    ->where('customer_id', auth('customer')->id())
                    ->count() > 0;

            @endphp


            @if($customerHasReviewed)

                <div class="review-already-submitted">

                    <i class="fa-solid fa-circle-check"></i>

                    <div>

                        <strong>
                            You have already reviewed this product.
                        </strong>

                        <span>
                            Thank you for sharing your experience.
                        </span>

                    </div>

                </div>

            @else

                <div class="write-review-box">

                    <div class="write-review-heading">

                        <h3>
                            Write a Review
                        </h3>

                        <p>
                            Share your experience with this product.
                        </p>

                    </div>


                    <form
                        action="{{ route('reviews.store', $product->id) }}"
                        method="POST"
                        class="product-review-form"
                        id="productReviewForm">

                        @csrf


                        <!-- RATING -->

                        <div class="review-form-group">

                            <label>
                                Your Rating
                                <span>*</span>
                            </label>


                            <div
                                class="review-star-selector"
                                id="reviewStarSelector">

                                @for($i = 1; $i <= 5; $i++)

                                    <button
                                        type="button"
                                        class="review-star-btn"
                                        data-rating="{{ $i }}"
                                        aria-label="Rate {{ $i }} out of 5">

                                        <i class="fa-regular fa-star"></i>

                                    </button>

                                @endfor

                            </div>


                            <input
                                type="hidden"
                                name="rating"
                                id="reviewRating"
                                value="{{ old('rating') }}">


                            @error('rating')

                                <small class="review-error">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>


                        <!-- COMMENT -->

                        <div class="review-form-group">

                            <label for="reviewComment">

                                Your Review

                                <span>*</span>

                            </label>


                            <textarea
                                name="comment"
                                id="reviewComment"
                                rows="5"
                                maxlength="2000"
                                placeholder="Write your experience with this product..."
                                required>{{ old('comment') }}</textarea>


                            <div class="review-character-count">

                                <span id="reviewCharacterCount">
                                    0
                                </span>

                                / 2000

                            </div>


                            @error('comment')

                                <small class="review-error">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>


                        <!-- SUBMIT -->

                        <button
                            type="submit"
                            class="submit-review-btn">

                            <i class="fa-solid fa-paper-plane"></i>

                            Submit Review

                        </button>

                    </form>

                </div>

            @endif

        @else

            <div class="review-login-box">

                <div>

                    <i class="fa-regular fa-star"></i>

                    <div>

                        <strong>
                            Want to review this product?
                        </strong>

                        <span>
                            Login to share your rating and experience.
                        </span>

                    </div>

                </div>


                <a href="{{ route('login') }}">

                    Login to Review

                </a>

            </div>

        @endauth


        <!-- =====================================================
             SUCCESS / ERROR MESSAGE
        ====================================================== -->

        @if(session('success'))

            <div class="review-message review-message-success">

                <i class="fa-solid fa-circle-check"></i>

                <span>
                    {{ session('success') }}
                </span>

            </div>

        @endif


        @if(session('error'))

            <div class="review-message review-message-error">

                <i class="fa-solid fa-circle-exclamation"></i>

                <span>
                    {{ session('error') }}
                </span>

            </div>

        @endif


        <!-- =====================================================
             REVIEWS LIST
        ====================================================== -->

        @if($reviewCollection->count())

            <div class="product-reviews-list">

                @foreach($reviewCollection->sortByDesc('created_at') as $review)

                    <article class="customer-review-card">

                        <div class="customer-review-top">

                            <div class="customer-review-user">

                                <div class="customer-review-avatar">

                                    @if(
                                        $review->customer &&
                                        $review->customer->profile_image
                                    )

                                        <img
                                            src="{{ asset('assets/images/customer/' . $review->customer->profile_image) }}"
                                            alt="{{ $review->customer->name }}">

                                    @else

                                        <span>

                                            {{
                                                strtoupper(
                                                    substr(
                                                        $review->customer->name ?? 'C',
                                                        0,
                                                        1
                                                    )
                                                )
                                            }}

                                        </span>

                                    @endif

                                </div>


                                <div>

                                    <strong>

                                        {{
                                            $review->customer->name
                                            ?? 'Customer'
                                        }}

                                    </strong>

                                    <small>

                                        {{ $review->created_at->format('d M Y') }}

                                    </small>

                                </div>

                            </div>


                            <div class="customer-review-rating">

                                @for($i = 1; $i <= 5; $i++)

                                    @if($i <= $review->rating)

                                        <i class="fa-solid fa-star"></i>

                                    @else

                                        <i class="fa-regular fa-star"></i>

                                    @endif

                                @endfor

                            </div>

                        </div>


                        @if($review->comment)

                            <p class="customer-review-comment">

                                {{ $review->comment }}

                            </p>

                        @endif

                    </article>

                @endforeach

            </div>

        @else

            <div class="no-product-reviews">

                <i class="fa-regular fa-comment-dots"></i>

                <h3>
                    No Reviews Yet
                </h3>

                <p>
                    Be the first customer to review this product.
                </p>

            </div>

        @endif

    </div>

</section>


        {{-- =========================================================
             RELATED PRODUCTS
        ========================================================== --}}

        <div class="related-products-section">

            <div class="related-products-header">

                <h2>
                    Related Products
                </h2>

                @if($product->category)

                    <a
                        href="{{ route('products', ['category' => $product->category->slug]) }}"
                        class="related-products-view-all"
                    >
                        View All
                    </a>

                @endif

            </div>


            @if(isset($relatedProducts) && $relatedProducts->count())


                <div class="related-products-grid">

                    @foreach($relatedProducts as $relatedProduct)


                        @php

                            $relatedOriginalPrice =
                                (float) $relatedProduct->price;

                            $relatedSalePrice =
                                $relatedProduct->sale_price !== null
                                    ? (float) $relatedProduct->sale_price
                                    : $relatedOriginalPrice;

                            $relatedDiscount = 0;

                            if (
                                $relatedOriginalPrice > 0 &&
                                $relatedSalePrice < $relatedOriginalPrice
                            ) {

                                $relatedDiscount = round(
                                    (
                                        ($relatedOriginalPrice - $relatedSalePrice)
                                        / $relatedOriginalPrice
                                    ) * 100
                                );

                            }

                        @endphp


                        <div class="related-product-card">


                            {{-- IMAGE --}}

                            <div class="related-product-image">


                                @if($relatedDiscount > 0)

                                    <span class="related-product-discount">
                                        -{{ $relatedDiscount }}%
                                    </span>

                                @endif


                                <a
                                    href="{{ route('product.show', $relatedProduct->slug) }}"
                                >

                                    @if($relatedProduct->thumbnail)

                                        <img
                                            src="{{ asset('assets/images/products/' . $relatedProduct->thumbnail) }}"
                                            alt="{{ $relatedProduct->name }}"
                                            loading="lazy"
                                        >

                                    @else

                                        <img
                                            src="{{ asset('assets/images/logo/banner.png') }}"
                                            alt="{{ $relatedProduct->name }}"
                                            loading="lazy"
                                        >

                                    @endif

                                </a>

                            </div>


                            {{-- CONTENT --}}

                            <div class="related-product-content">


                                @if($relatedProduct->category)

                                    <div class="related-product-category">
                                        {{ $relatedProduct->category->name }}
                                    </div>

                                @endif


                                <h3 class="related-product-name">

                                    <a
                                        href="{{ route('product.show', $relatedProduct->slug) }}"
                                    >
                                        {{ $relatedProduct->name }}
                                    </a>

                                </h3>


                                <div class="related-product-price">

                                    <span class="related-product-sale-price">
                                        ₹{{ number_format($relatedSalePrice, 2) }}
                                    </span>


                                    @if($relatedDiscount > 0)

                                        <span class="related-product-old-price">
                                            ₹{{ number_format($relatedOriginalPrice, 2) }}
                                        </span>

                                    @endif

                                </div>

                            </div>

                        </div>


                    @endforeach

                </div>


            @else


                {{-- CONTROLLER FIX HONE KE BAAD YE MESSAGE HAT JAYEGA --}}

                <div class="no-related-products">

                    <i class="fa-regular fa-box-open"></i>

                    <div>
                        No related products available.
                    </div>

                </div>


            @endif

        </div>


    </div>

</section>


{{-- =============================================================
     TOAST
============================================================= --}}

<div
    id="productDetailToast"
    class="product-detail-toast"
>

    <i class="fa-solid fa-circle-check"></i>

    <span id="productDetailToastMessage"></span>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | IMAGE GALLERY
    |--------------------------------------------------------------------------
    */

    const mainImage =
        document.getElementById('productMainImage');

    const thumbnails =
        document.querySelectorAll('.product-thumbnail');


    thumbnails.forEach(function (thumbnail) {

        thumbnail.addEventListener('click', function () {

            const image =
                this.getAttribute('data-image');


            if (mainImage && image) {

                mainImage.src = image;
            }


            thumbnails.forEach(function (item) {

                item.classList.remove('active');

            });


            this.classList.add('active');

        });

    });


    /*
    |--------------------------------------------------------------------------
    | QUANTITY
    |--------------------------------------------------------------------------
    */

    const quantityInput =
        document.getElementById('productQuantity');

    const minusButton =
        document.getElementById('quantityMinus');

    const plusButton =
        document.getElementById('quantityPlus');

    const cartQuantity =
        document.getElementById('cartQuantity');

    const buyNowQuantity =
        document.getElementById('buyNowQuantity');


    function updateQuantity(value) {

        if (!quantityInput) {
            return;
        }


        let quantity =
            parseInt(value);


        const minimum =
            parseInt(
                quantityInput.getAttribute('min')
            ) || 1;


        const maximum =
            parseInt(
                quantityInput.getAttribute('max')
            ) || 1;


        if (isNaN(quantity)) {

            quantity = minimum;
        }


        if (quantity < minimum) {

            quantity = minimum;
        }


        if (quantity > maximum) {

            quantity = maximum;
        }


        quantityInput.value =
            quantity;


        /*
        | Sync Add To Cart quantity
        */

        if (cartQuantity) {

            cartQuantity.value =
                quantity;
        }


        /*
        | Sync Buy Now quantity
        */

        if (buyNowQuantity) {

            buyNowQuantity.value =
                quantity;
        }

    }


    if (minusButton) {

        minusButton.addEventListener(
            'click',
            function () {

                const current =
                    parseInt(
                        quantityInput.value
                    ) || 1;


                updateQuantity(
                    current - 1
                );

            }
        );

    }


    if (plusButton) {

        plusButton.addEventListener(
            'click',
            function () {

                const current =
                    parseInt(
                        quantityInput.value
                    ) || 1;


                updateQuantity(
                    current + 1
                );

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | TOAST
    |--------------------------------------------------------------------------
    */

    let toastTimer = null;


    function showProductToast(
        message,
        type = 'success'
    ) {

        const toast =
            document.getElementById(
                'productDetailToast'
            );


        const toastMessage =
            document.getElementById(
                'productDetailToastMessage'
            );


        const toastIcon =
            document.getElementById(
                'productDetailToastIcon'
            );


        if (!toast || !toastMessage) {

            return;
        }


        if (toastTimer) {

            clearTimeout(
                toastTimer
            );
        }


        toastMessage.textContent =
            message;


        toast.classList.remove(
            'error'
        );


        if (toastIcon) {

            toastIcon.className =
                'fa-solid fa-circle-check';
        }


        if (type === 'error') {

            toast.classList.add(
                'error'
            );


            if (toastIcon) {

                toastIcon.className =
                    'fa-solid fa-circle-exclamation';
            }

        }


        toast.classList.add(
            'show'
        );


        toastTimer =
            setTimeout(
                function () {

                    toast.classList.remove(
                        'show'
                    );

                },
                3000
            );

    }


    /*
    |--------------------------------------------------------------------------
    | ADD TO CART AJAX
    |--------------------------------------------------------------------------
    */

    const addToCartForm =
        document.getElementById(
            'addToCartForm'
        );


    const addToCartButton =
        document.getElementById(
            'addToCartButton'
        );


    if (addToCartForm) {

        addToCartForm.addEventListener(
            'submit',
            async function (event) {

                event.preventDefault();


                if (
                    addToCartButton &&
                    addToCartButton.disabled
                ) {

                    return;
                }


                /*
                | Make absolutely sure latest
                | quantity reaches backend
                */

                if (
                    quantityInput &&
                    cartQuantity
                ) {

                    cartQuantity.value =
                        quantityInput.value;
                }


                if (addToCartButton) {

                    addToCartButton.disabled =
                        true;

                    addToCartButton.dataset.originalText =
                        addToCartButton.innerHTML;

                    addToCartButton.innerHTML =
                        '<i class="fa-solid fa-spinner fa-spin"></i> Adding...';
                }


                try {

                    const response =
                        await fetch(
                            addToCartForm.action,
                            {
                                method: 'POST',

                                credentials:
                                    'same-origin',

                                headers: {

                                    'X-CSRF-TOKEN':
                                        document
                                            .querySelector(
                                                'meta[name="csrf-token"]'
                                            )
                                            ?.getAttribute(
                                                'content'
                                            ),

                                    'Accept':
                                        'application/json',

                                    'X-Requested-With':
                                        'XMLHttpRequest'

                                },

                                body:
                                    new FormData(
                                        addToCartForm
                                    )
                            }
                        );


                    const data =
                        await response.json();


                    if (!response.ok) {

                        let message =
                            data.message ||
                            'Unable to add product to cart.';


                        if (
                            data.errors &&
                            data.errors.quantity
                        ) {

                            message =
                                data.errors.quantity[0];
                        }


                        throw new Error(
                            message
                        );
                    }


                    if (data.success) {

                        showProductToast(
                            data.message ||
                            'Product successfully added to cart!',
                            'success'
                        );


                        /*
                        | Header cart count
                        */

                        const cartCounts =
                            document.querySelectorAll(
                                '.cart-count'
                            );


                        cartCounts.forEach(
                            function (cartCount) {

                                if (
                                    data.cart_count !==
                                    undefined
                                ) {

                                    cartCount.textContent =
                                        data.cart_count;
                                }

                            }
                        );

                    } else {

                        showProductToast(
                            data.message ||
                            'Unable to add product to cart.',
                            'error'
                        );

                    }

                } catch (error) {

                    console.error(
                        'Add To Cart Error:',
                        error
                    );


                    showProductToast(
                        error.message ||
                        'Unable to add product to cart.',
                        'error'
                    );

                } finally {

                    if (addToCartButton) {

                        addToCartButton.disabled =
                            false;


                        if (
                            addToCartButton.dataset.originalText
                        ) {

                            addToCartButton.innerHTML =
                                addToCartButton.dataset.originalText;
                        }

                    }

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | WISHLIST AJAX
    |--------------------------------------------------------------------------
    */

    const wishlistForms =
        document.querySelectorAll(
            '.product-detail-wishlist-form'
        );


    wishlistForms.forEach(function (form) {

        form.addEventListener(
            'submit',
            async function (event) {

                event.preventDefault();


                const button =
                    form.querySelector(
                        '.product-detail-wishlist-btn'
                    );


                if (!button) {

                    return;
                }


                try {

                    const methodInput =
                        form.querySelector(
                            'input[name="_method"]'
                        );


                    const isRemove =
                        methodInput &&
                        methodInput.value ===
                        'DELETE';


                    const response =
                        await fetch(
                            form.action,
                            {
                                method: 'POST',

                                credentials:
                                    'same-origin',

                                headers: {

                                    'X-CSRF-TOKEN':
                                        document
                                            .querySelector(
                                                'meta[name="csrf-token"]'
                                            )
                                            ?.getAttribute(
                                                'content'
                                            ),

                                    'Accept':
                                        'application/json',

                                    'X-Requested-With':
                                        'XMLHttpRequest'

                                },

                                body:
                                    new FormData(form)
                            }
                        );


                    if (!response.ok) {

                        throw new Error(
                            'Wishlist request failed.'
                        );
                    }


                    if (isRemove) {

                        form.action =
                            "{{ url('/wishlist/add') }}/{{ $product->id }}";


                        if (methodInput) {

                            methodInput.remove();
                        }


                        button.classList.remove(
                            'active'
                        );


                        button.innerHTML =
                            '<i class="fa-regular fa-heart"></i>';


                        button.title =
                            'Add to Wishlist';


                        showProductToast(
                            'Product removed from wishlist.',
                            'success'
                        );

                    } else {

                        form.action =
                            "{{ url('/wishlist/remove') }}/{{ $product->id }}";


                        const newMethodInput =
                            document.createElement(
                                'input'
                            );


                        newMethodInput.type =
                            'hidden';

                        newMethodInput.name =
                            '_method';

                        newMethodInput.value =
                            'DELETE';


                        form.appendChild(
                            newMethodInput
                        );


                        button.classList.add(
                            'active'
                        );


                        button.innerHTML =
                            '<i class="fa-solid fa-heart"></i>';


                        button.title =
                            'Remove from Wishlist';


                        showProductToast(
                            'Product added to wishlist.',
                            'success'
                        );

                    }

                } catch (error) {

                    console.error(
                        'Wishlist Error:',
                        error
                    );


                    showProductToast(
                        'Something went wrong. Please try again.',
                        'error'
                    );

                }

            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | REVIEW STAR SELECTOR
    |--------------------------------------------------------------------------
    */

    const starButtons =
        document.querySelectorAll(
            '.review-star-btn'
        );


    const ratingInput =
        document.getElementById(
            'reviewRating'
        );


    function setRating(
        selectedRating
    ) {

        if (!ratingInput) {

            return;
        }


        ratingInput.value =
            selectedRating;


        starButtons.forEach(
            function (star) {

                const starRating =
                    parseInt(
                        star.dataset.rating
                    );


                const icon =
                    star.querySelector(
                        'i'
                    );


                if (
                    starRating <=
                    selectedRating
                ) {

                    star.classList.add(
                        'selected'
                    );


                    if (icon) {

                        icon.className =
                            'fa-solid fa-star';
                    }

                } else {

                    star.classList.remove(
                        'selected'
                    );


                    if (icon) {

                        icon.className =
                            'fa-regular fa-star';
                    }

                }

            }
        );

    }


    starButtons.forEach(
        function (button) {

            button.addEventListener(
                'click',
                function () {

                    const selectedRating =
                        parseInt(
                            this.dataset.rating
                        );


                    setRating(
                        selectedRating
                    );

                }
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | REVIEW CHARACTER COUNT
    |--------------------------------------------------------------------------
    */

    const reviewComment =
        document.getElementById(
            'reviewComment'
        );


    const reviewCharacterCount =
        document.getElementById(
            'reviewCharacterCount'
        );


    function updateReviewCharacterCount() {

        if (
            reviewComment &&
            reviewCharacterCount
        ) {

            reviewCharacterCount.textContent =
                reviewComment.value.length;
        }

    }


    if (reviewComment) {

        updateReviewCharacterCount();


        reviewComment.addEventListener(
            'input',
            updateReviewCharacterCount
        );

    }


    /*
    |--------------------------------------------------------------------------
    | REVIEW AJAX SUBMIT
    |--------------------------------------------------------------------------
    */

    const reviewForm =
        document.getElementById(
            'productReviewForm'
        );


    if (reviewForm) {

        reviewForm.addEventListener(
            'submit',
            async function (event) {

                event.preventDefault();


                /*
                | Rating required
                */

                if (
                    !ratingInput ||
                    !ratingInput.value
                ) {

                    showProductToast(
                        'Please select your rating.',
                        'error'
                    );

                    return;
                }


                /*
                | Comment required
                */

                if (
                    !reviewComment ||
                    !reviewComment.value.trim()
                ) {

                    showProductToast(
                        'Please write your review.',
                        'error'
                    );

                    return;
                }


                const submitButton =
                    reviewForm.querySelector(
                        '.submit-review-btn'
                    );


                if (submitButton) {

                    submitButton.disabled =
                        true;

                    submitButton.dataset.originalText =
                        submitButton.innerHTML;

                    submitButton.innerHTML =
                        '<i class="fa-solid fa-spinner fa-spin"></i> Submitting...';
                }


                try {

                    const response =
                        await fetch(
                            reviewForm.action,
                            {
                                method: 'POST',

                                credentials:
                                    'same-origin',

                                headers: {

                                    'X-CSRF-TOKEN':
                                        document
                                            .querySelector(
                                                'meta[name="csrf-token"]'
                                            )
                                            ?.getAttribute(
                                                'content'
                                            ),

                                    'Accept':
                                        'application/json',

                                    'X-Requested-With':
                                        'XMLHttpRequest'

                                },

                                body:
                                    new FormData(
                                        reviewForm
                                    )
                            }
                        );


                    const data =
                        await response.json();


                    if (!response.ok) {

                        let message =
                            data.message ||
                            'Unable to submit review.';


                        if (data.errors) {

                            const firstError =
                                Object.values(
                                    data.errors
                                )[0];


                            if (
                                Array.isArray(
                                    firstError
                                ) &&
                                firstError.length
                            ) {

                                message =
                                    firstError[0];
                            }

                        }


                        throw new Error(
                            message
                        );
                    }


                    if (!data.success) {

                        throw new Error(
                            data.message ||
                            'Unable to submit review.'
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | SUCCESS TOAST
                    |--------------------------------------------------------------------------
                    */

                    showProductToast(
                        data.message,
                        'success'
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | UPDATE REVIEW UI WITHOUT REFRESH
                    |--------------------------------------------------------------------------
                    */

                    const review =
                        data.review;


                    if (review) {

                        /*
                        | Remove "No Reviews Yet" box
                        */

                        const noReviews =
                            document.querySelector(
                                '.no-product-reviews'
                            );


                        if (noReviews) {

                            noReviews.remove();
                        }


                        /*
                        | Find existing review card
                        */

                        let existingCard =
                            document.querySelector(
                                '[data-review-id="' +
                                review.id +
                                '"]'
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | Review HTML
                        |--------------------------------------------------------------------------
                        */

                        const starsHtml =
                            Array.from(
                                {
                                    length: 5
                                }
                            )
                            .map(
                                function (_, index) {

                                    const starNumber =
                                        index + 1;


                                    return starNumber <=
                                        review.rating

                                        ? '<i class="fa-solid fa-star"></i>'

                                        : '<i class="fa-regular fa-star"></i>';

                                }
                            )
                            .join('');


                        const reviewHtml =

                            '<article class="customer-review-card" data-review-id="' +
                            review.id +
                            '">' +

                                '<div class="customer-review-top">' +

                                    '<div class="customer-review-user">' +

                                        '<div class="customer-review-avatar">' +

                                            '<span>' +
                                                escapeHtml(
                                                    (
                                                        review.customer_name ||
                                                        'C'
                                                    )
                                                    .charAt(0)
                                                    .toUpperCase()
                                                ) +
                                            '</span>' +

                                        '</div>' +

                                        '<div>' +

                                            '<strong>' +
                                                escapeHtml(
                                                    review.customer_name ||
                                                    'Customer'
                                                ) +
                                            '</strong>' +

                                            '<small>' +
                                                escapeHtml(
                                                    review.created_at ||
                                                    ''
                                                ) +
                                            '</small>' +

                                        '</div>' +

                                    '</div>' +

                                    '<div class="customer-review-rating">' +
                                        starsHtml +
                                    '</div>' +

                                '</div>' +

                                '<p class="customer-review-comment">' +
                                    escapeHtml(
                                        review.comment || ''
                                    ) +
                                '</p>' +

                            '</article>';


                        if (existingCard) {

                            existingCard.outerHTML =
                                reviewHtml;

                        } else {

                            const reviewList =
                                document.querySelector(
                                    '.product-reviews-list'
                                );


                            if (reviewList) {

                                reviewList.insertAdjacentHTML(
                                    'afterbegin',
                                    reviewHtml
                                );

                            } else {

                                const noReviewsBox =
                                    document.querySelector(
                                        '.no-product-reviews'
                                    );


                                if (noReviewsBox) {

                                    noReviewsBox.outerHTML =
                                        '<div class="product-reviews-list">' +
                                            reviewHtml +
                                        '</div>';

                                }

                            }

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Hide review form after submit
                        |--------------------------------------------------------------------------
                        */

                        const writeReviewBox =
                            document.querySelector(
                                '.write-review-box'
                            );


                        if (writeReviewBox) {

                            writeReviewBox.innerHTML =

                                '<div class="review-already-submitted">' +

                                    '<i class="fa-solid fa-circle-check"></i>' +

                                    '<div>' +

                                        '<strong>' +
                                            'Your review has been submitted.' +
                                        '</strong>' +

                                        '<span>' +
                                            'Thank you for sharing your experience.' +
                                        '</span>' +

                                    '</div>' +

                                '</div>';

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Update average rating
                        |--------------------------------------------------------------------------
                        */

                        updateRatingDisplay();

                    }

                } catch (error) {

                    console.error(
                        'Review Error:',
                        error
                    );


                    showProductToast(
                        error.message ||
                        'Unable to submit review.',
                        'error'
                    );

                } finally {

                    if (submitButton) {

                        submitButton.disabled =
                            false;


                        if (
                            submitButton.dataset.originalText
                        ) {

                            submitButton.innerHTML =
                                submitButton.dataset.originalText;
                        }

                    }

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE RATING DISPLAY
    |--------------------------------------------------------------------------
    */

    function updateRatingDisplay() {

        const reviewCards =
            document.querySelectorAll(
                '.customer-review-card'
            );


        if (!reviewCards.length) {

            return;
        }


        /*
        | Count ratings from visible cards
        */

        let totalRating = 0;
        let count = 0;


        reviewCards.forEach(
            function (card) {

                const stars =
                    card.querySelectorAll(
                        '.customer-review-rating .fa-solid.fa-star'
                    );


                if (stars.length) {

                    totalRating +=
                        stars.length;

                    count++;
                }

            }
        );


        if (!count) {

            return;
        }


        const average =
            (
                totalRating / count
            ).toFixed(1);


        const averageNumber =
            document.querySelector(
                '.product-average-rating strong'
            );


        const averageStars =
            document.querySelector(
                '.product-average-stars'
            );


        const averageCount =
            document.querySelector(
                '.product-average-rating small'
            );


        if (averageNumber) {

            averageNumber.textContent =
                average;
        }


        if (averageCount) {

            averageCount.textContent =
                count +
                (
                    count === 1
                        ? ' Review'
                        : ' Reviews'
                );
        }


        if (averageStars) {

            let starsHtml = '';


            for (
                let i = 1;
                i <= 5;
                i++
            ) {

                starsHtml +=
                    i <= Math.round(
                        parseFloat(average)
                    )

                    ? '<i class="fa-solid fa-star"></i>'

                    : '<i class="fa-regular fa-star"></i>';
            }


            averageStars.innerHTML =
                starsHtml;
        }

    }


    /*
    |--------------------------------------------------------------------------
    | HTML ESCAPE
    |--------------------------------------------------------------------------
    */

    function escapeHtml(value) {

        const div =
            document.createElement(
                'div'
            );


        div.textContent =
            value ?? '';


        return div.innerHTML;
    }

});
</script>
@endsection