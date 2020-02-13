<?php


namespace App\Repository;


use App\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    public function findWithAccounts(int $id) :array
    {
        $user =  User::find($id);

        if (null == $user) {
            throw new \DomainException('User not found');
        }

        $accounts = [];
        $accounts['consumer'] = $user->consumer ?? [];
        $accounts['seller'] = $user->seller ?? [];

        unset($user['consumer']);
        unset($user['seller']);

        return [
            'accounts' => $accounts,
            'user' => $user
        ];
    }

    public function save(array $data) :User
    {
        return User::create($data);
    }

    public function findAll() :Collection
    {
        return User::all();
    }

    public function findByName($name) :Collection
    {
        $conditions = ['full_name', 'like', $name . '%'];

        return User::where([$conditions])->get();
    }
}