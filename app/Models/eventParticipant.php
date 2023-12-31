<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\Event;

class eventParticipant extends Model
{
    use HasFactory;
    protected $table ='event_participants';
    protected $fillable = [
        'date_report',
        'date_approval',
        'date_confirmation',
        'number_of_people',
        'comments',
        'dictionary_schools_id',
        'participants_id',
        'events_id',
        'event_details_id',
    ];
    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participants_id');
    }
    
    public function eventDetails()
    {
        return $this->belongsTo(EventDetails::class, 'event_details_id');
    }
    
    public function eventParticipantLists()
    {
        return $this->hasMany(eventParticipantList::class, 'event_participants_id');
    }
    
}

