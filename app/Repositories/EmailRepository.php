<?php

namespace App\Repositories;

use App\Mail\CandidateInterviewScheduled;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use Illuminate\Support\Facades\Mail;

class EmailRepository implements EmailRepositoryInterface
{
    public function sendCandidateInterviewScheduledEmail($candidate, $interview)
    {
        Mail::to($candidate->email)->send(new CandidateInterviewScheduled($candidate, $interview));
    }

}
