@extends('layouts.app')

@section('content')
  @foreach ($datas as $data)
    <div class="alert alert-primary" role="alert">
      <strong>{{ $data->name }}
        @if($data->done)
        <span class="badge badge-success">Done</span>
        @endif
      </strong>
    </div>
  @endforeach
@endsection
