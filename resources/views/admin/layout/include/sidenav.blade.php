<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('admin/dashboard') }}" class="brand-link">
      <img src="{{ asset('img/logo/logo.png') }}" alt="Logo" class="brand-image elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('img/user/user_default.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ auth()->user()->email }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <!-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        @if(auth()->user()->roleIs('admin'))
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->


          <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <li class="nav-item {{ (request()->is('admin/orders*')) ? 'menu-open' : '' }} " >
            <a href="#" class="nav-link {{ (request()->is('admin/orders*')) ? 'active' : '' }}
                {{ (request()->is('admin/customers*')) ? 'active' : '' }}
                {{ (request()->is('admin/productstock*')) ? 'active' : '' }}
                {{ (request()->is('admin/Transactional*')) ? 'active' : '' }}
                {{ (request()->is('admin/reviewReport*')) ? 'active' : '' }}
                ">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Report
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.orders.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>ALL orders</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.customers') }}" class="nav-link">
                  <i class="far fa-user nav-icon"></i>
                  <p>All Customers</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.productstock') }}" class="nav-link">
                  <i class="far fa-list nav-icon"></i>
                  <p>Product Stock Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.Transactional') }}" class="nav-link">
                  <i class="far fa-credit-card nav-icon"></i>
                  <p>Transaction Report</p>
                </a>
              </li>

            </ul>
          </li>


          <li class="nav-item">
            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ (request()->is('admin/categories*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-sitemap"></i>
              <p>
                Categories
              </p>
            </a>
          </li>

          <li class="nav-item {{ (request()->is('admin/products/*')) ? 'menu-open' : '' }} " >
            <a href="#" class="nav-link {{ (request()->is('admin/products/*')) ? 'active' : '' }}
                {{ (request()->is('admin/products')) ? 'active' : '' }}
                ">
              <i class="nav-icon fas fa-shopping-bag"></i>
              <p>
                Products
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.products.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add New</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.products.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Products</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.reviewReport') }}" class="nav-link">
                  <i class="far fa-credit-card nav-icon"></i>
                  <p>Reviews</p>
                </a>
              </li>
            </ul>
          </li>



          <li class="nav-item {{ (request()->is('admin/recipes_category_list*')) ? 'menu-open' : '' }} " >
            <a href="#" class="nav-link {{ (request()->is('admin/recipes_category_list*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-shopping-bag"></i>
              <p>
                Recipes
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.recipes_category_list') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Recipe Categories</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.recipes_list') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Recipes</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.blog.list') }}" class="nav-link {{ (request()->is('admin/blog/list*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-sitemap"></i>
              <p>
                Blogs
              </p>
            </a>
          </li>


          <li class="nav-item {{ (request()->is('admin/branches*')) ? 'menu-open' : '' }} " >
            <a href="#" class="nav-link {{ (request()->is('admin/branches*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-truck"></i>
              <p>
                Branches
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <!-- <li class="nav-item">
                <a href="{{ route('admin.branches.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add New</p>
                </a>
              </li> -->
              <li class="nav-item">
                <a href="{{ route('admin.branches.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Branches</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- <li class="nav-item {{ (request()->is('admin/users*')) ? 'menu-open' : '' }} " >
            <a href="#" class="nav-link {{ (request()->is('admin/users*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Users</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.coupons.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Contact requests</p>
                </a>
              </li>
            </ul>
          </li> -->
          <li class="nav-item {{ (request()->is('admin/settings*')) ? 'menu-open' : '' }} " >
            <a href="#" class="nav-link {{ (request()->is('admin/settings*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Settings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.settings.banner.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Banner</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.coupons.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Coupons</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.settings.testimonials.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Testimonials</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.about-us') }}" class="nav-link {{ (request()->is('admin/about-us*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-address-card"></i>
              <p>
                About Us
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.admin-user.list') }}" class="nav-link {{ (request()->is('admin/admin-user/list*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>
                Admin Users (CFA)
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.pages_show') }}" class="nav-link {{ (request()->is('admin/pages*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-scroll"></i>
              <p>
                Pages
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.user.subs') }}" class="nav-link {{ (request()->is('admin/user-subsc*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Email Subscriptions
              </p>
            </a>
          </li>

          <li class="nav-item {{ (request()->is('admin/subscription*')) ? 'menu-open' : '' }} " >
            <a href="#" class="nav-link {{ (request()->is('admin/subscription*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-cart-plus"></i>
              <p>
                Subscriptions
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.subscription') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Subscription List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.subscription.user') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User Subscriptions</p>
                </a>
              </li>
            </ul>
          </li>




        </ul>
        @elseif(auth()->user()->roleIs('branch_admin'))
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->


          <li class="nav-item">
            <a href="{{ route('admin.cfa.dashboard') }}" class="nav-link {{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <li class="nav-item {{ (request()->is('admin/orders*')) ? 'menu-open' : '' }} " >
            <a href="#" class="nav-link {{ (request()->is('admin/orders*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Orders
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.cfa.orders.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All orders</p>
                </a>
              </li>
            </ul>
          </li>


          <li class="nav-item {{ (request()->is('admin/products*')) ? 'menu-open' : '' }} " >
            <a href="#" class="nav-link {{ (request()->is('admin/products*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-shopping-bag"></i>
              <p>
                Products Stock
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.cfa.productstock') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Products Stock</p>
                </a>
              </li>
            </ul>
          </li>
{{--
          <li class="nav-item {{ (request()->is('admin/settings*')) ? 'menu-open' : '' }} " >
            <a href="#" class="nav-link {{ (request()->is('admin/settings*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Settings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.settings.banner.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Banner</p>
                </a>
              </li>
            </ul>
          </li> --}}

        </ul>
        @endif
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
