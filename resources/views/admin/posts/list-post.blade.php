@extends('admin.master')

@section('title', 'list posts')
@section('content')
<div class="row">
	<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
		<h5>Danh sach bai viet</h5>
		<a href="{{ route('admin.createPost') }}" class="btn btn-primary">Dang tin - viet bai</a>
	</div>
</div>
@endsection