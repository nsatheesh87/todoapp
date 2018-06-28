<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\TodoStoreRequest;
use App\Models\Task;

/**
 * Class TodoController.
 */
class TodoController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if(\Auth::user()->isAdmin()) {
            $tasks = Task::With('User')->orderBy('created_at', 'asc')->paginate(25);
        } else {
            $tasks = Task::With('User')->where('user_id', \Auth::user()->id)->orderBy('created_at', 'asc')->paginate(25);
        }


        return view('backend.todo.index', [
            'tasks' => $tasks
        ]);
    }

    public function create()
    {
        return view('backend.todo.create');
    }

    public function store(TodoStoreRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = \Auth::user()->id;
        Task::create($input);
        return redirect()->route('admin.todotask.index')->withFlashSuccess('Task has been created successfully');
    }

    public function edit(Task $task)
    {
        if ((\Auth::check() && \Auth::user()->id == $task->user_id) || (\Auth::user()->isAdmin()))
        {
            return view('backend.todo.edit', ['task' => $task]);
        }
        else {
            return redirect()->route('admin.todotask.index')->withFlashDanger('Invalid request');
        }
    }
    public function update(TodoStoreRequest $request, Task $task)
    {
        $task->title = $request->title;
        $task->description = $request->description;
        $task->save();
        return redirect()->route('admin.todotask.index')->withFlashSuccess('Task has been updated successfully');
    }

    public function destroy(Task $task)
    {
        if ((\Auth::check() && \Auth::user()->id == $task->user_id) || (\Auth::user()->isAdmin()))
        {
            $task->delete();
            return redirect()->route('admin.todotask.index')->withFlashSuccess('Task fas been deleted successfully');
        }
        else {
            return redirect()->route('admin.todotask.index')->withFlashDanger('Invalid request');
        }
    }

}
