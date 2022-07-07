@section('leftside')
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4 mb-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
            <img src="{{ url('backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Bucheye</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                @guest
                @else
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                        <li class="nav-item menu-open">
                            <a href="{{ route('admin') }}"
                                class="nav-link {{ in_array(request()->route()->getName(),['admin'])? 'active': '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                    {{-- <i class="right fas fa-angle-left"></i> --}}
                                </p>
                            </a>

                        </li>
                        @can('admin-list')
                            <li class="nav-item">
                                <a href="{{ route('admin.index') }}"
                                    class="nav-link {{ in_array(request()->route()->getName(),['admin.index', 'admin.edit', 'admin.delete', 'admin.create'])? 'active': '' }}">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        Manage Admin
                                        {{-- <span class="right badge badge-danger">New</span> --}}
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('role-list')
                            <li class="nav-item">
                                <a href="{{ route('roles.index') }}"
                                    class="nav-link {{ in_array(request()->route()->getName(),['roles.index', 'roles.edit', 'roles.delete', 'roles.create'])? 'active': '' }}">
                                    <i class="nav-icon fas fa-tasks"></i>
                                    <p>
                                        Manage Roles
                                        {{-- <span class="right badge badge-danger">New</span> --}}
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('permission-list')
                            @if (Auth::User()->id == 1)
                                <li class="nav-item">
                                    <a href="{{ route('permissions.index') }}"
                                        class="nav-link {{ in_array(request()->route()->getName(),['permissions.index', 'permissions.edit', 'permissions.delete', 'permissions.create'])? 'active': '' }}">
                                        <i class="nav-icon fas fa-user-shield"></i>
                                        <p>
                                            Manage Permission
                                            {{-- <span class="right badge badge-danger">New</span> --}}
                                        </p>
                                    </a>
                                </li>
                            @endif
                        @endcan
                        {{-- @can('vendor-list')
                            <li class="nav-item">
                                <a href="{{ route('vendor.index') }}"
                                    class="nav-link {{ in_array(request()->route()->getName(),['vendor.index', 'vendor.edit', 'vendor.delete', 'vendor.create'])? 'active': '' }}">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        Manage Vendor
                                        <span class="right badge badge-danger">New</span>
                                    </p>
                                </a>
                            </li>
                        @endcan --}}
                        {{-- @can('transaction-list')
                            <li class="nav-item">
                                <a href="{{ route('transaction.index') }}"
                                    class="nav-link {{ in_array(request()->route()->getName(),['transaction.index', 'transaction.edit', 'transaction.delete', 'transaction.create'])? 'active': '' }}">
                                    <i class="nav-icon fas fa-money-check"></i>
                                    <p>
                                        Manage Transaction
                                        <span class="right badge badge-danger">New</span>
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('banner-list')
                            <li class="nav-item">
                                <a href="{{ route('banner.index') }}"
                                    class="nav-link {{ in_array(request()->route()->getName(),['banner.index', 'banner.edit', 'banner.delete', 'banner.create'])? 'active': '' }}">
                                    <i class="nav-icon far fa-image"></i>
                                    <p>
                                        Manage Banner
                                        <span class="right badge badge-danger">New</span>
                                    </p>
                                </a>
                            </li>
                        @endcan --}}
                        @can('category-list')
                            <li class="nav-item">
                                <a href="{{ route('category.index') }}"
                                    class="nav-link {{ in_array(request()->route()->getName(),['category.index', 'category.edit', 'category.delete', 'category.create'])? 'active': '' }}">
                                    <i class="nav-icon fas fa-list-alt"></i>
                                    <p>
                                        Manage Category
                                        {{-- <span class="right badge badge-danger">New</span> --}}
                                    </p>
                                </a>
                            </li>
                        @endcan
                        {{-- @can('areaManagement-list')
                            <li class="nav-item">
                                <a href="{{ route('areaManagement.index') }}"
                                    class="nav-link {{ in_array(request()->route()->getName(),['areaManagement.index', 'areaManagement.edit', 'areaManagement.delete', 'areaManagement.create'])? 'active': '' }}">
                                    <i class="nav-icon fa fa-map-marker"></i>
                                    <p>
                                        Area Management
                                        <span class="right badge badge-danger">New</span>
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('deliveryBoy-list')
                            <li class="nav-item">
                                <a href="{{ route('deliveryBoy.index') }}"
                                    class="nav-link {{ in_array(request()->route()->getName(),['deliveryBoy.index', 'deliveryBoy.edit', 'deliveryBoy.delete', 'deliveryBoy.create'])? 'active': '' }}">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>
                                        Manage Delivery Boy
                                        <span class="right badge badge-danger">New</span>
                                    </p>
                                </a>
                            </li>
                        @endcan --}}
                        @can('manageCustomer-list')
                            <li class="nav-item">
                                <a href="{{ route('manageCustomer.index') }}"
                                    class="nav-link {{ in_array(request()->route()->getName(),['manageCustomer.index', 'manageCustomer.edit', 'manageCustomer.delete', 'manageCustomer.create'])? 'active': '' }}">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        Manage Customer
                                        {{-- <span class="right badge badge-danger">New</span> --}}
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('coupons-list')
                            <li class="nav-item">
                                <a href="{{ route('coupons.index') }}"
                                    class="nav-link {{ in_array(request()->route()->getName(),['coupons.index', 'coupons.edit', 'coupons.delete', 'coupons.create'])? 'active': '' }}">
                                    <i class="nav-icon fas fa-gift"></i>
                                    <p>
                                       Manage Coupons
                                        {{-- <span class="right badge badge-danger">New</span> --}}
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('manage-catelog')
                            <li
                                class="nav-item
                            {{ in_array(request()->route()->getName(),['admin.index','admin.edit','admin.delete','admin.create','product-family.index','product-family.edit','product-family.delete','product-attribute.index','product-attribute.edit','product-attribute.delete','product-attribute.create','family-attribute.index','family-attribute.edit','family-attribute.delete','family-attribute.create','product.index','product.edit','product.delete','product.create'])? 'menu-is-opening menu-open': '' }} ">
                                <a href="#"
                                    class="nav-link {{ in_array(request()->route()->getName(),['admin.index', 'admin.edit', 'admin.delete', 'admin.create'])? 'active': '' }}">
                                    <i class="nav-icon fas fa-chart-pie"></i>
                                    <p>
                                        Manage Catelog
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview" style="font-size: 12px;">
                                    @can('product-family-list')
                                        <li class="nav-item">
                                            <a href="{{ route('product-family.index') }}"
                                                class="nav-link {{ in_array(request()->route()->getName(),['product-family.index', 'product-family.edit', 'product-family.delete', 'product-family.create'])? 'active': '' }}">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Manage Product Family</p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('product-attribute-list')
                                        <li class="nav-item">
                                            <a href="{{ route('product-attribute.index') }}"
                                                class="nav-link {{ in_array(request()->route()->getName(),['product-attribute.index', 'product-attribute.edit', 'product-attribute.delete', 'product-attribute.create'])? 'active': '' }}">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Manage Product Attribute</p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('family-attribute-list')
                                        <li class="nav-item">
                                            <a href="{{ route('family-attribute.index') }}"
                                                class="nav-link {{ in_array(request()->route()->getName(),['family-attribute.index', 'family-attribute.edit', 'family-attribute.delete', 'family-attribute.create'])? 'active': '' }}">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Manage Family Attribute</p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('product-list')
                                        <li class="nav-item">
                                            <a href="{{ route('product.index') }}"
                                                class="nav-link {{ in_array(request()->route()->getName(),['product.index', 'product.edit', 'product.delete', 'product.create'])? 'active': '' }}">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Manage Product</p>
                                            </a>
                                        </li>
                                    @endcan
                                    {{-- @can('hot_products-list')
                                        <li class="nav-item">
                                            <a href="{{ route('hot_products.index') }}"
                                                class="nav-link {{ in_array(request()->route()->getName(),['hot_products.index', 'hot_products.edit', 'hot_products.delete', 'hot_products.create'])? 'active': '' }}">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Hot Product</p>
                                            </a>
                                        </li>
                                    @endcan --}}
                                    {{-- @can('top-sellers-list')
                                        <li class="nav-item">
                                            <a href="{{ route('top-sellers.index') }}"
                                                class="nav-link {{ in_array(request()->route()->getName(),['top-sellers.index', 'top-sellers.edit', 'top-sellers.delete', 'top-sellers.create'])? 'active': '' }}">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Top Sellers</p>
                                            </a>
                                        </li>
                                    @endcan --}}

                                </ul>
                            </li>
                        @endcan
                        @can('manage-unit-type-list')
                            <li class="nav-item">
                                <a href="{{ route('unitType.index') }}"
                                    class="nav-link {{ in_array(request()->route()->getName(),['unitType.index', 'unitType.edit', 'unitType.delete', 'unitType.create'])? 'active': '' }}">
                                    <i class="nav-icon fas fa-weight"></i>
                                    <p>
                                        Manage Unit Type
                                        {{-- <span class="right badge badge-danger">New</span> --}}
                                    </p>
                                </a>
                            </li>
                        @endcan
                        {{-- @can('manage-blog-list')
                            <li class="nav-item">
                                <a href="{{ route('blog.index') }}"
                                    class="nav-link {{ in_array(request()->route()->getName(),['blog.index', 'blog.edit', 'blog.delete', 'blog.create'])? 'active': '' }}">
                                    <i class="nav-icon fas fa-blog"></i>
                                    <p>
                                        Manage Blogs
                                        <span class="right badge badge-danger">New</span>
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('notification-list')
                            <li class="nav-item">
                                <a href="{{ route('notification.index') }}"
                                    class="nav-link {{ in_array(request()->route()->getName(),['notification.index', 'notification.edit', 'notification.delete', 'notification.create'])? 'active': '' }}">
                                    <i class="nav-icon fas fa-bell"></i>
                                    <p>
                                        Show Notification
                                        <span class="right badge badge-danger">New</span>
                                    </p>
                                </a>
                            </li>
                        @endcan --}}
                        @can('orders-list')
                            <li class="nav-item">
                                <a href="{{ route('orders.index') }}" class="nav-link {{ in_array(request()->route()->getName(),['orders.index']) ? 'active': '' }}">
                                    <i class="far fa-file nav-icon"></i>
                                    <p>Manage Order</p>
                                </a>
                            </li>
                        @endcan
                        {{-- @can('user-wallet-list')
                            <li class="nav-item">
                                <a href="{{ route('userWallet.index') }}" class="nav-link {{ in_array(request()->route()->getName(),['userWallet.index'])? 'active': '' }}">
                                    <i class="nav-icon fas fa-wallet"></i>
                                    <p>User Wallet</p>
                                </a>
                            </li>
                        @endcan --}}
                        @can('aap-setting-list')
                            <li class="nav-item{{ in_array(request()->route()->getName(),['manage-user-setting','manage-vendor-setting','manage-delivery-boy-setting'])? 'menu-is-opening menu-open': '' }} ">
                                <a href="#"
                                    class="nav-link {{ in_array(request()->route()->getName(),['manage-user-setting','manage-vendor-setting','manage-delivery-boy-setting'])? 'active': '' }}">
                                    <i class="nav-icon fas fa-chart-pie"></i>
                                    <p>
                                        Setting
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview" style="font-size: 12px;">
                                    {{-- @can('user-aap-setting-list')
                                        <li class="nav-item">
                                            <a href="{{ route('manage-user-setting') }}" class="nav-link {{ in_array(request()->route()->getName(),['manage-user-setting'])? 'active': '' }}">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>User</p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('vendor-app-setting-list')
                                        <li class="nav-item">
                                            <a href="{{ route('manage-vendor-setting') }}" class="nav-link {{ in_array(request()->route()->getName(),['manage-vendor-setting'])? 'active': '' }}">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Vendor</p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('Delivery-boy-aap-setting-list')
                                        <li class="nav-item">
                                            <a href="{{ route('manage-delivery-boy-setting') }}" class="nav-link {{ in_array(request()->route()->getName(),['manage-delivery-boy-setting'])? 'active': '' }}">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Delivery Boy</p>
                                            </a>
                                        </li>
                                    @endcan --}}
                                    @can('website-setting-list')
                                        <li class="nav-item">
                                            <a href="{{ route('manage-website-setting') }}" class="nav-link {{ in_array(request()->route()->getName(),['manage-website-setting'])? 'active': '' }}">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Website</p>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>
                        @endcan
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        </ul>
    @endguest

    </nav>
    <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
    </aside>
@endsection
