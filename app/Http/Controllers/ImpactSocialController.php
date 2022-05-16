<?php

namespace App\Http\Controllers;

use App\Interfaces\ImpactSocialRepositoryInterface;
use Illuminate\Http\Request;
//use Illuminate\Http\JsonResponse;

class ImpactSocialController extends Controller
{
    private ImpactSocialRepositoryInterface $impactSocialRepository;

    public function __construct(ImpactSocialRepositoryInterface $impactSocialRepository)
    {
        $this->impactSocialRepository = $impactSocialRepository;
    }

    public function show($slug)
    {
        return response()->json(
            $this->impactSocialRepository->getData($slug)
        );
    }
}
