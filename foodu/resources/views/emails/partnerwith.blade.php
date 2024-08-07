<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
</head>
<body>
	
		<p>Name :<span>{{ $name }}</span></p>

		<p>Shop Name :<span>{{ $shop_name }}</span></p>

		<p>Address :<span>{{ $address }}</span></p>

		<p>Contact Numbe :<span>{{ $contact_number }}</span></p>
		
		@if(isset($email))
		<p>Email<span>{{ $email }}</span></p>
		@endif

		<p>Categories<span>{{ $category }}</span></p>		
</body>
</html>