<?php

namespace App\Models;

use Database\Factories\CitizenFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{
    /** @use HasFactory<CitizenFactory> */
    use HasFactory;

    protected $fillable = [
        'nik',
        'name',
        'wife_name',
        'house_number',
        'marital_status',
        'children_count',
        'monthly_income',
        'income_range',
        'financial_status',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'children_count' => 'integer',
            'monthly_income' => 'decimal:2',
        ];
    }
}
