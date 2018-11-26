<aside id="menubar" class="menubar light">
  <div class="app-user">
    <div class="media">
      <div class="media-left">
        <div class="avatar avatar-md avatar-circle">
          <a href="javascript:void(0)"><img class="img-responsive" src="theme/backend/assets/images/221.jpg" alt="avatar"/></a>
        </div><!-- .avatar -->
      </div>
      <div class="media-body">
        <div class="foldable">
          <h5><a href="javascript:void(0)" class="username">John Doe</a></h5>
          <ul>
            <li class="dropdown">
              <a href="javascript:void(0)" class="dropdown-toggle usertitle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <small>Web Developer</small>
              </a>
              
            </li>
          </ul>
        </div>
      </div><!-- .media-body -->
    </div><!-- .media -->
  </div><!-- .app-user -->
@php
    $url=Request::path();
@endphp
  <div class="menubar-scroll">
    <div class="menubar-scroll-inner">
      <ul class="app-menu">
        <li class="has-submenu">
          <a href="{{url('dashboard')}}" class="submenu-toggle">
            <i class="menu-icon zmdi zmdi-view-dashboard zmdi-hc-lg"></i>
            <span class="menu-text">Dashboards</span>
          </a>
        </li>
        <li class="has-submenu {{$url=='data-opd' || $url=='kepala-opd' ? 'active open' : ''}}">
          <a href="javascript:void(0)" class="submenu-toggle">
            <i class="menu-icon fa fa-archive"></i>
            <span class="menu-text">Master OPD</span>
            <i class="menu-caret zmdi zmdi-hc-sm zmdi-chevron-right"></i>
          </a>
          <ul class="submenu" style="{{$url=='data-opd' || $url=='kepala-opd' ? 'display:block' : ''}}">
            <li class="{{$url=='data-opd' ? 'active' : ''}}"><a href="{{url('data-opd')}}"><span class="menu-text">Data OPD</span></a></li>
            <li class="{{$url=='kepala-opd' ? 'active' : ''}}"><a href="{{url('kepala-opd')}}"><span class="menu-text">Kepala OPD</span></a></li>
          </ul>
        </li>
        <li class="has-submenu {{$url=='data-temuan' || $url=='data-penyebab' || $url=='data-rekomendasi' || $url=='bidang-pengawasan' ? 'active open' : ''}}">
          <a href="javascript:void(0)" class="submenu-toggle">
            <i class="menu-icon fa fa-bars"></i>
            <span class="menu-text">Master Data</span>
            <i class="menu-caret zmdi zmdi-hc-sm zmdi-chevron-right"></i>
          </a>
          <ul class="submenu" style="{{$url=='data-temuan' || $url=='data-penyebab' || $url=='data-rekomendasi' || $url=='bidang-pengawasan' ? 'display:block' : ''}}">
            <li class="{{$url=='data-temuan'  ? 'active open' : ''}}"><a href="{{url('data-temuan')}}"><span class="menu-text">Data Temuan</span></a></li>
            <li class="{{$url=='data-penyebab' ? 'active open' : ''}}"><a href="{{url('data-penyebab')}}"><span class="menu-text">Data Penyebab</span></a></li>
            <li class="{{$url=='data-rekomendasi' ? 'active open' : ''}}"><a href="{{url('data-rekomendasi')}}"><span class="menu-text">Data Rekomendasi</span></a></li>
            <li class="{{$url=='bidang-pengawasan' ? 'active open' : ''}}"><a href="{{url('bidang-pengawasan')}}"><span class="menu-text">Bidang Pengawasan</span></a></li>
          </ul>
        </li>
        <li class="has-submenu {{$url=='users' ? 'active open' : ''}}">
          <a href="{{url('users')}}">
            <i class="menu-icon fa fa-users"></i>
            <span class="menu-text">Data User</span>
          </a>
        </li>
        <li class="{{$url=='list-temuan' ? 'active' : ''}}">
          <a href="{{url('list-temuan')}}">
            <i class="menu-icon fa fa-archive"></i>
            <span class="menu-text">Daftar Temuan</span>
          </a>
        </li>
        <li class="menu-separator"><hr></li>

        <li>
          <a href="{{url('logout')}}">
            <i class="menu-icon fa fa-sign-out"></i>
            <span class="menu-text">Logout</span>
          </a>
        </li>
      </ul><!-- .app-menu -->
    </div><!-- .menubar-scroll-inner -->
  </div><!-- .menubar-scroll -->
</aside>