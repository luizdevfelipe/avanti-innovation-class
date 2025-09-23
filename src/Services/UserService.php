<?php 

namespace App\Services;

use App\models\UserModel;

class UserService
{
    public function getUserDataByEmail(string $email): ?array
    {
        return UserModel::select()->where('email', $email)->first();
    }
}