@extends('layouts.app')

@section('title', 'Progetti')

@section('content')
  <h1 class="mt-3 mb-5 text-center">I miei Progetti</h1>
  {{-- Create Project --}}
  <div class="d-flex justify-content-end">
    <a class="btn btn-secondary" href="{{ route('admin.projects.create') }}">Crea Progetto</a>
  </div>
  {{-- Table Projects --}}
  <table class="table">
    <thead>
      <tr>
        <th scope="col">Titolo</th>
        <th scope="col">Tipo Progetto</th>
        <th scope="col">Tecnologie utilizzate</th>
        <th scope="col">Creato il</th>
        <th scope="col">Modificato il</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($projects as $project)
        <tr>
          <th>{{ $project->title }}</th>
          <td>{{ $project->type?->label }}</td>
          <td>
            @forelse ($project->technologies as $tech)
              <span class="badge rounded-pill text-bg-primary">{{ $tech->label }}</span>
            @empty
              -
            @endforelse
          </td>
          <td>{{ $project->created_at }}</td>
          <td>{{ $project->updated_at }}</td>
          <td>
            <div class="d-flex justify-content-end">
              <a class="btn btn-primary" href="{{ route('admin.projects.show', $project) }}">Dettagli</a>
              <a class="btn btn-warning mx-2" href="{{ route('admin.projects.edit', $project) }}">Modifica</a>
              <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="delete-form">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Elimina</button>
              </form>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  @section('scripts')
    @vite('resources/js/confirmDeleteProject.js')
  @endsection

@endsection
