<?php

namespace App\Http\Controllers;

use App\PlantList;
use Illuminate\Http\Request;

use App\Http\Requests;

class PlantController extends Controller
{

    public function search(Request $request)
    {
        $query = PlantList::searchByName($request->get('term'));

        return $query->paginate(20);
    }
}
