<?php


namespace App\Repository;

use App\UserConsumer;

class UserConsumerRepository
{
    public function save(array $data) :UserConsumer
    {
        return UserConsumer::create($data);
    }
}