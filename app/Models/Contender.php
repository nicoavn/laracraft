<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int health
 * @property int attack
 * @property int defense
 * @property int speed
 */
class Contender extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'defense',
        'attack',
        'health',
        'speed',
    ];

    public function setHealthAttribute(int $value): void
    {
        if ($value < 0) {
            $this->attributes['health'] = 0;

            return;
        }
        $this->attributes['health'] = $value;
    }
}
