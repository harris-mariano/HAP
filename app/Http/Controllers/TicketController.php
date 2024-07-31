<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Ticket; 
use App\Models\Attachment; 
use App\Models\History; 
use App\Models\Status; 
use App\Models\Priority;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserMail;

class TicketController extends Controller
{   
    protected $mailtrapEmail; 

    public function __construct()
    {
        $this->mailtrapEmail = env('EMAIL');
        $this->middleware('checkRole:1,2,3')->only(['index', 'create', 'store', 'show']);
        $this->middleware('checkRole:1,2')->only(['update']);
    }
    
    public function index () {
        $userId = Auth::guard('user')->id();
        $userTickets = Ticket::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->simplePaginate(10);

        return view('tickets.all-tickets', [
            'userTickets' => $userTickets]);
    }

    public function create () {
        $user = Auth::guard('user')->user();

        return view('tickets.file-ticket', ['user' => $user]);
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

        $validated['priority_id'] = 1; //required
        $validated['status_id'] = 1; //new
        $validated['user_id'] = $userId;
        

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
        Mail::to($this->mailtrapEmail)->send(new UserMail($user->first_name, 'ticket_creation', $validated['title']));
        Mail::to($this->mailtrapEmail)->send(new UserMail($ticket->employee->first_name, 'ticket_assignment', $validated['title']));
       
        return redirect()->route('tickets.index')->with('message', 'Your ticket has been submitted successfully.');
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

        $allTickets = Ticket::orderBy('created_at', 'desc')
        ->simplePaginate(10);
        
        return view ('tickets.assigned-tickets', [
            'user' => $user,
            'departmentTickets' => $departmentTickets,
            'allTickets' => $allTickets, 
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

        $statusChanged = $ticket->status_id != $validated['status_id'];
        $priorityChanged = $ticket->priority_id != $validated['priority_id'];
        $employeeChanged = $ticket->employee_id != $validated['employee_id'];

        $status = $statusChanged ? Status::find($validated['status_id'])->category : null;
        $priority = $priorityChanged ? Priority::find($validated['priority_id'])->category : null;
        $employeeFirstName = $employeeChanged ? User::find($validated['employee_id'])->first_name : null;
        $employeeFullName = $employeeChanged ? User::find($validated['employee_id'])->first_name . ' ' . User::find($validated['employee_id'])->last_name : null;

        if ($statusChanged || $priorityChanged || $employeeChanged) {
                Mail::to($this->mailtrapEmail)->send(new UserMail($ticket->user->first_name, 'ticket_update', $ticket->title, $status, $priority, $employeeFullName));
                if ($employeeChanged) {
                    Mail::to($this->mailtrapEmail)->send(new UserMail($employeeFirstName, 'ticket_assignment', $ticket->title));
                }
        }
        
        $ticket->update($validated);

        return back()->with('message', 'Your ticket has been updated successfully.');
    }
}
