@extends('layouts.auth.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h2>@if (isset($interview) && $interview->id) @if($addFeedback) Leave Feedback @else Edit Interview Details @endif @else Schedule New Interview @endif </h2>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('interviews.list') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>

    <form method="POST" action="{{ route('interviews.store') }}">
        @csrf
        @if (isset($interview) && $interview->id)
        <input type="hidden" name="id" value="{{ isset($interview)? $interview->id :'' }}"/>
        @endif
        <div class="form-group">
            <label for="candidate_id">Select Candidate:</label>
            <select name="candidate_id" class="form-control"  @if(isset($addFeedback) && $addFeedback) disabled="disabled" @else required @endif>
                @foreach ($candidates as $candidate)
                <option value="{{ $candidate->id }}" {{ (old('candidate_id', $interview->candidate_id) == $candidate->id) ? 'selected' : '' }}>
                    {{ $candidate->name }}
                </option>
                @endforeach
            </select>
            @error('candidate_id')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="scheduled_at">Scheduled Date/Time:</label>
            <input type="datetime-local" name="scheduled_at" class="form-control" @if(isset($addFeedback) && $addFeedback) readonly="readonly" @else required @endif
                value="{{ old('scheduled_at', $interview->scheduled_at ? \Carbon\Carbon::parse($interview->scheduled_at)->format('Y-m-d\TH:i') : '') }}">
            @error('scheduled_at')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="interview_type">Interview Type:</label>
            <select name="interview_type" class="form-control"   @if(isset($addFeedback) && $addFeedback) disabled="disabled" @else required @endif>
                @foreach (\App\Constants\InterviewTypeConstants::getTypes() as $type)
                <option value="{{ $type }}" {{ (old('interview_type', $interview->interview_type) == $type) ? 'selected' : '' }}>
                    {{ \App\Constants\InterviewTypeConstants::getInterviewType($type) }}
                </option>
                @endforeach
            </select>
            @error('interview_type')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        @if (isset($interview) && $interview->id && $addFeedback)

        <input type="hidden" name="add_feedback" value="{{ $addFeedback }}">
        <div class="form-group">
            <label for="feedback_recommendation">Interview Recommendation:</label>
            <select name="feedback_recommendation" class="form-control" required>
                @foreach (\App\Constants\InterviewRecommendationConstants::getTypes() as $type)
                <option value="{{ $type }}" {{ (old('feedback_recommendation', $interview->feedback_recommendation) == $type) ? 'selected' : '' }}>
                    {{ \App\Constants\InterviewRecommendationConstants::getInterviewRecommendationType($type) }}
                </option>
                @endforeach
            </select>
            @error('interview_type')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="feedback_strengths">Feedback Strengths:</label>
            <textarea name="feedback_strengths" class="form-control">{{ old('feedback_strengths', $interview->feedback_strengths) }}</textarea>
            @error('feedback_strengths')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="feedback_weaknesses">Feedback Weaknesses:</label>
            <textarea name="feedback_weaknesses" class="form-control">{{ old('feedback_weaknesses', $interview->feedback_weaknesses) }}</textarea>
            @error('feedback_weaknesses')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        @endif
        <button type="submit" class="btn btn-primary">Schedule Interview</button>
    </form>

</div>
@endsection
