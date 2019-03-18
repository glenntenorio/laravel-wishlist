<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wishlist;
use App\WishlistItem;

class InviteeWishlistController extends Controller
{
    //
    public function wishlists(){
        $wishlists = Wishlist::all();

        return response()->json([
            'wishlists' => $wishlists,
        ], 200);
    }

    public function getItemsView($id){
        return view('invitee.wishlistitems', compact('id'));
    }

    public function getItems($id){

        $wishlistitems = WishlistItem::where('wishlist_id', $id)->get();

        return response()->json([
            'wishlistitems'  => $wishlistitems,
            'wishlist_id' => $id,
            'message'   => 'Success'
        ], 200);
    }

    public function buyItem(Request $request){
        $item = $request->item;

        $wishlistitem = WishlistItem::where('id', $item['id'])->first();
        $wishlistitem->bought = true;
        $wishlistitem->save();

        $mail_subject = 'Thank you for buying';


        \Mail::to(auth()->user())
                ->send( new \App\Mail\WishlistItemBoughtMail( auth()->user(), $wishlistitem, $mail_subject ));
                

        return response()->json([
            'message'   => 'Success'
        ], 200);
    }

    public function buyItems(Request $request){
        $items = $request->items;

        $wishlistitems = WishlistItem::whereIn('id', $items)->get();
        
        foreach($wishlistitems as $wishlistitem)
        {
            $wishlistitem->bought = true;
            //$wishlistitem->save();
        }
        
        $mail_subject = 'Thank you for buying';


        \Mail::to(auth()->user())
                ->send( new \App\Mail\WishlistItemsBoughtMail( auth()->user(), $wishlistitems, $mail_subject ));
                

        return response()->json([
            'message'   => 'Success'
        ], 200);
    }
}
