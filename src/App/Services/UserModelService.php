<?php
declare(strict_types=1);

namespace Src\App\Services;

use Core\Models\Model;
use Core\Services\ModelService;
use Src\App\Models\User;

class UserModelService implements ModelService
{

    /**
     * @var User
     */
    private $user;

    public function setModel(Model $model): ModelService
    {
        $this->user = $model;
        return $this;
    }

    /**
     * @return null|string
     */
    public function formatDate(): ?string
    {
        if (($date = $this->user->getDate()) == null) {
            return null;
        }
        return date('d.m.Y', $date->getTimestamp());
    }

}