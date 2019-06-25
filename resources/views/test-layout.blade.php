<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>demo master layout view blade</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	{{-- se doi cho cac ma css dc dinh nghia o cac file template con se duoc day ra ngoai nay --}}

	@stack('stylesheets')
	
</head>
<body>
	<div class="container">

		@include('partials.header')

		@include('partials.navbar')

		@yield('content')
		
		@include('partials.footer')

		{{-- se doi cho cac ma js dc dinh nghia o cac file template con se duoc day ra ngoai nay --}}
		<script type="text/javascript" src="{{ asset('js/demo.js') }}"></script>
		@stack('scripts')
	</div>
</body>
</html>