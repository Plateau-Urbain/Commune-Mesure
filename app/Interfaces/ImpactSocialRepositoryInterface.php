<?php

namespace App\Interfaces;

interface ImpactSocialRepositoryInterface
{
    public function getAll();
    public function get(string $slug);
    public function getData(string $slug);
    public function delete(string $slug);
    public function update(string $slug, array $params);
}
