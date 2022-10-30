<?php

namespace App\Http\Controllers;

use App\Todo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    // store all users
    public $users;

    public function __construct()
    {
        $this->users = User::getAllUsers();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $datas = Todo::where(['affectedTo_id' => $userId])->orderBy('id', 'desc')->paginate(10);
        $users = $this->users;
        return view('todos.index', compact('datas', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $todo = new Todo();
        $todo->creator_id = Auth::user()->id;
        $todo->affectedTo_id = Auth::user()->id;
        $todo->name = $request->name;
        $todo->description = $request->description;
        $todo->done = 0;
        $todo->save();

        return redirect()->route('todos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        return view('todos.edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo  $todo)
    {
        if (!isset($request->done)) {
            $request['done'] = 0;
        }
        $todo->update($request->all());
        return redirect()->route('todos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();
        return back();
    }

    /**
     * Display a listing of done's todos.
     */
    public function done()
    {
        $datas = Todo::where('done', 1)-> paginate(10);
        $users = $this->users;
        return view('todos.index', compact('datas', 'users'));
    }
    
    /**
     * Display a listing of undone's todos.
     */
    public function undone()
    {
        $datas = Todo::where('done', 0)-> paginate(10);
        $users = $this->users;
        return view('todos.index', compact('datas', 'users'));
    }

    /**
     * Change todo's status to done.
     *
     * @param Todo $todo
     * @return void
     */
    public function makedone(Todo $todo)
    {
        $todo->done = 1;
        $todo->update();
        return back();
    }
    
    /**
     * Change todo status to done.
     *
     * @param Todo $todo
     * @return void
     */
    public function makeundone(Todo $todo)
    {
        $todo->done = 0;
        $todo->update();
        return back();
    }

    /**
     * Assign a todo to an user.
     *
     * @param App\Todo $todo
     * @param App\User $user
     * @return \Illuminate\Http\Response
     */
    public function affectedTo(Todo $todo, User $user)
    {
        $todo->affectedTo_id = $user->id;
        $todo->affectedBy_id = Auth::user()->id;
        $todo->update();
        return back();
    }
}
