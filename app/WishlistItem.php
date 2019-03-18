<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WishlistItem extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'name',
        'wishlist_id',
        'description',
        'price',
        'currency',
        'image',
        'url',
        'bought',
        'bought_by_user_id'
    ];

    public function wishlist()
    {
        return $this->belongsTo('App\Wishlist');
    }

    public function bought_by_user()
    {
        return $this->belongsTo('App\User', 'bought_by_user_id');
    }
}
