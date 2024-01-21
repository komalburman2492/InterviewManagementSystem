<?PHP
namespace App\Repositories\Interfaces;

Interface EmailRepositoryInterface{
    public function sendCandidateInterviewScheduledEmail($candidate, $interview);

}
