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
}
