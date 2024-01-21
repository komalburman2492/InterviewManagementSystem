<?PHP
namespace App\Repositories\Interfaces;

Interface InterviewRepositoryInterface{
    public function all();
    public function saveOrUpdateInterview($interview);

}
