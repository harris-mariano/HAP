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
                ->orderBy('created_at', 'desc')
                ->simplePaginate(10);

        $customerId = Auth::guard('customer')->id();
        $customerTickets = Ticket::where('customer_id', $customerId)
                ->orderBy('created_at', 'desc')
                ->simplePaginate(10);

        return view('tickets.all-tickets', [
            'userTickets' => $userTickets,
            'customerTickets' => $customerTickets]);
    }

    public function create () {
        $user = Auth::guard('user')->user();
        $customer = Auth::guard('customer')->user();

        return view('tickets.file-ticket', [
            'user' => $user,
            'customer' => $customer ]);
    }

    public function store (Request $request) {
        $validated = $request->validate([
            "department_id" => ['required'],
            "employee_id" => ['required'],
            "title" => ['required'],
            "description" => ['required'],
            'attachments' => 'nullable|array|max:5',
            'attachments.*' => 'file|mimes:jpeg,png,gif,mp4,mov|max:50000',
        ]);

        $userId = Auth::guard('user')->id();
        $customerId = Auth::guard('customer')->id();

        $validated['priority_id'] = 1; //required
        $validated['status_id'] = 1; //new

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
        $history->priority_id = 1; //required 
        $history->user_id = $validated['employee_id'];
        $history->save(); 

        $user = Auth::guard('user')->user();
        $customer = Auth::guard('customer')->user();

        return back()->with(['user' => $user, 'customer' => $customer]);
    }

    public function show ($id) {
        $ticket = Ticket::with(['attachments', 'histories'])->findOrFail($id); 
        $employees = User::where('department_id', $ticket->department_id)->get();
        $histories = $ticket->histories()->orderBy('created_at', 'desc')->get();

        return view('tickets.edit-ticket', [
            'ticket' => $ticket,
            'employees' => $employees,
            'histories' =>$histories, 
            ]);
    }

    public function attachment($id)
    {
        $attachment = Attachment::findOrFail($id); 
        return view('partials.show', ['attachment' => $attachment]);
    }

    public function assigned () {
        $userId = Auth::guard('user')->id();
        $user = User::find($userId);
        $userDepartment = $user->department->id; 

        $departmentTickets = Ticket::where('department_id', $userDepartment)
        ->orderBy('created_at', 'desc')
        ->simplePaginate(10);
        
        return view ('tickets.assigned-tickets', [
            'user' => $user,
            'departmentTickets' => $departmentTickets, 
        ]); 
    }


    // update the ticket (assigned tickets)
    public function update (Request $request, Ticket $ticket) {

        $validated = $request->validate([
            "department_id" => ['required'],
            "employee_id" => ['required'],
            "priority_id" => ['required'], 
            "status_id" => ['required'], 
        ]);

        $ticket->update($validated);

        return back();
    }
}
