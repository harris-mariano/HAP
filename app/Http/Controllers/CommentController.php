<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Ticket;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index() {

    }

    public function store(Request $request, $id) {
        $ticket = Ticket::findOrFail($id); 

        $validated = $request->validate([
            'comment' => 'required|string',
            'photo' => 'nullable|file|mimes:jpeg,png,gif,mp4,mov|max:50000'
        ]);

        $userId = Auth::guard('user')->id();
        $customerId = Auth::guard('customer')->id();

        if ($userId !== null) {
            $validated['user_id'] = $userId;
        } 
        elseif ($customerId !== null) {
            $validated['customer_id'] = $customerId;
        }

        $validated['ticket_id'] = $ticket->id; 
        $comment = new Comment(); 
        $comment->fill($validated);
        $comment->save(); 

        if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $originalFileName = $file->getClientOriginalName(); 
                $path = $file->store('attachments', 'public'); 
        
                $attachment = new Attachment();
                $attachment->comment_id = $comment->id;
                $attachment->file_name = $originalFileName; 
                $attachment->file_path = Storage::url($path); 
                $attachment->save();
        }

        return back()->with(['tickets' => $ticket]);
    }

}
