<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ Auth::user()->avatar }}" class="img-circle" alt="{{ Auth::user()->name }}">
      </div>
      <div class="pull-left info">
        <p>{{ Auth::user()->name }}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="{{ __('Tìm kiếm') }}">
        <span class="input-group-btn">
          <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
          </button>
        </span>
      </div>
    </form>
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">{{ __('Điều hướng') }}</li>
      <li data-module="home">
        <a href="{{ route('admin.index') }}">
          <i class="fa fa-dashboard"></i> <span>{{ __('Bảng điều khiển') }}</span>
          <span class="pull-right-container">
          </span>
        </a>
      </li>
      <li class="treeview" data-module="user">
        <a href="#">
          <i class="fa fa-users"></i>
          <span>{{ __('Thành viên') }}</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li data-function="index"><a href="{{ route('admin.user.index') }}"><i class="fa fa-circle-o"></i> {{ __('Danh sách thành viên') }}</a></li>
        </ul>
      </li>
      <li class="treeview" data-module="video">
        <a href="#">
          <i class="fa fa-youtube-play" aria-hidden="true"></i>
          <span>{{ __('Video') }}</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li data-function="index"><a href="{{ route('admin.video.index') }}"><i class="fa fa-circle-o"></i> {{ __('Danh sách video') }}</a></li>
          <li data-function="add"><a href="{{ route('admin.video.add') }}"><i class="fa fa-circle-o"></i> {{ __('Thêm mới video') }}</a></li>
        </ul>
      </li>
      <li class="treeview" data-module="playlist">
        <a href="#">
          <i class="fa fa-list-ul" aria-hidden="true"></i>
          <span>{{ __('Danh sách phát') }}</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li data-function="index"><a href="{{ route('admin.playlist.index') }}"><i class="fa fa-circle-o"></i> {{ __('Danh sách') }}</a></li>
          <li data-function="add"><a href="{{ route('admin.playlist.add') }}"><i class="fa fa-plus"></i> {{ __('Danh sách phát mới') }}</a></li>
        </ul>
      </li>
      <li class="treeview" data-module="category">
        <a href="#">
          <i class="fa fa-database" aria-hidden="true"></i>
          <span>{{ __('Danh mục') }}</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li data-function="index"><a href="{{ route('admin.category.index') }}"><i class="fa fa-circle-o"></i> {{ __('Danh sách') }}</a></li>
          <li data-function="add"><a href="{{ route('admin.category.add') }}"><i class="fa fa-plus"></i> {{ __('Danh mục mới') }}</a></li>
        </ul>
      </li>
      <li class="treeview" data-module="tag">
        <a href="#">
          <i class="fa fa-tags" aria-hidden="true"></i>
          <span>{{ __('Thẻ') }}</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li data-function="index"><a href="{{ route('admin.tag.index') }}"><i class="fa fa-circle-o"></i> {{ __('Danh sách') }}</a></li>
          <li data-function="add"><a href="{{ route('admin.tag.add') }}"><i class="fa fa-plus"></i> {{ __('Thẻ mới') }}</a></li>
        </ul>
      </li>
      <li class="treeview" data-module="language" hidden>
        <a href="#">
          <i class="fa fa-language" aria-hidden="true"></i>
          <span>{{ __('Ngôn ngữ') }}</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li data-function="index"><a href="{{ route('admin.language.index') }}"><i class="fa fa-circle-o"></i> {{ __('Danh sách') }}</a></li>
          <li data-function="add"><a href="{{ route('admin.language.add') }}"><i class="fa fa-plus"></i> {{ __('Thêm mới ngôn ngữ') }}</a></li>
          <li data-function="upload"><a href="{{ route('admin.language.upload') }}"><i class="fa fa-cloud-upload" aria-hidden="true"></i> {{ __('Tải lên tập tin ngôn ngữ') }}</a></li>
        </ul>
      </li>
      <li class="treeview" data-module="image">
        <a href="#">
          <i class="fa fa-picture-o" aria-hidden="true"></i>
          <span>{{ __('Hình ảnh') }}</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li data-function="index"><a href="{{ route('admin.image.index') }}"><i class="fa fa-circle-o"></i> {{ __('Danh sách') }}</a></li>
        </ul>
      </li>
      <li class="treeview" data-module="report">
        <a href="#">
          <i class="fa fa-warning" aria-hidden="true"></i>
          <span>{{ __('Báo cáo') }}</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li data-function="index"><a href="{{ route('admin.report.index') }}"><i class="fa fa-circle-o"></i> {{ __('Danh sách') }}</a></li>
        </ul>
      </li>
      <li class="treeview" data-module="log">
        <a href="#">
          <i class="fa fa-book" aria-hidden="true"></i>
          <span>{{ __('Nhật kí') }}</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li data-function="index"><a href="{{ route('admin.log.index') }}"><i class="fa fa-circle-o"></i> {{ __('Danh sách') }}</a></li>
        </ul>
      </li>
    </ul>
  </section>
</aside>