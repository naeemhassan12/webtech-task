<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Task extends Model
{
    protected $fillable = [
        'task_title',
        'client_name',
        'description',
        'status'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->using(TaskUser::class);
    }

}

?>
