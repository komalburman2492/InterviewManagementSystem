<?php

namespace App\Http\Controllers\Interviewer;

use App\Constants\RoleConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\InterviewRequest;
use App\Models\Interview;
use App\Models\User;
use App\Repositories\Interfaces\InterviewRepositoryInterface;
use Illuminate\Http\Request;

class InterviewerController extends Controller
{

    private $interviewRepositoryInterface;
    public function __construct(InterviewRepositoryInterface $interviewRepositoryInterface)
    {
        $this->interviewRepositoryInterface = $interviewRepositoryInterface;
        $this->middleware('interviewer');
    }


    /**
     * Opens a page to show all scheduled interviews by logged in interviwer
     */
    public function index(){

        $interviews = $this->interviewRepositoryInterface->all();
        return view('interviews.list',compact('interviews'));
    }

    /**
     * Opens a form to schedule a new interview with a candidate
     */
    public function create()
    {
        $user = new User();
        $candidates = $user->scopeRole(RoleConstants::CANDIDATE)->get();
        $interview = new Interview();
        return view('interviews.create', compact('candidates', 'interview'));
    }


    /**
     * Schedule interview logic function
     */
    public function store(InterviewRequest $request)
    {
        $interview = $this->interviewRepositoryInterface->saveOrUpdateInterview($request->request);
        return redirect()->route('interviews.list')->with('success', 'Interview scheduled successfully!');
    }


    /**
     * Opens edit form to edit a interview
     */
    public function edit(Interview $interview)
    {
        $user = new User();
        $addFeedback = false;
        $candidates = $user->scopeRole(RoleConstants::CANDIDATE)->get();
        return view('interviews.create', compact('interview','candidates','addFeedback'));
    }
    /**
     * function will allow only to leave feedback to interview
     */

    public function addFeedback(Interview $interview)
    {

        $user = new User();
        $addFeedback = true;
        $candidates = $user->scopeRole(RoleConstants::CANDIDATE)->get();
        return view('interviews.create', compact('interview','addFeedback','candidates'));
    }

    public function destroy(Interview $interview)
    {
        $interview->delete();
        return redirect()->route('interviews.list')->with('success', 'Interview deleted successfully');
    }

}
