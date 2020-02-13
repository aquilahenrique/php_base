<?php


namespace App\Repository;

use App\UserSeller;

class UserSellerRepository
{
    public function save(array $data) :UserSeller
    {
        return UserSeller::create($data);
    }
}