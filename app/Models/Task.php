<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;


    public function dependencies()
    {
        return $this->hasMany(TaskDependency::class , 'task_id');
    }

    public function dependentOn(){
        return $this->hasMany(TaskDependency::class, 'dependency_task_id');
    }
}
