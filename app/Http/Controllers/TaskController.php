<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
        $statusFilter = $request->input('status');

        $tasks = Task::where('user_id', auth()->id()) 
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('title', 'like', "%{$query}%")
                                     ->orWhere('id', $query);
            })
            ->when($statusFilter, function ($queryBuilder) use ($statusFilter) {
                if ($statusFilter === 'completed') {
                    return $queryBuilder->where('completed', true);
                } elseif ($statusFilter === 'incomplete') {
                    return $queryBuilder->where('completed', false);
                }
            })
            ->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Task::create($request->only('title', 'description') + ['user_id' => auth()->id()]);

        return redirect()->route('tasks.index')->with('success', 'Задача успешно добавлена.');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task->update($request->only('title', 'description'));

        return redirect()->route('tasks.index')->with('success', 'Задача успешно обновлена.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Задача успешно удалена.');
    }

    public function toggleComplete(Task $task)
    {
        $task->completed = !$task->completed;
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Статус задачи обновлён.');
    }
}
