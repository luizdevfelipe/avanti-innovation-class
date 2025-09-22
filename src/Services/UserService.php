<?php 

namespace App\Services;

use App\models\UserModel;

class UserService
{
    public function getUserDataByEmail(string $email): ?array
    {
        return UserModel::where('email', $email);
    }
}