<ul class="sidebar-menu">
  <li class="header">Navigation</li>
  @php
    $nav = json_decode(File::get(base_path(config('saku.navigation'))));
  @endphp
  @foreach ($nav as $m)
    @if ($m->role == $role)
      <li id="{{$m->id}}" class="{{Help::set_active($role.'/'.$m->url)}}"><a href="{{Help::url($m->url)}}"><i class="fa {{$m->icon}}"></i> <span>{{$m->name}}</span></a></li>
    @endif
  @endforeach



  {{-- <li><a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a></li>
  <li class="treeview">
    <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="#">Link in level 2</a></li>
      <li><a href="#">Link in level 2</a></li>
    </ul>
  </li> --}}
</ul>
