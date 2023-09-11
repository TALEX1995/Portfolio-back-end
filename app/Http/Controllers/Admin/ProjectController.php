<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::all();
        $technologies = Technology::all();

        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'string|max:50|required|unique:projects',
            'description' => 'string|required',
            'image' => 'nullable|image:jpg,jpeg,png',
            'type_id' => 'nullable|exists:types,id',
            'technologies' => 'nullable|exists:technologies,id'
        ], [
            'title.string' => 'Il titolo non è valido',
            'title.max' => 'Il titolo non può essere più lungo di 50 caratteri',
            'title.required' => 'Il titolo è obbligatorio',
            'title.unique' => 'Esiste già un progetto con questo titolo',
            'description.string' => 'La descrizione non è valida',
            'description.required' => 'La descrizione è obbligatoria',
            'image.image' => 'Il formato dell\'immagine non è valido',
            'type_id.exists' => 'Il tipo è inesistente',
            'technologies.exists' => 'La tecnologia selezionata non è valida'
        ]);

        $data = $request->all();

        $project = new Project();

        // Added image in project
        if (array_key_exists('image', $data)) {
            $img_url = Storage::putFile('project_img', $data['image']);
            $data['image'] = $img_url;
        }

        $project->fill($data);

        $project->save();

        if (array_key_exists('technologies', $data)) {
            $project->technologies()->attach($data['technologies']);
        }

        return to_route('admin.projects.show', $project)->with('message', 'Progetto creato con successo');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        // Take Type from database
        $types = Type::all();

        // Take Technologies from database
        $technologies = Technology::all();

        // Take Technology array id relationed with the current project
        $project_technologies_id = $project->technologies->pluck('id')->toArray();

        return view('admin.projects.edit', compact('project', 'types', 'technologies', 'project_technologies_id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => ['string', 'max:50', 'required', Rule::unique('projects')->ignore($project->id)],
            'description' => 'string|required',
            'image' => 'nullable|image:jpg,jpeg,png',
            'type_id' => 'nullable|exists:types,id',
            'technologies' => 'nullable|exists:technologies,id'
        ], [
            'title.string' => 'Il titolo non è valido',
            'title.max' => 'Il titolo non può essere più lungo di 50 caratteri',
            'title.required' => 'Il titolo è obbligatorio',
            'title.unique' => 'Esiste già un progetto con questo titolo',
            'description.string' => 'La descrizione non è valida',
            'description.required' => 'La descrizione è obbligatoria',
            'image.image' => 'Il formato dell\'immagine non è valido',
            'type_id.exists' => 'Il tipo è inesistente',
            'technologies.exists' => 'La tecnologia selezionata non è valida'
        ]);

        $data = $request->all();

        // Added image in project
        if (array_key_exists('image', $data)) {
            if ($project->image) Storage::delete($project->image);
            $img_url = Storage::putFile('project_img', $data['image']);
            $data['image'] = $img_url;
        }

        $project->update($data);

        if (!array_key_exists('technologies', $data) && count($project->technologies)) {
            $project->technologies()->detach();
        } elseif (array_key_exists('technologies', $data)) {
            $project->technologies()->sync($data['technologies']);
        }

        return to_route('admin.projects.show', $project)->with('message', 'Progetto modificato con successo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return to_route('admin.projects.index')->with('message', 'Progetto eliminato con successo');
    }

    public function forceDelete(string $id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);
        if (!$project) return to_route('admin.projects.index')->with('message', 'il progetto non è stato trovato');
        // Delete img
        if ($project->image) Storage::delete($project->image);

        // Delete relation 
        if (count($project->technologies)) $project->technologies()->detach();

        // Force delete
        $project->forceDelete();
    }
}
