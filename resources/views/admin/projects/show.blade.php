@extends('layouts.app')

@section('title', 'Progetto')

@section('content')
  <h1>{{ $project->title }}</h1>
  <span><strong>Tipo Progetto : </strong>{{ $project->type?->label }}</span>
  @if ($project->image)
    <img src="{{ $project->getImage() }}" alt="{{ $project->title }}">
  @endif
@endsection
