<?php

namespace App\Http\Controllers;

use App\Todo;

use Illuminate\Http\Request;

class TodosController extends Controller
{
    public function index()
    {
        //  fetch all todos from database, display them in the todos.index page
        $todos = Todo::all();
        return view('todos.index')->with('todos',$todos);
    }

    public function show(Todo $todo)
    {
        // dd($todoId);
        // $todo = Todo::find($todoId);
        return view('todos.show')->with('todo', $todo);
    }

    public function create()
    {

        return view('todos.create');
    }

    public function store()
    {
        $this->validate(request(),[
            'name' => 'required|min:6',
            'description' => 'required'
        ]);
        $data = request()->all();
        $todo = new Todo();
        $todo->name = $data['name'];
        $todo->description = $data['description'];
        $todo->completed = false;
        $todo->save();

        session()->flash('success', 'Todo created successfully.');

        return redirect('/todos');
    }

    public function edit(Todo $todo)
    {
        return view('todos.edit')->with('todo', $todo);
    }

    public function update(Todo $todo)
    {
        $this->validate(request(),[
            'name' => 'required|min:6',
            'description' => 'required'
        ]);
        $data = request()->all();
        $todo->name = $data['name'];
        $todo->description = $data['description'];
        $todo->save();

        session()->flash('success', 'Todo updated successfully.');

        return redirect('/todos');
    }

    public function destory(Todo $todo)
    {
        $todo->delete();
        session()->flash('success', 'Todo deleted successfully.');
        return redirect('/todos');
    }

    public function complete(Todo $todo)
    {
        $todo->completed = true;
        $todo->save();
        session()->flash('success', 'Todo completed successfully.');
        return redirect('/todos');
    }
}
