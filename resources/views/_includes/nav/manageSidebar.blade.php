

            <!-- Sidebar Holder -->
            <nav id="sidebar">
                <div class="sidebar-header">
                    <h4>Admin</h4>
                </div>

                <ul class="list-unstyled components">
                
                    <li >
                        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">Home</a>
                        <ul class="collapse list-unstyled col_ul" id="homeSubmenu">
                            <li><a href="#">Home 2</a></li>
                            <li><a href="#">Home 3</a></li>
                        </ul>
                    </li>
                    <li class="{{Nav::isRoute('manage.dashboard')}}">
                      <a href="{{route('manage.dashboard')}}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="#pageSubmenu" class="{{Nav::hasSegment(['users','roles','permissions'], 2)}}" data-toggle="collapse" aria-expanded="false">Administration  <span class="caret"></span></a>
                        <ul class="collapse list-unstyled col_ul" id="pageSubmenu" >
                            <li class="{{Nav::isResource('users')}}"><a href="{{route('users.index')}}"><i class="fa fa-users m-r-5" aria-hidden="true"></i> Manage users</a></li>
                            <li class="{{Nav::isResource('roles')}}"><a href="{{route('roles.index')}}"><i class="fa fa-user-secret" aria-hidden="true"></i> Manage Roles</a></li>
                            <li class="{{Nav::isResource('permissions')}}"><a href="{{route('permissions.index')}}"><i class="fa fa-key" aria-hidden="true"></i> Manage permission</a></li>

                        </ul>
                    </li>

                    <li class="{{Nav::isResource('faculties')}}"> 
                        <a href="{{route('faculties.index')}}">faculty</a>
                    </li>

                    <li class="{{Nav::isResource('subjects')}}">
                        <a href="{{route('subjects.index')}}">Subjects</a>
                    </li>
                    <li class="{{Nav::isRoute('download_categories.index')}}">
                        <a href="{{route('download_categories.index')}}">Download Categories</a>
                    </li>
                    <li class="{{Nav::isRoute('tags.index')}}">
                        <a href="{{route('tags.index')}}">Tags</a>
                    </li>
                    <li class="{{Nav::isResource('downloads')}}">
                        <a href="{{route('downloads.index')}}">Downloads</a>
                    </li>
                    <li class="{{Nav::isResource('projects')}}">
                        <a href="{{route('projects.index')}}">Projects</a>
                    </li>
                    <li class="{{Nav::isResource('events')}}">
                        <a href="{{route('events.index')}}">Events</a>
                    </li>
                    <li class="{{Nav::isResource('posts')}}">
                        <a href="{{route('posts.index')}}">Posts</a>
                    </li>
                </ul>

                
            </nav>

            <!-- Page Content Holder -->


        