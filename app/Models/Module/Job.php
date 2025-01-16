<?php

namespace App\Models\Module;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_title',
        'code_job',
        'category',
        'contract_status',
        'location',
        'experience_years',
        'job_description',
        'skills_required',
    ];

    protected $casts = [
        'skills_required' => 'array', // Cast JSON to array
    ];
}
