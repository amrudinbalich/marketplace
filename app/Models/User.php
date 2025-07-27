<?php

namespace App\Models;

use Amrudinbalic\Marketplace\Database\Model;

class User extends Model
{
    protected string $table = 'users';

    /**
     * Search for the user row with name and password.
     * Use name as a search parameter (has UNIQUE constraint) and then upon finding the user -
     * compare input password with the hashed password in the database.
     * 
     * @param string $name
     * @param string $password
     * @return bool
     */
    public function authenticate(string $name, string $password): bool
    {
        $user = $this->where(['name' => $name]);

        if (!$user || !password_verify($password, $user['password'])) {
            return false;
        }

        $_SESSION['user'] = $user;

        return true;
    }

    /**
     * Fetch profile by ID for authenticated user or for a searched specific user.
     * 
     * @param int $id
     * @return array|bool
     */
    public function fetchProfile(int $id): array
    {
        return $this->where(['id' => $id]);
    }
}