<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return response()->json(Task::orderBy('order')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $task = Task::create([
            'name' => $request->name,
            'completed' => $request->completed ?? false,
            'order' => $request->order ?? 0,
        ]);

        return response()->json($task, 201);
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $task->update([
            'name' => $request->name,
            'completed' => $request->completed,
            'order' => $request->order,
        ]);

        return response()->json($task);
    }

    public function updateOrder(Request $request)
    {
        foreach ($request->tasks as $taskData) {
            $task = Task::find($taskData['id']);
            if ($task) {
                $task->update(['order' => $taskData['order']]);
            }
        }

        return response()->json(['message' => 'Order updated successfully'], 200);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(null, 204);
    }
}
