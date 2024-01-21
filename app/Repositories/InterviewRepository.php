<?php

namespace App\Repositories;

use App\Constants\RoleConstants;
use App\Models\Interview;
use App\Repositories\Interfaces\InterviewRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class InterviewRepository implements InterviewRepositoryInterface
{
    public function all()
    {
        switch (Auth::user()->role) {
            case RoleConstants::ADMIN:
                return Interview::latest()->simplePaginate(5);
            case RoleConstants::CANDIDATE:
                return auth()->user()->scheduledInterviews()->simplePaginate(5);
            case RoleConstants::INTERVIEWER:
                return auth()->user()->scheduledInterviewsOfInterviewer()->simplePaginate(5);
            default:
                return null;
        }
    }

    public function saveOrUpdateInterview($interview)
    {
        if ($interview->has('add_feedback') && $interview->get('add_feedback')) {
            $data = [
                'interviewer_id' => auth()->user()->id,
                'feedback_strengths' => $interview->get('feedback_strengths') ?? null,
                'feedback_weaknesses' => $interview->get('feedback_weaknesses') ?? null,
                'feedback_recommendation' => $interview->get('feedback_recommendation') ?? 0,
            ];
        } else {
            $data = [
                'interviewer_id' => auth()->user()->id,
                'candidate_id' => $interview->get('candidate_id'),
                'scheduled_at' => $interview->get('scheduled_at'),
                'interview_type' => $interview->get('interview_type'),
                'feedback_strengths' => $interview->get('feedback_strengths') ?? null,
                'feedback_weaknesses' => $interview->get('feedback_weaknesses') ?? null,
                'feedback_recommendation' => $interview->get('feedback_recommendation') ?? 0,
            ];
        }

        $interviewObj = Interview::updateOrCreate(
            ['id' => $interview->get('id')],
            $data
        );
        /**
         * To check if this is being updated or is new record, Then we will send email to Candidate
         */
        $isNewRecord = $interviewObj->wasRecentlyCreated;

        if ($isNewRecord) {
            $interviewObj->candidate->sendCandidateInterviewScheduledEmail($interviewObj);
        }
        return $interviewObj;
    }

}
