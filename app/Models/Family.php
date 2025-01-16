<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    protected $table = 'family';

    protected $guarded = ['id'];

    protected $casts = [
        // 'date_of_birth' => 'date',
    ];

    public function personaldata()
    {
        return $this->belongsTo(PersonalData::class);
    }
}
