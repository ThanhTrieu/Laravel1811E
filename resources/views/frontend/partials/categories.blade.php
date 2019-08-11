<div class="sidebar-box">
  <h3 class="heading">@lang('common.catergory')</h3>
  <ul class="categories">
  	@foreach($info['listCate'] as $key => $cate)
    <li><a href="#">{{ $cate->name }} <span> {{ $cate->posts->count() }} </span></a></li>
    @endforeach
  </ul>
</div>
<!-- END sidebar-box -->