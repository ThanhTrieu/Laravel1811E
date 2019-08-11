@extends('frontend.layout')

@section('title', $keyword . ' - blog')


@section('content')
<section class="site-section pt-5">
<div class="container">
  <div class="row mb-4">
    <div class="col-md-12">
      <h2 class="mb-4">Keyword: {{ $keyword }}</h2>
    </div>
  </div>
  <div class="row blog-entries">
    <div class="col-md-12 col-lg-12 main-content">
      <div class="row mb-5 mt-5">
        <div class="col-md-12">
        @foreach($lstSearch as $key => $post)
          <div class="post-entry-horzontal">
            <a href="{{ route('fr.detail',['slug'=>$post['slug'],'id' => $post['id']]) }}">
              <div class="image element-animate" data-animate-effect="fadeIn" style="background-image: url({{ URL::to('/') }}/upload/images/{{ $post['avatar'] }});"></div>
              <span class="text">
                <div class="post-meta">
                  <span class="author mr-2"> {{ $post['username'] }} </span>&bullet;
                  <span class="mr-2"> {{ $post['publish_date'] }} </span> &bullet;
                </div>
                <h2>{!! $post['title'] !!}</h2>
              </span>
            </a>
          </div>
		@endforeach
        </div>
      </div>

      <div class="row mt-5">
        <div class="col-md-12 text-center">
          {{ $paginate->appends(request()->query())->links() }}
        </div>
      </div>
    </div>
    <!-- END main-content -->
  </div>
</div>
</section>
@endsection
