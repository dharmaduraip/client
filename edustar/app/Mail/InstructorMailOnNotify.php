<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InstructorMailOnNotify extends Mailable
{
    use Queueable, SerializesModels;
    public $x, $user_name,$course_title;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($x, $user_name, $course_title)
    {
        $this->x = $x;
        $this->user_name = $user_name;
        $this->course_title = $course_title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        $subject = "Your ".$this->course_title." course was deleted by Admin";
        return $this->markdown('email.notify_course_deleted')->subject($subject);
    }
}
