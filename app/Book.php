<?php

namespace App;

use http\Exception;
use Illuminate\Database\Eloquent\Model;
use App\Entities\Reservations;

class Book extends Model
{
    use Reservations;

    protected $guarded = [];
    public function setAuthorIdAttribute($author)
    {
        $this->attributes['author_id'] = (Author::firstOrCreate([
            'name' => $author['name'],
            'dob' => $author['dob']
        ]))->id;
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
