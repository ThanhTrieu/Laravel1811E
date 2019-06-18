<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>demo view laravel</title>
	<link rel="stylesheet" href="">
</head>
<body>

	{{-- comment cua blade laravel --}}

	<form action="{{ route('handleLogin') }}" method="post">
		{{-- bat buoc them csrf vi method khong phai la get --}}
		@csrf
		<label for="user"> User </label>
		<input type="text" name="user" id="user">
		<br><br>
		<label for="pass"> Pass </label>
		<input type="text" name="pass" id="pass">
		<br><br>
		<button type="submit"> Login</button>
	</form>
</body>
</html>