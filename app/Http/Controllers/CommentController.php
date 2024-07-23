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
    protected $mailtrapEmail; 

    public function __construct()
    {
        $this->mailtrapEmail = env('EMAIL');
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

        //
        if ($userId !== null) {
            $userFullName = $comment->user->first_name . ' ' . $comment->user->last_name; 
            if ($userId == $ticket->employee_id) {
                Mail::to($this->mailtrapEmail)->send(new UserMail($ticket->customer->first_name, 'ticket_comment', $ticket->title, null, null, null, $userFullName, $validated['comment']));
            }
            else {
                Mail::to($this->mailtrapEmail)->send(new UserMail($ticket->employee->first_name, 'ticket_comment',  $ticket->title, null, null, null, $userFullName, $validated['comment']));
                Mail::to($this->mailtrapEmail)->send(new UserMail($ticket->customer->first_name, 'ticket_comment',  $ticket->title, null, null, null, $userFullName, $validated['comment']));
            }
        } 
        else if ($customerId !== null) {
            $customerFullName = $comment->customer->first_name . ' ' . $comment->customer->last_name; 
            if ($customerId == $ticket->customer_id){
                Mail::to($this->mailtrapEmail)->send(new UserMail($ticket->employee->first_name, 'ticket_comment',  $ticket->title, null, null, null, $customerFullName, $validated['comment']));
            }
            else {
                Mail::to($this->mailtrapEmail)->send(new UserMail($ticket->employee->first_name, 'ticket_comment',  $ticket->title, null, null, null, $customerFullName, $validated['comment']));
                Mail::to($this->mailtrapEmail)->send(new UserMail($ticket->customer->first_name, 'ticket_comment',  $ticket->title, null, null, null, $customerFullName, $validated['comment']));
            }
        } 
        return back()->with('message', 'Your comment has been submitted successfully.');
    }

}
