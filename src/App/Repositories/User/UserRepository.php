<?php
declare(strict_types=1);

namespace Src\App\Repositories\User;

use Src\App\Models\Repository\User\UserRepository as Repository;
use Src\App\Repositories\Storage;

class UserRepository implements Repository
{

    use Storage;

    public function get($id)
    {
        return 'check ' . $id;
    }

}