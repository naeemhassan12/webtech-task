<?php
// namespace App\Models;
// use Illuminate\Database\Eloquent\Model;
// use App\Models\User;
// use App\Models\Task;

// class taskUser extends Model
// {
//      protected $fillable = [
//      'id',
//      'user_id',
//      'task_id'
//     ];

//     public function user()
//     {
//         return $this->belongsTo(User::class, 'user_id');
//     }

//     public function task()
//     {
//         return $this->belongsTo(Task::class, 'task_id');
//     }

// }



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Task;

class TaskUser extends Model
{
    use HasFactory;

    protected $table = 'task_users'; // make sure it matches your migration

    protected $fillable = [
        'id',
        'user_id',
        'task_id',
    ];

    /**
     * The user associated with this pivot record
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The task associated with this pivot record
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}

