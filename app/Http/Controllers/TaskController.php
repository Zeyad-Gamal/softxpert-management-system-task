<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskDependency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    


    public function index(Request $request)
    {
        $tasks = Task::query();

        if(Auth::user()->role === 'user') {

            $tasks->where('assignee_id', Auth::id());
        }

        if($request->has('status')) {
            $tasks->where('status', $request->status);
        }
        
        if($request->has('from') && $request->has('to')) {
            $tasks->whereBetween('due_date', [$request->from, $request->to]);
        }

        if($request->has('assignee_id')) {
            $tasks->where('assignee_id', $request->assignee_id);
        }

        return response()->json($tasks->get());
    }


    public function show($id)
    {
        $task = Task::with('dependencies.dependencyTask')->findOrFail($id);

        if(Auth::user()->role === 'user' && $task->assignee_id !== Auth::id()) {
            return response()->json([
                'message' => 'Forbidden ,you do not have permission to view this task.'
            ], 403);
        }

        return response()->json($task);
        
    }






    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required | string | max:255',
            'description' => 'nullable | string',
            'assignee_id' => 'nullable | integer | exists:users,id',
            'due_date' => 'nullable | date'
        ]);


        $task =  Task::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'assignee_id' => $data['assignee_id'] ?? null,
            'due_date' => $data['due_date'] ?? null,
            'created_by' => Auth::id(),
            'status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task
        ], 201);
    }





    public function update(Request $request , $id)
    {
        

        $task = Task::findOrFail($id);
        if(Auth::user()->role === 'manager'){
            $data = $request->validate([
                'title' => 'sometimes | string | max:255',
                'description' => 'nullable | string',
                'assignee_id' => 'nullable | exists:users,id',
                'due_date' => 'nullable | date',
                'status' => 'nullable | in:pending,completed,canceled'
            ]);

            $task->update($data);
        }
        else{
            return response()->json([
                'message' => 'Forbidden'
            ], 403);
        }

        return response()->json($task);
    }

    public function addDependencies(Request $request , $id)
    {
        $task = Task::findOrFail($id);

        $data = $request->validate([
            'dependencies' => 'required | array',
            'dependencies.*' => 'exists:tasks,id'
        ]);

        foreach ($data['dependencies'] as $dependencyId) {
            if($dependencyId == $task->id) {
                return response()->json([
                    'message' => 'A task cannot depend on itself.'
                ], 422);
            }

            TaskDependency::firstOrCreate([
                'task_id' => $task->id,
                'dependency_task_id' => $dependencyId
            ]);


        }

        return response()->json(['message' => 'Dependencies added successfully'],201);

    }

    public function updateStatus(Request $request , $id)
    {
        
        $task = Task::findOrFail($id);
        
        if($task->assignee_id !== Auth::id() ) {
            return response()->json([
                'message' => 'Forbidden'
            ], 403);
        }

        $data = $request->validate([
            'status' => 'required | in:pending,completed,canceled'
        ]);


        if($data['status'] === 'completed' ) {
            $unfinishedDependencies = TaskDependency::where('task_id', $task->id)
                ->whereHas('dependencyTask', function($query) {
                    $query->where('status', '!=', 'completed');
                })->count();

                if($unfinishedDependencies > 0) {
                    return response()->json([
                        'message' => 'Cannot mark task as completed. It has unfinished dependencies.'
                    ], 422);
                }
        }


        $task->update([
            'status' => $data['status']
        ]);

        return response()->json($task);
    }
}
