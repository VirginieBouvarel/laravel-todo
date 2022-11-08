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
      <div class="row">
        <div class="col-sm">
          <p class="my-0">
            <strong>
              <span class="badge badge-dark">#{{ $data->id }}</span>
            </strong>
            <small>
              Crée {{ $data->created_at->from() }} par
              {{ Auth::user()->id == $data->user->id ? 'moi' : $data->user->name }}

              @if ($data->todoAffectedTo && $data->todoAffectedTo->id == Auth::user()->id)
              affectée à moi
              @elseif ($data->todoAffectedTo)
              {{ $data->todoAffectedTo ? ', affectée à ' . $data->todoAffectedTo->name : '' }}
              @endif
              {{-- display affected by someone or by user himself --}}
              @if ($data->todoAffectedTo && $data->todoAffectedBy && $data->todoAffectedBy->id == Auth::user()->id)
              par moi-même :D
              @elseif ($data->todoAffectedTo && $data->todoAffectedBy && $data->todoAffectedBy->id != Auth::user()->id)
              par {{ $data->todoAffectedBy->name }}
              @endif
            </small>
            @if($data->done)
            <small>
              <p>
                Terminée
                {{ $data->updated_at->from() }} - Terminée en
                {{ $data->updated_at->diffForHumans($data->created_at, 1) }}
              </p>
            </small>
            @endif
          </p>
          <details>
            <summary>
              <strong>{{ $data->name }}
                @if($data->done)
                <span class="badge badge-success">Done</span>
                @endif
              </strong>
            </summary>
            <p>{{ $data->description }}</p>
          </details>

        </div>
        <div class="col-sm form-inline justify-content-end my-1">
          {{-- Button affected to --}}
          <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" ara-haspopup="true" aria-expanded="false">
              Affecter à
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              @foreach ($users as $user)
                <a class="dropdown-item" href="/todos/{{ $data->id }}/affectedTo/{{ $user->id }}">{{ $user->name }}</a>
              @endforeach
            </div>
          </div>
          {{-- Button done/undone --}}
          @if($data->done == 0)
          <form action="{{ route('todos.makedone', $data->id) }}" method="post">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-success mx-1" style="min-width:90px;">Done</button>
          </form>
          @else
          <form action="{{ route('todos.makeundone', $data->id) }}" method="post">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-warning mx-1" style="min-width:90px;">undone</button>
          </form>
          @endif
          {{-- Button edit --}}
          <a class="btn btn-info mx-1" href="{{ route('todos.edit', $data->id) }}" role="button">Editer</a>
          {{-- Button delete --}}
          <form action="{{ route('todos.destroy', $data->id) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger mx-1">Effacer</button>
          </form>
        </div>
      </div>
    </div>
  @endforeach

  {{ $datas->links()}}
@endsection
