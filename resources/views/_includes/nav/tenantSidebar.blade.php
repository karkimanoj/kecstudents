
            <!-- Sidebar Holder -->
            <nav id="sidebar">
                <div class="sidebar-header">
                    <h5>Tenant Admin</h5>
                </div>

                <ul class="list-unstyled components">

                    <li class="{{Nav::isRoute('tenants.index')}}"> 
                        <a href="{{route('tenants.index')}}">All Colleges</a>
                    </li>

                    <li class="{{Nav::isRoute('tenants.create')}}">
                        <a href="{{route('tenants.create')}}">Add New College</a>
                    </li>
                    <li class="{{Nav::isRoute('tenantAdmin.index')}}">
                        <a href="{{route('tenantAdmin.index')}}">All Tenant Admins</a>
                    </li>
                    <li class="{{Nav::isRoute('tenantAdmin.create')}}">
                        <a href="{{route('tenantAdmin.create')}}">Add New Tenant Admin</a>
                    </li>
                   
                </ul>

                
            </nav>

            <!-- Page Content Holder -->
