@extends('test-layout')

@push('stylesheets')
<link rel="stylesheet" href="{{ asset('css/test.css') }}">
@endpush

{{-- nhung file test.js vao day --}}
{{-- nhung se duoc day ra ngoai test-layout.blade --}}
@push('scripts')
<script type="text/javascript" src="{{ asset('js/test.js') }}"></script>
@endpush

@section('content')
<div class="row py-5 bg-info">
	<div class="col-lg-12 col-xl-12">
		<h3>This is content</h3>
		{{-- <p>Name : {{ $name }}</p>
		<p>Phone : {{ $phone }}</p> --}}
		<table class="table my-3">
			<thead>
				<tr>
					<th>#</th>
					<th>MSV</th>
					<th>HT</th>
					<th>Tuoi</th>
					<th>SDT</th>
					<th>GT</th>
					<th>Hoc Bong</th>
					<th colspan="2" width="3%">Action</th>
				</tr>
			</thead>
			<tbody>
				@php
					// khai bao bien php o day
					$totalMoney = 0;
				@endphp

				@foreach($lstInfoStudent as $key => $item)
					@php
						$totalMoney += $item['money'];
					@endphp
					<tr>
						<td>{{ $key + 1 }}</td>
						<td>{{ $item['msv'] }}</td>
						<td>{{ $item['name'] }}</td>
						<td>{{ $item['age'] }}</td>
						<td>{{ $item['phone'] }}</td>
						<td>{{ $item['gender'] == 0 ? 'Nu' : 'Nam' }}</td>
						<td>{{ number_format($item['money']) }}</td>
						<td>
							<a href="#" class="btn btn-primary"> Edit</a>
						</td>
						<td>
							<a href="#" class="btn btn-danger"> Delete</a>
						</td>
					</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td colspan="6">Hoc bong</td>
					<td colspan="2"> {{ number_format($totalMoney) }}</td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
@endsection