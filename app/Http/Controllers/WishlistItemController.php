<?php

namespace App\Http\Controllers;

use App\WishlistItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class WishlistItemController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $wishlistitems = WishlistItem::all();

        return response()->json([
            'wishlistitems' => $wishlistitems,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $this->validate($request, [
            'wishlist_id'  => 'required|numeric',
            'name'  => 'required|max:255',
            'description'  => 'nullable|max:255',
            'price'  => 'numeric',
            'currency'  => 'required|max:20',
            'url'  => 'nullable|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:10240'
        ]);

        
        $wishlistitem = WishlistItem::create([
            'wishlist_id'      => request('wishlist_id'),
            'name'             => request('name'),
            'description'      => request('description'),
            'price'            => request('price'),
            'currency'         => request('currency'),
            'url'              => request('url')
        ]);

        if($request->hasFile('image')){
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            Storage::disk('public')->put($image->getFilename().'.'.$extension,  File::get($image));

            $wishlistitem->image = $image->getFilename().'.'.$extension;
            $wishlistitem->save();
        }
        
 
        return response()->json([
            'wishlistitem'  => $wishlistitem,
            'message'   => 'Success'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WishlistItem  $wishlistItem
     * @return \Illuminate\Http\Response
     */
    public function show(WishlistItem $wishlistItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WishlistItem  $wishlistItem
     * @return \Illuminate\Http\Response
     */
    public function edit(WishlistItem $wishlistItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WishlistItem  $wishlistItem
     * @return \Illuminate\Http\Response
     */
    //public function update(Request $request, WishlistItem $wishlistItem)
    public function update(Request $request, $id)
    {
        //        
        $this->validate($request, [
            'name'  => 'required|max:255',
            'description'  => 'nullable|max:255',
            'price'  => 'numeric',
            'currency'  => 'required|max:20',
            'url'  => 'nullable|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:10240'
        ]);

        $wishlistItem = WishlistItem::where('id', $id)->first();
 
        $wishlistItem->name = request('name');
        $wishlistItem->description = request('description');
        $wishlistItem->price = request('price');
        $wishlistItem->currency = request('currency');
        $wishlistItem->url = request('url');

        if($request->hasFile('image')){
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            Storage::disk('public')->put($image->getFilename().'.'.$extension,  File::get($image));

            $wishlistItem->image = $image->getFilename().'.'.$extension;
            $wishlistItem->save();

        }

        $wishlistItem->save();
 
        return response()->json([
            'wishlistitem' => $wishlistItem,
            'message'   => 'Wishlist item updated successfully!'
        ], 200);

        // return response()->json([
        //     'message'   => 'Wishlist item updated successfully!'
        // ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WishlistItem  $wishlistItem
     * @return \Illuminate\Http\Response
     */
    //public function destroy(WishlistItem $wishlistItem)
    public function destroy($id)
    {
        //
        WishlistItem::where('id', $id)->delete();

        return response()->json([
            'message'   => 'Wishlist item deleted successfully!'
        ], 200);
    }
}
