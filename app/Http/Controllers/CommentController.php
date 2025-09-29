<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Ticket;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserMail;

class CommentController extends Controller
{

    public function store(Request $request, $id) {
        $ticket = Ticket::findOrFail($id);

        $validated = $request->validate([
            'comment' => 'required|string|min:10',
            'photo' => 'nullable|file|mimes:jpeg,jpg,png,bmp,mp4,mov|max:50000'
        ]);

        $userId = Auth::guard('user')->id();
        $validated['user_id'] = $userId;
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

        if ($userId !== null) {
        $userFullName = $comment->user->first_name . ' ' . $comment->user->last_name;

        //asignee commented
        if ($comment->user_id == $ticket->employee_id) {
            //the one who files will receive a notif
            Mail::send(new UserMail($ticket->user->first_name, 'ticket_comment', $ticket->title, null, null, null, $userFullName, $validated['comment'], $ticket->id));
        }
        //filer commented
        elseif ($comment->user_id == $ticket->user_id) {
            //the asignee will receive the notif
            Mail::send(new UserMail($ticket->employee->first_name, 'ticket_comment',  $ticket->title, null, null, null, $userFullName, $validated['comment'], $ticket->id));
        }
        //not asignee or filer commented
        else {
            //the one who files will receive a notif
            Mail::send(new UserMail($ticket->user->first_name, 'ticket_comment', $ticket->title, null, null, null, $userFullName, $validated['comment'], $ticket->id));
            //the asignee will receive the notif
            Mail::send(new UserMail($ticket->employee->first_name, 'ticket_comment',  $ticket->title, null, null, null, $userFullName, $validated['comment'], $ticket->id));
        }
    }
        return back()->with('message', 'Your comment has been submitted successfully.');
    }

}
