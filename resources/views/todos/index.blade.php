@foreach ($datas as $data)
  <h4>Nom : {{ $data->name }} | Done : {{ $data->done }}</h4>
@endforeach
