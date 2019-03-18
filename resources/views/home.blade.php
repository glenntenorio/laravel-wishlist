@extends('layouts.app')

@section('content')
@if(auth()->user()->role == \App\User::USER_ROLE_ORGANIZER)
<wishlist></wishlist>
@else
<wishlistinvitee></wishlistinvitee>
@endif
@endsection
