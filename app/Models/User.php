<?php
// namespace App\Models;
// use App\Models\Task;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Notifications\Notifiable;

// class User extends Authenticatable
// {
//     protected $fillable = [
//         'name',
//         'password',
//         'email',
//         'role'
//     ];

//     public function tasks()
//     {
//         return $this->belongsToMany(Task::class, 'task_users');
//     }

//     public function taskUsers()
//     {
//         return $this->hasMany(taskUser::class, 'user_id');
//     }
// }

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\user;
use App\Models\TaskUser;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Many-to-Many: User ↔ Tasks
     */
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_users')
                    ->withTimestamps();
    }

    /**
     * One-to-Many: User → TaskUser (pivot model)
     */

    public function taskUsers()
    {
        return $this->hasMany(TaskUser::class);
    }
}
