<?php
declare(strict_types=1);

namespace Core\Services;

use Core\Models\Model;

interface ModelService
{
    public function setModel(Model $model): self;
}