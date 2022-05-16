<?php

namespace App\Repositories;

use App\Interfaces\ImpactSocialRepositoryInterface;
use App\Models\ImpactSocial;

class ImpactSocialRepository implements ImpactSocialRepositoryInterface
{
    public function getAll()
    {
        return ImpactSocial::where('type_donnees', ImpactSocial::TYPE_DONNEES_IMPACT)->get();
    }

    public function get(string $slug)
    {
        return ImpactSocial::where('type_donnees', ImpactSocial::TYPE_DONNEES_IMPACT)->findOrFail($slug);
    }

    public function getData(string $slug)
    {
        return self::get($slug)->data;
    }

    public function delete(string $slug) {}

    public function update(string $slug, array $params) {}
}
