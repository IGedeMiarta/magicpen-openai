<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AfilieteDistibutes extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'afiliate_distibutes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    
}
