<?php

namespace App\Http\Controllers;

use App\Interfaces\ImpactSocialRepositoryInterface;
use Illuminate\Http\Request;

class ImpactSocialController extends Controller
{
    private ImpactSocialRepositoryInterface $impactSocialRepository;

    public function __construct(ImpactSocialRepositoryInterface $impactSocialRepository)
    {
        $this->impactSocialRepository = $impactSocialRepository;
    }

    public function show($slug)
    {
        // Tous les champs
        $place = $this->impactSocialRepository->get($slug);

        // Uniquement la colonne `data`
        //$place = $this->impactSocialRepository->getData($slug);

        return view('impactsocial.show', compact('place'));
    }

    public function update(Request $request, $slug)
    {
        $place = $this->impactSocialRepository->get($slug);
        $data = $place->data;
        $data->impact->solidarite = $request->get('solidarite', 'lorem ipsum');
        $place->data = $data;
        $place->save();

        return redirect(route('impacts.show', compact('slug')));
    }
}
