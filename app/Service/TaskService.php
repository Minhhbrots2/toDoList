<?php 
namespace App\Services;

use App\Models\Task;

class TaskService
{
    public function getAllTasks()
    {
        return Task::orderBy('order')->get();
    }

    public function createTask($data)
    {
        return Task::create([
            'name' => $data['name'],
            'completed' => $data['completed'] ?? false,
            'order' => $data['order'] ?? 0,
        ]);
    }

    public function updateTask($task, $data)
    {
        $task->update([
            'name' => $data['name'],
            'completed' => $data['completed'],
            'order' => $data['order'],
        ]);
        return $task;
    }

    public function updateTaskOrder($tasks)
    {
        foreach ($tasks as $taskData) {
            $task = Task::find($taskData['id']);
            if ($task) {
                $task->update(['order' => $taskData['order']]);
            }
        }
    }

    public function deleteTask($task)
    {
        $task->delete();
    }
}