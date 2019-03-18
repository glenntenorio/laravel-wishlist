<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wishlist extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'name',
        'organizer_id',
        'uuid'
    ];

    public function items()
    {
        return $this->hasMany('App\WishlistItem');
    }

    public function organizer()
    {
        return $this->belongsTo('App\User', 'organizer_id');
    }
}
