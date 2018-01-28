

            <!-- Sidebar Holder -->
            <nav id="sidebar">
                <div class="sidebar-header">
                    <h3>Devmarketer admin</h3>
                </div>

                <ul class="list-unstyled components">
                    <p>Dummy Heading</p>
                    <li >
                        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">Home</a>
                        <ul class="collapse list-unstyled" id="homeSubmenu">
                            <li><a href="#">Home 1</a></li>
                            <li><a href="#">Home 2</a></li>
                            <li><a href="#">Home 3</a></li>
                        </ul>
                    </li>
                    <li class="{{Nav::isRoute('manage.dashboard')}}">
                      <a href="{{route('manage.dashboard')}}"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="#pageSubmenu" class="{{Nav::hasSegment(['users','roles','permissions'], 2)}}" data-toggle="collapse" aria-expanded="false">Administration</a>
                        <ul class="collapse list-unstyled col_ul" id="pageSubmenu">
                            <li class="{{Nav::isResource('users')}}"><a href="{{route('users.index')}}"><i class="fa fa-users m-r-5" aria-hidden="true"></i> Manage users</a></li>
                            <li class="{{Nav::isResource('roles')}}"><a href="{{route('roles.index')}}"><i class="fa fa-user-secret" aria-hidden="true"></i> Manage Roles</a></li>
                            <li class="{{Nav::isResource('permissions')}}"><a href="{{route('permissions.index')}}"><i class="fa fa-key" aria-hidden="true"></i> Manage permission</a></li>

                        </ul>
                    </li>

                    <li>
                        <a href="#">Portfolio</a>
                    </li>

                    <li>
                        <a href="#">Contact</a>
                    </li>
                </ul>

                <ul class="list-unstyled CTAs">
                    <li><a href="https://bootstrapious.com/tutorial/files/sidebar.zip" class="download">Download source</a></li>
                    <li><a href="https://bootstrapious.com/p/bootstrap-sidebar" class="article">Back to article</a></li>
                </ul>
            </nav>

            <!-- Page Content Holder -->
