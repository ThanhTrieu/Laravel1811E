@extends('frontend.layout')

@section('title', $detail['slug'] . '- blog')

@push('scripts')
<script type="text/javascript" async>
  $(function(){
    // tao ra 1 cai anh de thuc thi viec update count view
    var img = new Image(1,1);
    img.src = "{{ route('fr.viewCount',['id'=>$detail['id']]) }}";
  })
</script>
@endpush

@section('content')
<div>
  <img src="{{ URL::to('/') }}/upload/images/{{ $detail['avatar'] }}" alt="Image" class="img-fluid mb-5">

   <div class="post-meta">
      <span class="author mr-2">{{ $detail['username'] }}</span>&bullet;
      <span class="mr-2"> {{ $detail['publish_date'] }} </span> &bullet;
    </div>
  <h1 class="mb-4">{{ $detail['title'] }}</h1>
  <a class="category mb-5" href="#">{{ $detail['cate_name'] }}</a>
 
  <div class="post-content-body">
    {!! $detail['content_web'] !!}
  </div>

  
  <div class="pt-5">
    <p>Tags: 
      @php
        $tag = '';
      @endphp
      @foreach($tags as $tg)
        @php
          $tag .= ($tag == '') ? "<a href='#'>#".$tg['name_tag']."</a>" : ','."<a href='#'>#".$tg['name_tag']."</a>";
        @endphp
      @endforeach
      {!! $tag !!}
    </p>
  </div>
</div>
<section class="py-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mb-3 ">Related Post</h2>
      </div>
    </div>
    <div class="row">
      @foreach($relatedPosts as $key => $p)
      <div class="col-md-6 col-lg-4">
        <a href="{{ route('fr.detail',['slug'=>$p['slug'], 'id'=>$p['id']]) }}" class="a-block sm d-flex align-items-center height-md" style="background-image: url('{{ URL::to('/') }}/upload/images/{{ $p['avatar'] }}'); ">
          <div class="text">
            <div class="post-meta">
              <span class="category">{{ $p['name_cate'] }}</span>
              <span class="mr-2"> {{ $p['publish_date'] }} </span> &bullet;
            </div>
            <h3>{!! $p['title'] !!}</h3>
          </div>
        </a>
      </div>
      @endforeach
    </div>
  </div>
</section>
<div class="fb-comments my-3" data-width="100%" data-numposts="5"></div>
@endsection