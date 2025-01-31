<?php

namespace App\Http\Controllers;

use App\Models\Materiel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaterielController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_ville' => 'required|numeric',
            'id_quartier' => 'required|numeric' ,
            'prix_unitaire' => 'required|numeric',
            'etat' => 'required',
            'type' => 'required',
            'url_image' => 'nullable|string',
            'caracterisque' => 'nullable|string',
            'quantite_stock' => 'nullable|integer',
            'publier' => 'nullable|boolean',
        ]);
        

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        $materiel = Materiel::create($data);

        if ($materiel) {
            return response()->json(['message' => 'Produit ajouté avec succes'], 200);
        } else {
            return response()->json(['message' => 'Echec d\'ajout'], 201);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'designation' => 'required|string',
            'prix_unitaire' => 'required|numeric',
            'etat' => 'required',
            'type' => 'required',
            'url_image' => 'nullable|string',
            'caracterisque' => 'nullable|string',
            'quantite_stock' => 'nullable|integer',
            'publier' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $materiel = Materiel::find($request->input('id'));

        if (!$materiel)
            return response()->json(['message' => 'Ce produit n\'existe pas'], 404);

        $data = $request->all();
    
        if ($materiel->update($data)) {
            return response()->json(['message' => 'Mise à jour réussie'], 200);
        } else {
            return response()->json(['message' => 'Echec de la mise à jour'], 400);
        }
    }

    public function getMateriel(Request $request)
    {
        $id = $request->query('id');
    
        if (!$id) {
            return response()->json(['message' => 'Pas assez de données'], 400);
        }
    
        $materiel = Materiel::find($id);
    
        if ($materiel) {
            return response()->json($materiel, 200);
        }
    
        return response()->json(['message' => 'Cet produit n\'existe pas'], 404);
    }    

    public function getMateriels()
    {
        $materiels = Materiel::all();

        return response()->json($materiels, 200);
    }
}
