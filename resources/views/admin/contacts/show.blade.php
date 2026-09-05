@extends('layouts.admin')

@section('title', 'Contact Details | NexaMart Admin')

@section('page-title', 'Contact Details')

@section('page-subtitle', 'View customer contact message')

@section('content')

<style>

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

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 16px;
        border-radius: 7px;
        background: #f3f4f6;
        color: #374151;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
    }

    .back-btn:hover {
        background: #e5e7eb;
        color: #1f2937;
    }

    .contact-detail-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        max-width: 950px;
    }

    .detail-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e5e7eb;

        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .detail-header h3 {
        margin: 0;
        color: #1f2937;
        font-size: 18px;
    }

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

    .detail-body {
        padding: 24px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .detail-item {
        padding: 15px;
        background: #fafafa;
        border: 1px solid #f0f0f0;
        border-radius: 8px;
    }

    .detail-label {
        color: #6b7280;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 6px;
    }

    .detail-value {
        color: #1f2937;
        font-size: 14px;
        font-weight: 500;
        word-break: break-word;
    }

    .message-box {
        grid-column: 1 / -1;
    }

    .message-content {
        color: #374151;
        font-size: 14px;
        line-height: 1.7;
        white-space: pre-line;
    }

    .detail-actions {
        display: flex;
        gap: 10px;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
    }

    .action-btn {
        border: none;
        border-radius: 7px;
        padding: 10px 16px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
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

    @media(max-width: 768px) {

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .message-box {
            grid-column: auto;
        }

        .detail-header {
            align-items: flex-start;
            flex-direction: column;
        }

    }

</style>


<div class="page-header">

    <div class="page-title">

        <h2>
            Contact Details
        </h2>

        <p>
            View complete customer message
        </p>

    </div>


    <a
        href="{{ route('admin.contacts.index') }}"
        class="back-btn"
    >
        ← Back to Contacts
    </a>

</div>


<div class="contact-detail-card">


    <div class="detail-header">

        <h3>
            {{ $contact->subject ?? 'Contact Message' }}
        </h3>


        @if($contact->status)

            <span class="status-badge status-read">
                Read
            </span>

        @else

            <span class="status-badge status-unread">
                Unread
            </span>

        @endif

    </div>


    <div class="detail-body">


        <div class="detail-grid">


            <div class="detail-item">

                <div class="detail-label">
                    Name
                </div>

                <div class="detail-value">
                    {{ $contact->name }}
                </div>

            </div>


            <div class="detail-item">

                <div class="detail-label">
                    Email
                </div>

                <div class="detail-value">
                    {{ $contact->email }}
                </div>

            </div>


            <div class="detail-item">

                <div class="detail-label">
                    Phone
                </div>

                <div class="detail-value">
                    {{ $contact->phone ?? 'N/A' }}
                </div>

            </div>


            <div class="detail-item">

                <div class="detail-label">
                    Date
                </div>

                <div class="detail-value">
                    {{ $contact->created_at->format('d M Y, h:i A') }}
                </div>

            </div>


            <div class="detail-item message-box">

                <div class="detail-label">
                    Message
                </div>

                <div class="message-content">
                    {{ $contact->message }}
                </div>

            </div>


        </div>


        <div class="detail-actions">


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
                    {{ $contact->status ? 'Mark Unread' : 'Mark Read' }}
                </button>

            </form>


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


    </div>

</div>

@endsection