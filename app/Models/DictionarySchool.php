<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DictionarySchool extends Model
{
    use HasFactory;
    protected $table ='dictionary_schools';

    protected $fillable = [
        'name',
        'city',
        'street',
        'no_building',
        'zip_code',
        'dictionary_sources_id'
    ];
}
