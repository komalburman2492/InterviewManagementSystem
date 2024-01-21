<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="feedbackModalLabel">Interview Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row mb-3">
                @if(auth()->user()->role == \App\Constants\RoleConstants::ADMIN)
                    <div class="col">
                        <h4>Interview Details</h4>
                        <p><strong>Candidate Name:</strong> {{ $interview->candidate->name }}</p>
                        <p><strong>Interviewer:</strong> {{ $interview->interviewer->name }}</p>
                        @php
                            $carbonDate = \Carbon\Carbon::parse($interview->scheduled_at);
                            $formattedDate = $carbonDate->format('l, d F Y H:i');
                        @endphp
                        <p><strong>Interview Schedule Time:</strong> {{ $formattedDate }}</p>
                        <p><strong>Interview Type:</strong> {{ \App\Constants\InterviewTypeConstants::getInterviewType($interview->interview_type) }}</p>
                        <p><strong>Interview Recommendation:</strong> {{ \App\Constants\InterviewRecommendationConstants::getInterviewRecommendationType($interview->feedback_recommendation) }}</p>
                    </div>
                @endif
                @if(auth()->user()->role == \App\Constants\RoleConstants::ADMIN || auth()->user()->role == \App\Constants\RoleConstants::CANDIDATE )
                    <div class="col">
                        <h4>Interview Feedback</h4>
                        <p><strong>Feedback Strengths:</strong> {!! $interview->feedback_strengths ?? '<i>Pending</i>' !!}</p>
                        <p><strong>Feedback Weaknesses:</strong> {!! $interview->feedback_weaknesses ?? '<i>Pending</i>' !!}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
