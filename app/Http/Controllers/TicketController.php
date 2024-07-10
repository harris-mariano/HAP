<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Ticket; 
use App\Models\Attachment; 
use App\Models\History; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{   
    
    public function index () {
        $userId = Auth::guard('user')->id();
        $userTickets = Ticket::where('user_id', $userId)
                ->with(['histories.status'])
                ->simplePaginate(10);

        $customerId = Auth::guard('customer')->id();
        $customerTickets = Ticket::where('customer_id', $customerId)
                ->with(['histories.status'])
                ->simplePaginate(10);

        return view('alltickets', [
            'userTickets' => $userTickets,
            'customerTickets' => $customerTickets]);
    }

    public function create () {
        $user = Auth::guard('user')->user();
        $customer = Auth::guard('customer')->user();

        return view('fileticket', [
            'user' => $user,
            'customer' => $customer ]);
    }

    public function store (Request $request) {
        $validated = $request->validate([
            "department_id" => ['required'],
            "employee_id" => ['required'],
            "title" => ['required'],
            "description" => ['required'],
            "attachment" => [ 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,pdf,docx|max:50000'],
        ]);

        $userId = Auth::guard('user')->id();
        $customerId = Auth::guard('customer')->id();

        $validated['priority_id'] = 1; //required

        if ($userId !== null) {
            $validated['user_id'] = $userId;
        } 
        elseif ($customerId !== null) {
            $validated['customer_id'] = $customerId;
        }

        $ticket = new Ticket();
        $ticket->fill($validated);
        $ticket->save();

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $originalFileName = $file->getClientOriginalName(); 
                $path = $file->store('attachments', 'public'); 
        
                $attachment = new Attachment();
                $attachment->ticket_id = $ticket->id;
                $attachment->file_name = $originalFileName; 
                $attachment->file_path = Storage::url($path); 
                $attachment->save();
            }
        }

        $history = new History();
        $history->ticket_id = $ticket->id;
        $history->status_id = 1; //new 
        $history->save(); 

        $user = Auth::guard('user')->user();
        $customer = Auth::guard('customer')->user();

        return back()->with(['user' => $user, 'customer' => $customer]);
    }

    public function show ($id) {
        $ticket = Ticket::with(['attachments', 'histories'])->findOrFail($id); 
        $employees = User::where('department', $ticket->department_id)->get();
        
        return view('editticket', [
            'ticket' => $ticket,
            'employees' => $employees, 
            ]);
    }

    // update the ticket (my tickets)
    public function update (Request $request, Ticket $ticket) {

        $validated = $request->validate([
            "department_id" => ['required'],
            "employee_id" => ['required'],
            "title" => ['required'],
            "description" => ['required'],
            "attachment" => [ 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,pdf,docx|max:50000'],
        ]);

        $validated['priority_id'] = 1; //required

        $userId = Auth::guard('user')->id();
        $customerId = Auth::guard('customer')->id();
        
        if ($userId !== null) {
            $validated['user_id'] = $userId;
        } 
        elseif ($customerId !== null) {
            $validated['customer_id'] = $customerId;
        }
        
        $ticket->update($validated);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $originalFileName = $file->getClientOriginalName(); 
                $path = $file->store('attachments', 'public'); 
        
                $attachment = new Attachment();
                $attachment->ticket_id = $ticket->id;
                $attachment->file_name = $originalFileName; 
                $attachment->file_path = Storage::url($path); 
                $attachment->save();
            }
        }

        return back();
    }

    public function attachment($id)
    {
        $attachment = Attachment::findOrFail($id); 
        return view('partials.show', ['attachment' => $attachment]);
    }
}
