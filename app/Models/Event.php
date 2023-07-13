<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\EventDetails;

class Event extends Model
{
    use HasFactory;
    protected $table ='events';

    protected $fillable = [
        'name',
        'shortcut',
        'city',
        'street',
        'zip_code',
        'no_building',
        'no_room',
        'location_shortcut',
        'description',
        'date_start',
        'date_end',
        'date_start_rek',
        'date_end_rek',
        'date_start_publi',
        'date_end_publi',
        'statuses_id',
    ];
    public function status()
    {
        return $this->belongsTo(EventStatus::class, 'statuses_id');
    }
    public function info()
    {
        return $this->hasMany (EventDetails::class, 'events_id');
    }


}
