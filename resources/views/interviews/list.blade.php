@extends('layouts.auth.app')

@section('content')
<style>

</style>
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h2>{{ __('Interview List') }}</h2>
            @if(auth()->user()->userRole->name === 'Interviewer')
            <a href="{{ route('interviews.create') }}" class="btn btn-primary">Schedule New Interview</a>
            @endif
        </div>
    </div>
    <div class="card-body">
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <table class="table tble-sm table-responsive">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Interviewer</th>
                    <th>Candidate</th>
                    <th>Scheduled At</th>
                    <th>Interview Type</th>
                    <th>Feedback Recommendation</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($interviews as $interview)
                <tr>
                    <td>{{ $interview->id }}</td>
                    <td>{{ $interview->interviewer->name }}</td>
                    <td>{{ $interview->candidate->name }}</td>
                    <td>{{ $interview->interview_time }}</td>
                    <td>{{ \App\Constants\InterviewTypeConstants::getInterviewType($interview->interview_type) }}</td>
                    <td>{{
                        \App\Constants\InterviewRecommendationConstants::getInterviewRecommendationType($interview->feedback_recommendation)
                        }}</td>
                    <td>
                        @if(auth()->user()->role == \App\Constants\RoleConstants::ADMIN || auth()->user()->role ==
                        \App\Constants\RoleConstants::INTERVIEWER)
                        @if(auth()->user()->role == \App\Constants\RoleConstants::INTERVIEWER)
                        <a href="{{ route('interviews.edit', $interview->id) }}" class="btn btn-sm btn-warning">Edit</a>

                        <a href="{{ route('interviews.addFeedback', $interview->id) }}"
                            class="btn btn-sm btn-success">Add/Edit Feedback</a>
                        @endif
                        <form action="{{ route('interviews.destroy', $interview->id) }}" method="POST"
                            style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure you want to delete?')">Delete</button>
                        </form>
                        @endif
                        @if(auth()->user()->role == \App\Constants\RoleConstants::ADMIN)
                        <a href="#" class="btn btn-sm btn-info"
                            onclick="openFeedbackModal('admin',{{ $interview->id }})">View Feedback</a>
                        @endif
                        @if(auth()->user()->role == \App\Constants\RoleConstants::CANDIDATE)
                        <a href="#" class="btn btn-sm btn-info"
                            onclick="openFeedbackModal('candidate',{{ $interview->id }})">View Feedback</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center list-none">
            {{ $interviews->links() }}
        </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">

</div>


<script>
    function openFeedbackModal(type, interviewId) {

        if (type == 'admin') {
        $.ajax({
            url: "{{ route('admin.interview-details' ) }}",
            method: 'GET',
            data : {
                id: interviewId
            },
            success: function (data) {
                $('#feedbackModal').html(data.html)
                $('#feedbackModal').modal('show');
            },
            error: function (error) {
                console.error('Error fetching interview details:', error);
            }
        });
    }
    else
    {
        $.ajax({
            url: "{{ route('candidate.interview-details' ) }}",
            method: 'GET',
            data : {
                id: interviewId
            },
            success: function (data) {
                $('#feedbackModal').html(data.html)
                $('#feedbackModal').modal('show');
            },
            error: function (error) {
                console.error('Error fetching interview details:', error);
            }
        });
    }

    }
</script>
@endsection
