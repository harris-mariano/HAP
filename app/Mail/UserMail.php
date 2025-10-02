<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $isSuccess, $name, $type, $title, $status, $priority, $employee, $commenter, $comment, $ticketId, $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     public function __construct($name, $type, $title = null, $status = null, $priority = null, $employee = null, $commenter = null, $comment = null, $ticketId = null, $token = null)
    {
        $this->name = $name;
        $this->type = $type;
        $this->title = $title;
        $this->status = $status;
        $this->priority = $priority;
        $this->employee = $employee;
        $this->commenter = $commenter;
        $this->comment = $comment;
        $this->ticketId = $ticketId;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mailtrapEmail = config('mail.mailtrap_email');
        $subject = '';
        $view = '';

        switch ($this->type) {
            case 'registration':
                $subject = 'Registration Successful';
                $view = 'email.registration';
                break;
            case 'reset_password':
                $subject = 'Reset Password Request';
                $view = 'email.reset-password';
                break;
            case 'ticket_creation':
                $subject = 'Ticket Creation';
                $view = 'email.ticket-creation';
                break;
            case 'ticket_assignment':
                $subject = 'Ticket Assignment';
                $view = 'email.ticket-assignment';
            break;
            case 'ticket_update':
                $subject = 'Ticket Updates';
                $view = 'email.ticket-update';
            break;
            case 'ticket_comment':
                $subject = 'Ticket Discussion';
                $view = 'email.ticket-comment';
            break;
            case 'password_changed':
                $subject = 'Password Changed';
                $view = 'email.password-changed';
            break;
            case 'new_message':
                $subject = 'New Contact Form Submission ';
                $view = 'email.new-message';
            break;
            default:
                break;
        }

        return $this->to($mailtrapEmail)
            ->from('helpdesk@adish.com.ph', 'Adish HAP')
            ->subject($subject)
            ->view($view)
            ->with([
                'name' => $this->name,
                'title' => $this->title,
                'status' => $this->status,
                'priority' => $this->priority,
                'employee' => $this->employee,
                'commenter' => $this->commenter,
                'comment' => $this->comment,
                'ticketId' => $this->ticketId,
                'token' => $this->token,
            ]);
    }
}
