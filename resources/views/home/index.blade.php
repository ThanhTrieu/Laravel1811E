@extends('test-layout')

@section('content')
<div class="row py-5 bg-info">
	<div class="col-lg-12 col-xl-12">
		<h3>This is content</h3>
		<p>Name : {{ $name }}</p>
		<p>Phone : {{ $phone }}</p>
	</div>
</div>
@endsection