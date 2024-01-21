<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Repositories\Interfaces\EmailRepositoryInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'role', // Added key 'role' to save Role of the User
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * @var EmailRepositoryInterface
     */
    protected $emailRepositoryInterface;

    /**
     * User constructor.
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->emailRepositoryInterface = app(EmailRepositoryInterface::class);
    }

    /**
     * Check what Role is assigned to the User
     */
    public function userRole()
    {
        return $this->hasOne(Role::class, 'id', 'role', );
    }

    /**
     * Scope to fetch Cndidates/Admin/Interviewers Users
     */
    public function scopeRole($role)
    {
        if ($role != null) {
            return $this->where('role', $role);
        }
        return $this;
    }

    public function scheduledInterviews()
    {
        return $this->hasMany(Interview::class, 'candidate_id');
    }

    public function scheduledInterviewsOfInterviewer()
    {
        return $this->hasMany(Interview::class, 'interviewer_id');
    }

    public function sendCandidateInterviewScheduledEmail($interview)
    {
        $this->emailRepositoryInterface->sendCandidateInterviewScheduledEmail($this, $interview);
    }

}
