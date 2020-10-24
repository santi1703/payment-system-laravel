<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;

class Team extends Model
{
    public function Users()
    {
        return $this->belongsToMany('App\Models\User');
    }

    public function owner()
    {
        return $this->users()->where('responsable', '=', 1);
    }

    public function members()
    {
        return $this->users()->where('responsable', '<>', 1);
    }

    public function Invoices()
    {
        return $this->hasManyThrough('App\Models\Invoice', 'App\Models\SubscriptionTeam');
    }

    public function Subscriptions()
    {
        return $this->belongsToMany('App\Models\Subscription');
    }

    public function getNiceNameAttribute()
    {
        return ucwords($this->name);
    }

    public function getSubscriptionsTotals()
    {
        $totals = [];

        foreach ($this->subscriptions as $subscription) {
            $totals[$subscription->name] = $subscription->getPrice($this);
        }

        return collect($totals);
    }

    public function createInvoices()
    {
        $subscriptions = $this->subscriptions()->withPivot(['id'])->get();
        foreach ($subscriptions as $subscription) {
            $price = $subscription->getPrice($this);
            $totals[$subscription->name] = $price;

            $invoice = Invoice::create([
                    'created_on' => Carbon::now(),
                    'amount' => $price,
                    'subscription_team_id' => $subscription->pivot->id,
                    'subscription' => $subscription->niceName,
                ]
            );
        }
    }
}
