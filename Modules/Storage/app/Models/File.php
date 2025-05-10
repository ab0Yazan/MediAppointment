<?php

namespace Modules\Storage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kalnoy\Nestedset\NodeTrait;

// use Modules\Storage\Database\Factories\FileFactory;

class File extends Model
{
    use HasFactory, NodeTrait;

    protected $fillable = ['name', 'is_folder', 'path'];

    protected $casts = [
        'is_folder' => 'boolean',
    ];

}
