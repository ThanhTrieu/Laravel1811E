<div class="sidebar-box">
  <h3 class="heading">@lang('common.tags')</h3>
  <ul class="tags">
    @foreach($info['listTag'] as $key => $item)
        <li><a href="#">{{ $item['name'] }}</a></li>
    @endforeach
  </ul>
</div>