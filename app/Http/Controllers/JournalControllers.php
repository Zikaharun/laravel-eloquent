<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;

class JournalControllers extends Controller
{
    //
    public function JournalStore(Request $request)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        // Create a new journal entry
        $journal = new Journal();
        $journal->title = $request->input('title');
        $journal->content = $request->input('content');
        $journal->save();

        // Redirect or return a response
        return 'journaling successfully created';
    }

}
