<!DOCTYPE html>
<html>
<head>
</head>
<body>

<p>Dear {{ $user->name }},</p>

<p>Thank you for buying the following item:</p>

<table cellspacing="0" cellpadding="0" border="1" width="100%" style="max-width: 800px;">
<tr>
    <th width="30%">Item Name</th>
	<td width="70%">{{ $wishlistitem->name }}</td>
<tr>
<tr>
    <th>Description</th>
	<td>{{ $wishlistitem->description }}</td>
<tr>
<tr>
    <th>Price</th>
	<td>{{ number_format($wishlistitem->price, 2) }} {{ $wishlistitem->currency }}</td>
<tr>
<tr>
    <th>Image</th>
    @if( is_null($wishlistitem->image) )
    <td></td>
    @else
    <td><img src="{{ url('/storage', $wishlistitem->image) }}" alt="" style="max-width: 400px;"></td>
    @endif
<tr>
<tr>
    <th>URL</th>
	<td>{{ $wishlistitem->url }}</td>
<tr>
</table>

</body>
</html>