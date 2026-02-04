<?php
// namespace App\Models;
// use Illuminate\Database\Eloquent\Model;
// class Task extends Model
// {
//     protected $fillable = [
//         'task_title',
//         'client_name',
//         'description',
//         'status'
//     ];

//     public function users()
//     {
//         return $this->belongsToMany(User::class, 'task_users');
//     }

//     public function taskUsers()
//     {
//         return $this->hasMany(taskUser::class, 'task_id');
//     }
// }
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\TaskUser;
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_title',
        'client_name',
        'description',
        'status',
    ];

    /**
     * Many-to-Many: Task ↔ Users
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'task_users')
                    ->withTimestamps();
    }

    /**
     * One-to-Many: Task → TaskUser (pivot model)
     */
    public function taskUsers()
    {
        return $this->hasMany(TaskUser::class);
    }
}
?>
