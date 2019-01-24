<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="{{asset('img/profile_small.jpg')}}" />
                             </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">David Williams</strong>
                             </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="#">Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="{{Route('login')}}">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            <li class="@if(route_name() == 'home') active @endif">
                <a href="{{Route('home')}}"><i class="fa fa-th-large"></i> <span class="nav-label">信息面板</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{Route('home')}}">信息面板</a></li>
                </ul>
            </li>
            <li class="@if(current_namespace() == 'User')  active @endif">
                <a href="#"><i class="fa fa-users"></i> <span class="nav-label">用户管理</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="{{ route('user.index') }}">用户列表</a></li>
                </ul>
            </li>
            <li class="@if(current_namespace() == 'Category')  active @endif">
                <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">类别管理</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="{{ route('category.index') }}">类别列表</a></li>
                </ul>
            </li>
            <li class="@if(current_namespace() == 'Tag')  active @endif">
                <a href="#"><i class="fa fa-tags"></i> <span class="nav-label">标签管理</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="{{ route('tag.index') }}">标签列表</a></li>
                </ul>
            </li>
            <li class="@if(current_namespace() == 'Article')  active @endif">
                <a href="#"><i class="fa fa-book"></i> <span class="nav-label">文章管理</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="{{ route('article.index') }}">文章列表</a></li>
                    <li><a href="{{ route('comment.index') }}">评论列表</a></li>
                    <li><a href="{{ route('visitor.index') }}">访问列表</a></li>
                </ul>
            </li>
            <li class="@if(current_namespace() == 'System')  active @endif">
                <a href="#"><i class="fa fa-cogs"></i> <span class="nav-label">系统管理</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="{{ route('member.index') }}">系统用户</a></li>
                    <li><a href="{{ route('menu.index') }}">菜单管理</a></li>
                    <li><a href="{{ route('role.index') }}">角色管理</a></li>
                    <li><a href="{{ route('node.index') }}">节点管理</a></li>
                    <li><a href="{{ route('system.index') }}">系统信息</a></li>
                </ul>
            </li>
        </ul>

    </div>
</nav>
