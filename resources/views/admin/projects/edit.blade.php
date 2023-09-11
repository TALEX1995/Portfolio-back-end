@extends('layouts.app')

@section('title', 'Modifica Progetto')

@section('content')
  <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    {{-- Title --}}
    <div class="row mt-3">
      <div class="col-6">
        <div class="mb-3">
          <label for="title" class="form-label">Titolo</label>
          <input type="text" class="form-control" id="title" value="{{ old('title', $project->title) }}"
            name="title">
        </div>
      </div>
      {{-- Add file --}}
      <div class="col-5">
        <div class="mb-3">
          <label for="image-file" class="form-label">Aggiungi lo screenshot del progetto</label>
          <input type="file" class="form-control" id="image-file" name="image">
        </div>
      </div>
      <div class="col-1">
        <img class="img-fluid" src="{{ $project->getImage() }}" alt="Nessun immagine">
      </div>
      {{-- Select Type  --}}
      <div class="col-6">
        <div class="mb-3">
          <label for="type" class="form-label">Tipo di Progetto</label>
          <select class="form-select" id="type" name="type_id">
            <option value="">Nessuno</option>
            @foreach ($types as $type)
              <option @if (old('type_id', $project->type_id) == $type->id) selected @endif value="{{ $type->id }}">{{ $type->label }}
              </option>
            @endforeach
          </select>
        </div>
      </div>
      {{-- Description --}}
      <div class="col-12">
        <div class="mb-3">
          <label for="description" class="form-label">Descrizione</label>
          <textarea class="form-control" id="description" rows="10" name="description">{{ old('description', $project->description) }}</textarea>
        </div>
      </div>
      {{-- Technologies --}}
      <div class="col-12 my-3">
        <h4>Scegli una o più tecnologie utilizzate nel progetto</h4>
        @foreach ($technologies as $technology)
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" @if (in_array($technology->id, old('technologies', $project_technologies_id))) checked @endif
              id="tech-{{ $technology->id }}" value="{{ $technology->id }}" name="technologies[]">
            <label class="form-check-label" for="tech{{ $technology->id }}">{{ $technology->label }}</label>
          </div>
        @endforeach
      </div>
      <div class="col-12 d-flex justify-content-between">
        <a class="btn btn-dark" href="{{ route('admin.projects.index') }}">Torna indietro</a>
        <button class="btn btn-success">Salva</button>
      </div>
    </div>
  </form>
@endsection
