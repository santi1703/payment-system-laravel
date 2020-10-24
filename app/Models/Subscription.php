<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    private $prices = [50, 45, 40, 35];

    public function getNiceNameAttribute()
    {
        return ucwords($this->name);
    }

    public function getPrice(Team $team)
    {
        $teamSize = $team->users->count();

        for ($i = 0; $i < count($this->prices); $i++) {
            $upperBound = pow(10, $i + 1);
            $total = $teamSize * $this->prices[$i];
            if ($teamSize < $upperBound) {
                break;
            }
        }

        return $total;
    }
}
