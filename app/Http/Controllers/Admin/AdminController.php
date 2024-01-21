<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Interview;
use App\Repositories\Interfaces\InterviewRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    private $interviewRepositoryInterface;
    public function __construct(InterviewRepositoryInterface $interviewRepositoryInterface)
    {
        $this->interviewRepositoryInterface = $interviewRepositoryInterface;
        $this->middleware('admin');
    }

    /**
     * Opens a page to show all of scheduled interviews
     */
    public function index()
    {
        $interviews = $this->interviewRepositoryInterface->all();
        return view('interviews.list',compact('interviews'));
    }



    /**
     * To view interview details
     */
    public function getInterviewDetails(Request $request)
    {
        $interview = Interview::findOrFail($request->id);
        $view = View::make('interviews.modal', compact('interview'))->render();
        return response()->json(['html' => $view]);
    }
}
