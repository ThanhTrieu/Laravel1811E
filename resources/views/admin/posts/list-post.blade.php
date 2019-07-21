@extends('admin.master')

@section('title', 'list posts')
@section('content')
<div class="row">
	<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
		<h4 class="text-left mb-3">Danh sach bai viet</h4>
		<div class="row">
			<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
				<a href="{{ route('admin.createPost') }}" class="btn btn-primary">Dang tin - viet bai</a>
			</div>
			<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
				<button type="button" class="btn-primary btn float-right" id="btnSearch"> Tim kiem</button>
				<input type="text" id="txtKeyword" class="w-75 h-100 float-right" placeholder="tim kiem bai viet ..." value="{{ $keyword }}">
				
			</div>
		</div>
		<div class="clearfix"></div>

		<table class="table mt-3">
			<thead>
				<tr>
					<th>Id</th>
					<th>Title</th>
					<th>Category</th>
					<th>Publish date</th>
					<th colspan="2" width="5%">Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($listPosts as $key => $post)
				<tr>
					<td>{{ $post['id'] }}</td>
					<td>
						<h5>{{ $post['title'] }}</h5>
						<p>{!! $post['sapo'] !!}</p>
					</td>
					<td>{{ $post['name'] }}</td>
					<td>{{ $post['publish_date'] }}</td>
					<td>
						<a href="{{ route('admin.editPost',['slug' => $post['slug'], 'id' => $post['id']]) }}" class="btn btn-info">Edit</a>
					</td>
					<td>
						<button onclick="deletePost({{ $post['id'] }})" class="btn btn-danger">Del</button>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		<div class="row justify-content-center border-top py-3">
			{{-- hien thi phan trang voi teamplate la bootstrap --}}
			{{-- phan trang + tim kiem --}}
			{{-- appends them nhung param query string vao phan trang --}}
			{{ $paginate->appends(request()->query())->links() }}
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
	$(function(){
		$('#btnSearch').click(function() {
			let keyword = $('#txtKeyword').val().trim();
			if(keyword.length > 0){
				window.location.href = "{{ route('admin.listPosts') }}" + "?keyword=" + keyword;
			}
		});
	});

	function deletePost(idPost){
		if(Number.isInteger(idPost)){
			$.ajax({
				url: "{{ route('admin.deletePost') }}",
				type: "post",
				data: {id: idPost},
				success: function(data){
					data = $.trim(data);
					if(data === 'FAIL' || data === 'ERR'){
						alert('Xoa khong thanh cong');
					} else if (data === 'OK') {
						alert('Xoa thanh cong');
						window.location.reload(true);
					}
					return false;
				}
			});
		}
	}
</script>
@endpush





