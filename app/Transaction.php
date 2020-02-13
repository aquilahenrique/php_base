<?php


namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class Transaction extends Model
{
    public $timestamps = false;

    protected $casts = [
        'transaction_date' => 'datetime:Y-m-d\TH:i:s.u\Z'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payee_id', 'payer_id', 'value', 'transaction_date'
    ];
}