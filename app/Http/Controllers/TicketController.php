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
use App\Models\Department;

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
        $employees = User::where('department_id', old('department_id'))
                    ->where('type_id', '!=', 2) //not inactive
                    ->get();
        $names = User::all()
                ->where('type_id', '!=', 2); //not inactive;
        $priorities = Priority::all();
        $departments = Department::where('company_id', 1) //adish depts
                    ->get(); 

        return view('tickets.file-ticket', [
            'user' => $user, 
            'employees' => $employees, 
            'names' => $names, 
            'priorities' => $priorities, 
            'departments' => $departments]);
    }

    public function store (Request $request) {
        $messages = [
            'attachments.max' => 'You can only upload a maximum of 5 attachments.',
            "attachments.*.mimes" => 'Only JPEG, PNG, MP4, and MOV files are allowed.',
            "attachments.*.max" => 'Each attachment can be a maximum of 50MB.',
        ];

        $validated = $request->validate([
            "department_id" => 'required',
            "employee_id" => 'required',
            "title" => 'required|string|min:10',
            "priority_id" => 'required|integer|exists:priorities,id',
            "description" => 'required',
            "description_text" => 'required|string|min:10',
            'attachments' => 'nullable|array|max:5',
            'attachments.*' => 'file|mimes:jpeg,jpg,png,bmp,mp4,mov,doc,docx,pdf|max:50000',
        ], $messages);

        unset($validated['description_text']);

        $user = Auth::guard('user')->user();
        $nameId = $request->name;
        $nameObject = User::find($nameId);

        // //customer or support creation of ticket
        if ($nameObject == null) {
            $validated['status_id'] = 1; //new
            $validated['user_id'] = $user->id;
        }
        //admin creation
        else {
            $validated['status_id'] = 1; //new
            $validated['user_id'] = $nameId;
            $validated['is_admin_creation'] = true;
            $validated['admin_id'] = $user->id;
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
        $history->user_id = $validated['employee_id'];
        $history->save(); 

        if ($user->role_id != 1){
            Mail::to($this->mailtrapEmail)->send(new UserMail($user->first_name, 'ticket_creation', $validated['title']));
        }
        else {
            Mail::to($this->mailtrapEmail)->send(new UserMail($nameObject->first_name, 'ticket_creation', $validated['title']));
        }

        Mail::to($this->mailtrapEmail)->send(new UserMail($ticket->employee->first_name, 'ticket_assignment', $validated['title']));
       
        return redirect()->route('tickets.index')->with('message', 'Your ticket has been submitted successfully.');
    }

    public function show ($id) {
        $ticket = Ticket::with(['attachments', 'histories'])->findOrFail($id); 
        $employees = User::where('department_id', $ticket->department_id)
                    ->where('type_id', '!=', 2) //not inactive
                    ->get();
        $histories = $ticket->histories()->orderBy('created_at', 'desc')->get();
        $priorities = Priority::all();
        $statuses = Status::all();
        $departments = Department::where('company_id', 1) //adish depts
        ->get(); 

        return view('tickets.edit-ticket', [
            'ticket' => $ticket,
            'employees' => $employees,
            'histories' =>$histories, 
            'priorities' => $priorities,
            'departments' => $departments,
            'statuses' => $statuses,
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
            "department_id" => 'required',
            "employee_id" => 'required',
            "priority_id" => 'required', 
            "status_id" => 'required', 
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
