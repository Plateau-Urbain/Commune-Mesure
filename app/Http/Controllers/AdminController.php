<?php

namespace App\Http\Controllers;

use App\Models\Place;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view(Place $place)
    {
        $list = $place->list();
        $auths = $place->getAuth();
        return view('admin.view', compact('list', 'auths'));
    }
}
