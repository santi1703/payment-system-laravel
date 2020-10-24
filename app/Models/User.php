<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use GuzzleHttp\Client;
use function PHPUnit\Framework\isNull;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Geolocations()
    {
        return $this->hasMany('App\Models\Geolocation');
    }

    private function parseLocation()
    {
        return $this->Geolocations()
            ->select(['lat', 'lon'])
            ->orderBy('id', 'desc')
            ->first();
    }

    private function getLastKnownLocation()
    {
        $location = $this->parseLocation();
        $data = [];
        if(!empty($location)) {
            $url = "https://apis.datos.gob.ar/georef/api/ubicacion?lat=$location->lat&lon=$location->lon";
            $client = new Client();
            $data = json_decode($client->get($url)->getBody()->getContents(), true);
        }

        return $data;
    }

    public function getLastKnownProvince()
    {
        $provinceName = 'Desconocida';
        $locationData = $this->getLastKnownLocation();
        if(!empty($locationData)) {
            $provinceName = $locationData['ubicacion']['provincia']['nombre'];
        }
        return $provinceName;
    }

    public function Teams()
    {
        return $this->belongsToMany('App\Models\Team')->withPivot('responsable');
    }

    public function ownedTeams()
    {
        return $this->teams()->wherePivot('responsable', true)->get();
    }

    public function getOwnedTeamsDuePayments()
    {
        $totals = [];
        foreach($this->ownedTeams() as $team)
        {
            $totals[$team->name] = $team->getSubscriptionsTotals();
        }

        return collect($totals);
    }

    public function getFullNameAttribute()
    {
        return ucwords($this->first_name . ' ' . $this->last_name);
    }
}
