<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskDependency extends Model
{
    use HasFactory;
 protected $fillable = [
        'task_id',
        'dependency_task_id',
    ];
public $timestamps = false;

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }


    public function dependencyTask()
    {
        return $this->belongsTo(Task::class, 'dependency_task_id');
    }


}
