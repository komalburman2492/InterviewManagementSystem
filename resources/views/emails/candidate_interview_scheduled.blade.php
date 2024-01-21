@php
    $carbonDate = \Carbon\Carbon::parse($interview->scheduled_at);
    $formattedDate = $carbonDate->format('l, d F Y H:i');
@endphp




<p>Hello {{ $candidate->name }},</p>

<p>Your interview is scheduled for {{ $formattedDate }}.</p>
<p>Interview Type: {{ \App\Constants\InterviewTypeConstants::getInterviewType($interview->interview_type) }}</p>
<p>Interviewer: {{ $interview->interviewer->name }}</p>

<p>Best of luck!</p>

<p>Regards,</p>
<p>{{ env('APP_NAME') }}</p>
