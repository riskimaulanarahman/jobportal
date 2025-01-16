<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SideMenu extends Model
{
    use HasFactory;

    protected $table = 'side_menus';
    
    protected $guarded = ['id'];

    protected $casts = [
        'icon_id' => 'integer',
        'parent_id' => 'integer',
        'modules' => 'integer',
        'sequence_id' => 'integer',
        'is_active' => 'boolean',
        'is_admin' => 'boolean',
        'is_parent' => 'boolean',
        'is_secondary_menu' => 'boolean',
        'must_full_title' => 'boolean',
    ];
}