<?php
namespace App\Models;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'password',
        'email',
        'role'
    ];

    public function tasks()
    {
        return $this->belongsToMany(Task::class)->using(TaskUser::class);
    }


}




