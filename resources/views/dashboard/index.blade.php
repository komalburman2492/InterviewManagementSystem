@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        <p>Welcome, {{ $user->name }}!</p>

                        <!-- Menu items based on user role -->
                        @if($user->role->name === 'admin')
                            <p>Show admin menu items here</p>
                        @elseif($user->role->name === 'interviewer')
                            <p>Show interviewer menu items here</p>
                        @elseif($user->role->name === 'candidate')
                            <p>Show candidate menu items here</p>
                        @endif

                        <!-- Common dashboard content here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
