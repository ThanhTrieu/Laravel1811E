<div class="sidebar-box">
  <h3 class="heading">@lang('common.popularPosts')</h3>
  <div class="post-entry-sidebar">
    <ul>
    @foreach($info['popularPosts'] as $key => $item)
      <li>
        <a href="#">
          <img src="{{ URL::to('/') }}/upload/images/{{ $item['avatar'] }}" alt="Image placeholder" class="mr-4">
          <div class="text">
            <h4>{!! $item['title'] !!}</h4>
            <div class="post-meta">
              <span class="mr-2">{{ $item['publish_date'] }}</span>
            </div>
          </div>
        </a>
      </li>
    @endforeach
    </ul>
  </div>
</div>
<!-- END sidebar-box -->