<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.index') }}" class="brand-link">
        <img src="/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: 1 ; background-color: white">
        <span class="brand-text font-weight-light">پنل مدیریت</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="direction: ltr">
        <div style="direction: rtl">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="/dist/img/user8-128x128.jpg"
                         class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="http://github.com/danialmahdian/" class="d-block">دانیال مهدیان</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{ route('admin.') }}" class="nav-link {{ isActive('admin.index') }}">
                            <i class="nav-icon fa fa-dashboard"></i>
                            <p>پنل مدیریت</p>
                        </a>
                    </li>
                    @can('show-user')
                        <li class="nav-item has-treeview {{ isActive(['admin.users.index', 'admin.users.create', 'admin.users.edit'], 'menu-open') }}">
                            <a href="{{ route('admin.users.index') }}"
                               class="nav-link {{ isActive('admin.users.index') }}">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                    کاربران
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.index') }}"
                                       class="nav-link {{ isActive('admin.users.index') }}">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>لیست کاربران</p>
                                    </a>
                            </ul>
                        </li>
                    @endcan
                    @canany(['show-permissions', 'show-roles'])
                        <li class="nav-item has-treeview {{ isActive(['admin.permissions.index', 'admin.roles.index'], 'menu-open') }}">
                            <a href="{{ route('admin.permissions.index') }}"
                               class="nav-link {{ isActive(['admin.permissions.index', 'admin.roles.index']) }}">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                    بخش اجازه دسترسی
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            @can('show-roles')
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.roles.index') }}"
                                           class="nav-link {{ isActive('admin.roles.index') }}">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>همه مقام ها</p>
                                        </a>
                                    </li>
                                </ul>
                            @endcan
                            @can('show-permissions')
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.permissions.index') }}"
                                           class="nav-link {{ isActive('admin.permissions.index') }}">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>همه دسترسی ها</p>
                                        </a>
                                </ul>
                            @endcan
                        </li>
                    @endcanany
                    @can('show-comment')
                        <li class="nav-item has-treeview {{ isActive(['admin.comments.index', 'admin.comments.update', 'admin.users.approved'], 'menu-open') }}">
                            <a href="{{ route('admin.comments.index') }}"
                               class="nav-link {{ isActive('admin.comments.index') }}">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                    نظرات
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.comments.unapproved') }}"
                                       class="nav-link {{ isActive('admin.comments.unapproved') }}">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>لیست نظرات تایید نشده</p>
                                    </a>
                            </ul>
                        </li>
                    @endcan
                    <li class="nav-item has-treeview {{ isActive(['admin.orders.index',] , 'menu-open') }}">
                        <a href="{{ route('admin.orders.index') }}"
                           class="nav-link {{ isActive(['admin.orders.index']) }}">
                            <i class="nav-icon fa fa-users"></i>
                            <p>
                                بخش سفارشات
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.orders.index' , ['type' => 'unpaid']) }}"
                                   class="nav-link {{ isUrl(route('admin.orders.index' , ['type' => 'unpaid'])) }} ">
                                    <i class="fa fa-circle-o nav-icon text-warning"></i>
                                    <p>پرداخت نشده
                                        <span
                                            class="badge badge-warning right">{{ \App\Models\Order::whereStatus('unpaid')->count() }}</span>
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.orders.index' , ['type' => 'paid']) }}"
                                   class="nav-link {{ isUrl(route('admin.orders.index' , ['type' => 'paid'])) }}">
                                    <i class="fa fa-circle-o nav-icon text-info"></i>
                                    <p>پرداخت شده
                                        <span
                                            class="badge badge-info right">{{ \App\Models\Order::whereStatus('paid')->count() }}</span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.orders.index'  , ['type' => 'preparation']) }}"
                                   class="nav-link {{ isUrl(route('admin.orders.index' , ['type' => 'preparation'])) }}">
                                    <i class="fa fa-circle-o nav-icon text-primary"></i>
                                    <p>در حال پردازش
                                        <span
                                            class="badge badge-primary right">{{ \App\Models\Order::whereStatus('preparation')->count() }}</span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.orders.index' , ['type' => 'posted']) }}"
                                   class="nav-link {{ isUrl(route('admin.orders.index' , ['type' => 'posted'])) }}">
                                    <i class="fa fa-circle-o nav-icon text text-light"></i>
                                    <p>ارسال شده
                                        <span
                                            class="badge badge-light right">{{ \App\Models\Order::whereStatus('posted')->count() }}</span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.orders.index' , ['type' => 'received']) }}"
                                   class="nav-link {{ isUrl(route('admin.orders.index' , ['type' => 'received'])) }}">
                                    <i class="fa fa-circle-o nav-icon text-success"></i>
                                    <p>دریافت شده
                                        <span
                                            class="badge badge-success right">{{ \App\Models\Order::whereStatus('received')->count() }}</span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.orders.index' , ['type' => 'canceled']) }}"
                                   class="nav-link {{ isUrl(route('admin.orders.index' , ['type' => 'canceled'])) }}">
                                    <i class="fa fa-circle-o nav-icon text-danger"></i>
                                    <p>کنسل شده
                                        <span
                                            class="badge badge-danger right">{{ \App\Models\Order::whereStatus('canceled')->count() }}</span>
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @foreach(Module::collections() as $module)
                        @if( View::exists("{$module->getLowerName()}::admin.sidebar-item"))
                            @include("{$module->getLowerName()}::admin.sidebar-item")
                        @endif
                    @endforeach
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
    </div>
    <!-- /.sidebar -->
</aside>
