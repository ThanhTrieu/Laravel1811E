@extends('admin.master')

@section('title', 'create posts')

@push('styles')
<link href="{{ asset('admin/css/multiple-select.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script type="text/javascript" src="{{ asset('admin/js/multiple-select.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/js/posts.js') }}"></script>
@endpush

@section('content')
<style type="text/css">
	#tags{
		width: 260px;
	}
</style>

<div class="row">
	<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
		<h5>Chinh sua bai viet</h5>
		
{{-- 		@if ($errors->any())
		    <div class="alert alert-danger my-3">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif --}}

		<form action="" method="post" class="mt-3 w-100" enctype="multipart/form-data">
			@csrf
			<div class="row">
				<div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9">
					<div class="form-group">
						<label for="titlePost"> Title</label>
						<input type="text" class="form-control" name="titlePost" id="titlePost" value="{{ $post->title }}">
					</div>
					<div class="form-group">
						<label for="sapoPost"> Sapo</label>
						<textarea class="form-control" name="sapoPost" id="sapoPost">{!! $post->sapo !!}</textarea>
					</div>
					<div class="form-group">
						<label for="avatarPost"> Avatar</label>
						<input type="file" class="form-control" name="avatarPost" id="avatarPost">
					</div>
					<div class="form-group">
						<label for="contentPost"> Content</label>
						<textarea class="form-control" name="contentPost" id="contentPost" rows="10">{!! $post->content_web !!}</textarea>
					</div>
				</div>
				<div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
					<div class="form-group">
						<label for="language">Language</label>
						<select name="language" id="language" class="form-control">
							<option value="1" {{ $post->lang_id == 1 ? 'selected=selected' : '' }} >Tieng Viet</option>
							<option value="0" {{ $post->lang_id == 0 ? 'selected=selected' : '' }}>Tieng Anh</option>
						</select>
					</div>
					<div class="form-group">
						<label for="categories">Categories</label>
						<select class="form-control" name="categories" id="categories">
							<option value="">-- choose Category --</option>
							@foreach($cate as $key => $items)
								<option value="{{ $items['id'] }}" {{ $post->categories_id == $items['id'] ? 'selected=selected' : '' }}>{{ $items['name'] }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="avatar">Avatar</label>
						<img src="{{ URL::to('/') }}/upload/images/{{ $post->avatar }}" alt="avatar" class="w-100">
					</div>
					<div class="form-group">
						<label for="tags">Tags</label>
						<select name="tags[]" id="tags" multiple="multiple">
							@foreach($tags as $key => $items)
								<option value="{{ $items['id'] }}" {{ in_array($items['id'], $post_tag2) ? 'selected=selected' : '' }}>
									{{ $items['name'] }}
								</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label> <b>Publish</b> </label>
						<input type="checkbox" class="ml-3" checked="checked" name="publishPost">
					</div>
					<button class="btn btn-primary" type="submit"> Save</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection