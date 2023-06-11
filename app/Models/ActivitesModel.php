<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivitesModel extends Model
{
    use HasFactory;
    protected $fillable = ['titre' , 'description' , 'duree' , 'difficulte' , 'age_max'];
}
