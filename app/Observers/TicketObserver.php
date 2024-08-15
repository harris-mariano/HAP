<?php

namespace App\Observers;

use App\Models\Ticket;
use App\Models\History;
use App\Models\Priority;
use App\Models\Status;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TicketObserver
{
    /**
     * Handle the Ticket "created" event.
     */
    public function creating(Ticket $ticket)
    {
        //
    }

    /**
     * Handle the Ticket "updated" event.
     */
    public function updating(Ticket $ticket)
    {
        if ($ticket->isDirty('status_id')) {
            $oldPriorityId = $ticket->getOriginal('priority_id');
            $oldStatusId = $ticket->getOriginal('status_id');
            $newStatusId = $ticket->status_id;

            $oldStatus = Status::find($oldStatusId);
            $oldStatusName = $oldStatus ? $oldStatus->category : 'Unknown';
        
            $newStatus = Status::find($newStatusId);
            $newStatusName = $newStatus ? $newStatus->category : 'Unknown';
            
            $userId = Auth::guard('user')->id();
            $user = Auth::guard('user')->user();
            $userFirstName = $user->first_name;
            $userLastName = $user->last_name;

            $description = "Ticket status has changed from {$oldStatusName} to {$newStatusName} by {$userFirstName} {$userLastName}.";
            

            History::create([
                'ticket_id' => $ticket->id,
                'user_id' => $userId,
                'description' => $description,
            ]);
        }

        if ($ticket->isDirty('priority_id')) {
            $oldStatusId = $ticket->getOriginal('status_id');
            $oldPriorityId = $ticket->getOriginal('priority_id');
            $newPriorityId = $ticket->priority_id;

            $oldPriority = Priority::find($oldPriorityId);
            $oldPriorityName = $oldPriority ? $oldPriority->category : 'Unknown';
        
            $newPriority = Priority::find($newPriorityId);
            $newPriorityName = $newPriority ? $newPriority->category : 'Unknown';
        
            
            $userId = Auth::guard('user')->id();
            $user = Auth::guard('user')->user();
            $userFirstName = $user->first_name;
            $userLastName = $user->last_name;
            $description = "Ticket priority has changed from {$oldPriorityName} to {$newPriorityName} by {$userFirstName} {$userLastName}.";
            

            History::create([
                'ticket_id' => $ticket->id,
                'user_id' => $userId,
                'description' => $description,
            ]);
        }

        if ($ticket->isDirty('employee_id')) {
            $oldStatusId = $ticket->getOriginal('status_id');
            $oldPriorityId = $ticket->getOriginal('priority_id');
            $oldEmployeeId = $ticket->getOriginal('employee_id');
            $newEmployeeId = $ticket->employee_id;

            $oldEmployee = User::find($oldEmployeeId);
            $oldEmployeeFullName = $oldEmployee ? $oldEmployee->first_name . ' ' . $oldEmployee->last_name : 'Unknown';

            $newEmployee = User::find($newEmployeeId);
            $newEmployeeFullName = $newEmployee ? $newEmployee->first_name . ' ' . $newEmployee->last_name : 'Unknown';
        
            
            $userId = Auth::guard('user')->id();
            $user = Auth::guard('user')->user();
            $userFirstName = $user->first_name;
            $userLastName = $user->last_name;
            $description = "Ticket has been assigned to {$newEmployeeFullName} from {$oldEmployeeFullName} by {$userFirstName} {$userLastName}.";
            

            History::create([
                'ticket_id' => $ticket->id,
                'user_id' => $userId,
                'description' => $description,
            ]);
        }
    }

    /**
     * Handle the Ticket "deleted" event.
     */
    public function deleted(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "restored" event.
     */
    public function restored(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "force deleted" event.
     */
    public function forceDeleted(Ticket $ticket): void
    {
        //
    }
}
