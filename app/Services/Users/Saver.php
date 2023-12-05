<?php
namespace app\Services\Users;

use app\DTOs\Users\User;

interface Saver
{
    public function save(User $user);
}

