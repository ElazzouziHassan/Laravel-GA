<?php

namespace App\Http\Controllers;

use App\Models\ActivitesModel;
use Illuminate\Http\Request;

class ActivitesController extends Controller
{
    // a - la fonction index:
    public function index()
    {
        $activites = ActivitesModel::all();
        return view('index', compact('activites'));
    }

    // b - la fonction store:
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titre' => 'required|unique:activites',
            'difficulte' => 'required|integer|min:1|max:5',
            'duree' => 'required|integer|min:10',
            'age_max' => 'required|integer|min:1|max:15',
        ]);

        ActivitesModel::create($validatedData);

        return redirect()->route('index')->with('success', 'Activité ajoutée avec succès.');
    }

    public function update(Request $request, ActivitesModel $activite)
    {
        $validatedData = $request->validate([
            'titre' => 'required|unique:activites,titre,' . $activite->id . '|regex:/^[A-Za-z0-9\s]+$/',
            'difficulte' => 'required|integer|min:1|max:5',
            'duree' => 'required|integer|min:10',
            'age_max' => 'required|integer|min:1|max:15',
        ]);

        $activite->update($validatedData);

        return redirect()->route('activites.index')->with('success', 'Activité mise à jour avec succès.');
    }

    public function destroy(ActivitesModel $activite)
    {
        $activite->delete();

        return redirect()->route('activites.index')->with('success', 'Activité supprimée avec succès.');
    }
}
