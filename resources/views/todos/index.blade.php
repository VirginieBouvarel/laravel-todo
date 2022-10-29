@extends('layouts.app')

@section('content')

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xs">
        <a class="btn btn-primary m-2" role="button" href="{{ route('todos.create')}}">Ajouter une todo</a>
      </div>

      <div class="col-xs">
        @if (Route::currentRouteName() == 'todos.index')
          <a class="btn btn-warning m-2" role="button" href="{{ route('todos.undone')}}">Voir les todos ouvertes</a>
        </div>
        <div class="col-xs">
          <a class="btn btn-success m-2" role="button" href="{{ route('todos.done')}}">Voir les todos terminées</a>
        @elseif (Route::currentRouteName() == 'todos.done')
          <a class="btn btn-dark m-2" role="button" href="{{ route('todos.index')}}">Voir toutes les todos</a>
        </div>
        <div class="col-xs">
          <a class="btn btn-warning m-2" role="button" href="{{ route('todos.undone')}}">Voir les todos ouvertes</a>
        @elseif (Route::currentRouteName() == 'todos.undone')
          <a class="btn btn-dark m-2" role="button" href="{{ route('todos.index')}}">Voir toutes les todos</a>
          <a class="btn btn-success m-2" role="button" href="{{ route('todos.done')}}">Voir les todos terminées</a>
        @endif
      </div>
    </div>
  </div>

  @foreach ($datas as $data)
    <div class="alert alert-{{ $data->done ? 'success' : 'warning'}}" role="alert">
      <strong>{{ $data->name }}
        @if($data->done)
        <span class="badge badge-success">Done</span>
        @endif
      </strong>
    </div>
  @endforeach

  {{ $datas->links()}}
@endsection
