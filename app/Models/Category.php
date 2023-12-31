<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    public const FOOD = 1; // ALIMENTAÇÃO
    public const HEALTH = 2; // SAÚDE
    public const HOME = 3; // MORADIA
    public const TRANSPORT = 4; // TRANSPORTE
    public const EDUCATION = 5; // EDUCAÇÃO
    public const LEISURE = 6; // LAZER
    public const UNEXPECTED = 7; // IMPREVISTOS
    public const OTHERS = 8; // OUTRAS

    protected $fillable = [
        'name'
    ];
}
