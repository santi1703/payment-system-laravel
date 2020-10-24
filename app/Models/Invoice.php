<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['created_on', 'amount', 'subscription_team_id', 'subscription'];

    public function getNiceAmountAttribute()
    {
        return "$" . $this->amount;
    }

    public function getStatusAttribute()
    {
        return is_null($this->paid_on)?"Impago":"Pagado";
    }
}
