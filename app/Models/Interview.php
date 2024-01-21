<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'interviewer_id',
        'candidate_id',
        'scheduled_at',
        'interview_type',
        'feedback_strengths',
        'feedback_weaknesses',
        'feedback_recommendation',
    ];
    protected $appends = ['interview_time'];
    /**
     * To fetch interviewer details of the scheduled interview
     */
    public function interviewer()
    {
        return $this->belongsTo(User::class, 'interviewer_id');
    }

    /**
     * To fetch candidate details of the scheduled interview
     */
    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    public function getInterviewTimeAttribute()
    {
        return Carbon::parse($this->scheduled_at)->format('l, d F Y H:i');
    }


}
