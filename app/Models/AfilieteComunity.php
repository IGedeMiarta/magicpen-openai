<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AfilieteComunity extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'afiliete_comunity';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
}
