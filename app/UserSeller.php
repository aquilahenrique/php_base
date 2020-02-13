<?php


namespace App;

use Illuminate\Database\Eloquent\Model;


class UserSeller extends Model
{
    protected $table = 'users_sellers';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cnpj', 'fantasy_name', 'social_name', 'user_id', 'username'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}