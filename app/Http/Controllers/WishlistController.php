<?php

namespace App\Http\Controllers;

use App\Wishlist;
use App\WishlistItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

class WishlistController extends Controller
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
        $wishlists = Wishlist::where('organizer_id', Auth::user()->id)->get();

        return response()->json([
            'wishlists' => $wishlists,
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
            'name'  => 'required|max:255',
        ]);
 
        $wishlist = Wishlist::create([
            'name'              => request('name'),
            'organizer_id'      => Auth::user()->id,
            'uuid'              => (string)Uuid::generate()
        ]);
 
        return response()->json([
            'wishlist'  => $wishlist,
            'message'   => 'Success'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function show(Wishlist $wishlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Wishlist $wishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        //
        $this->validate($request, [
            'name'  => 'required|max:255',
        ]);
 
        $wishlist->name = request('name');

        $wishlist->save();
 
        return response()->json([
            'message'   => 'Wishlist updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wishlist $wishlist)
    {
        //
        $wishlist->delete();

        return response()->json([
            'message'   => 'Wishlist deleted successfully!'
        ], 200);
    }

    public function getItemsView($id){
        $auth_user = Auth::user();

        return view('wishlistitems', compact('id', 'auth_user'));
    }

    public function getItems($id){

        $wishlistitems = WishlistItem::where('wishlist_id', $id)->get();

        return response()->json([
            'wishlistitems'  => $wishlistitems,
            'wishlist_id' => $id,
            'message'   => 'Success'
        ], 200);
    }
}
