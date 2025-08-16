<?php

namespace App\Http\Controllers;

use App\Models\Task;
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
        // Logic to get task details by ID
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





    public function update($id, Request $request)
    {
        // Logic to update an existing task
    }

    public function addDependencies($id, Request $request)
    {
        // Logic to add dependencies to a task
    }

    public function updateStatus($id, Request $request)
    {
        // Logic to update the status of a task
    }
}
