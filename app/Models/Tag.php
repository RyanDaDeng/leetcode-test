<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property $name
 * @property Content[] $contents
 * Class Tag
 * @package App\Models
 */
class Tag extends Model
{
    use HasFactory;

    public function contents()
    {
        return $this->belongsToMany(Content::class);
    }
}
