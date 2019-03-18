<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wishlist;
use App\WishlistItem;

class ShareWishlistController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  uuid  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        //
        $wishlist = Wishlist::where('uuid', $uuid)->first();

        return view('share');
    }

    public function showWishlistDetails($uuid)
    {
        $wishlist = Wishlist::where('uuid', $uuid)->first();
        $wishlistitems = $wishlist->items;
    
        return response()->json([
            'wishlistitems'  => $wishlistitems,
            'wishlist_id' => $wishlist->id,
            'wishlist_name' => $wishlist->name,
            'message'   => 'Success'
        ], 200);
    }
    
}
