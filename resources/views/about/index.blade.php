@extends('test-layout')

@section('content')
<div class="row py-5 bg-info">
	<div class="col-xl-12 col-lg-12">
		<h3>This is about</h3>
		<p>Myage {{ $myage }}</p>
	</div>
</div>
@endsection