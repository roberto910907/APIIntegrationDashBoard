<?php

namespace App\Services\Interfaces;

use Illuminate\Support\Collection;

interface ApiServiceInterface
{
    /**
     * @return Collection
     */
    public function getData(): Collection;
}
