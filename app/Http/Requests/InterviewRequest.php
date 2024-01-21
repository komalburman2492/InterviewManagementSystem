<?php

namespace App\Http\Requests;

use App\Constants\InterviewTypeConstants;
use App\Constants\RoleConstants;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class InterviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->role == RoleConstants::INTERVIEWER;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'id' => [
                'nullable',
                'integer',
                'exists:interviews,id',
            ],
            'scheduled_at' => [
                'required',
                'date',
                'after:now',
            ],
            'interview_type' => [
                'required',
                'in:' . implode(',', InterviewTypeConstants::getTypes()),
            ],
        ];
        if ($this->has('add_feedback') && $this->input('add_feedback')) {
            $rules['candidate_id'] = ['integer', 'exists:users,id'];
            $rules['interview_type'] = ['in:' . implode(',', InterviewTypeConstants::getTypes())];
        } else {
            $rules['interview_type'] = ['required', 'in:' . implode(',', InterviewTypeConstants::getTypes())];
            $rules['candidate_id'] = ['required', 'integer', 'exists:users,id'];
        }

        return $rules;
    }
}
