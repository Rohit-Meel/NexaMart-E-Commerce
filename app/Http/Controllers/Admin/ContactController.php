<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * Display all contacts.
     */
    public function index()
    {
        $contacts = Contact::latest()->get();

        return view('admin.contacts.index', compact('contacts'));
    }


    /**
     * Display contact details.
     */
    public function show(Contact $contact)
    {
        return view('admin.contacts.show', compact('contact'));
    }


    /**
     * Toggle contact status.
     */
    public function toggleStatus(Contact $contact)
    {
        $contact->update([
            'status' => !$contact->status,
        ]);

        return redirect()
            ->route('admin.contacts.index')
            ->with('success', 'Contact status updated successfully.');
    }


    /**
     * Delete contact.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()
            ->route('admin.contacts.index')
            ->with('success', 'Contact deleted successfully.');
    }
}