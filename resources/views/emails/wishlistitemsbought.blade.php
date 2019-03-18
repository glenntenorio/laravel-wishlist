<!DOCTYPE html>
<html>
<head>
</head>
<body>

<p>Dear {{ $user->name }},</p>

<p>Thank you for buying the following items:</p>

<table cellspacing="0" cellpadding="0" border="1" width="100%" style="max-width: 800px;">
<tr>
    <th>Item Name</th>
    <th>Description</th>
    <th>Price</th>
    <th>Image</th>
    <th>URL</th>
</tr>
@foreach($wishlistitems as $wishlistitem)
<tr>
    <td>{{ $wishlistitem->name }}</td>
    <td>{{ $wishlistitem->description }}</td>
    <td>{{ number_format($wishlistitem->price, 2) }} {{ $wishlistitem->currency }}</td>
    
    @if( is_null($wishlistitem->image) )
    <td></td>
    @else
    <td><img src="{{ url('/storage', $wishlistitem->image) }}" alt="" style="max-width: 400px;"></td>
    @endif

    @if( is_null($wishlistitem->image) )
    <td><a href="{{ $wishlistitem->url }}">{{ $wishlistitem->url }}</a></td>
    @else
    <td></td>
    @endif
    
</tr>
@endforeach

</table>

</body>
</html>