<?php

namespace App\Http\Controllers;

use App\Place;

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
        $list = $place->getList();
        return view('admin.view', compact('list'));
    }
}
