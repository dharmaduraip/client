<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InstructorCourseInvolve extends Mailable
{
    use Queueable, SerializesModels;
    public $req_user_name, $instructor_name,$course_title;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($req_user_name, $instructor_name, $course_title)
    {
        $this->req_user_name = $req_user_name;
        $this->instructor_name = $instructor_name;
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
        $subject = $this->req_user_name." like to involve for your course (".$this->course_title.").";
        return $this->markdown('email.req_to_involve_instructor')->subject($subject);
    }
}
