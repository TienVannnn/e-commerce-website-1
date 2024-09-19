<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
      <!-- Logo Header -->
      <div class="logo-header" data-background-color="dark">
        <a href="/admin">
          Hello Admin {{ Auth::guard('manager') -> user() -> name }}
        </a>
        <div class="nav-toggle">
          <button class="btn btn-toggle toggle-sidebar">
            <i class="gg-menu-right"></i>
          </button>
          <button class="btn btn-toggle sidenav-toggler">
            <i class="gg-menu-left"></i>
          </button>
        </div>
        <button class="topbar-toggler more">
          <i class="gg-more-vertical-alt"></i>
        </button>
      </div>
      <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
      <div class="sidebar-content">
        <ul class="nav nav-secondary">
          <li class="nav-item active">
            <a
              data-bs-toggle="collapse"
              href="/admin"
              class="collapsed"
              aria-expanded="false"
            >
              <i class="fas fa-home"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-section">
            <span class="sidebar-mini-icon">
              <i class="fa fa-ellipsis-h"></i>
            </span>
            <h4 class="text-section">Components</h4>
          </li>
          @can('viewAny', \App\Model\Category::class)
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#category">
                <i class="fas fa-layer-group"></i>
                <p>Category</p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="category">
                <ul class="nav nav-collapse">
                  <li>
                    <a href="{{ route('category.index') }}">
                      <span class="sub-item">Category List</span>
                    </a>
                  </li>
                  @can('create', \App\Model\Category::class)
                    <li>
                      <a href="{{ route('category.create') }}">
                        <span class="sub-item">Add new category</span>
                      </a>
                    </li>
                  @endcan
                </ul>
              </div>
            </li>
          @endcan
          @can('viewAny', \App\Model\Menu::class)
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#menu">
                <i class="fas fa-th-list"></i>
                <p>Menu</p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="menu">
                <ul class="nav nav-collapse">
                  <li>
                    <a href="{{ route('menus.index') }}">
                      <span class="sub-item">Menu List</span>
                    </a>
                  </li>
                  @can('create', \App\Model\Menu::class)
                    <li>
                      <a href="{{ route('menus.create') }}">
                        <span class="sub-item">Add Menu</span>
                      </a>
                    </li>
                  @endcan
                </ul>
              </div>
            </li>
          @endcan
          @can('viewAny', \App\Model\Product::class)
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#product">
                <i class="fab fa-product-hunt"></i>
                <p>Product</p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="product">
                <ul class="nav nav-collapse">
                  <li>
                    <a href="{{ route('products.index') }}">
                      <span class="sub-item">Product List</span>
                    </a>
                  </li>
                  @can('create', \App\Model\Product::class)
                    <li>
                      <a href="{{ route('products.create') }}">
                        <span class="sub-item">Add product</span>
                      </a>
                    </li>
                  @endcan
                </ul>
              </div>
            </li> 
          @endcan
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#tag">
              <i class="fas fa-flag"></i>
              <p>Tag</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="tag">
              <ul class="nav nav-collapse">
                <li>
                  <a href="{{ route('tags.index') }}">
                    <span class="sub-item">Tag List</span>
                  </a>
                </li>
                <li>
                  <a href="{{ route('tags.create') }}">
                    <span class="sub-item">Add tag</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          @can('viewAny', \App\Model\Slider::class)
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#slider">
                <i class="fas fa-sliders-h"></i>
                <p>Sliders</p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="slider">
                <ul class="nav nav-collapse">
                  <li>
                    <a href="{{ route('sliders.index') }}">
                      <span class="sub-item">Danh sách slider</span>
                    </a>
                  </li>
                  @can('create', \App\Model\Slider::class)
                    <li>
                      <a href="{{ route('sliders.create') }}">
                        <span class="sub-item">Thêm mới slider</span>
                      </a>
                    </li>
                  @endcan
                </ul>
              </div>
            </li>
          @endcan
          @can('viewAny', \App\Model\Config::class)
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#setting">
                <i class="fas fa-wrench"></i>
                <p>Configs</p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="setting">
                <ul class="nav nav-collapse">
                  <li>
                    <a href="{{ route('configs.index') }}">
                      <span class="sub-item">Danh sách config</span>
                    </a>
                  </li>
                  @can('create', \App\Models\Config::class)
                    <li>
                      <a href="{{ route('configs.create') }}">
                        <span class="sub-item">Thêm mới config</span>
                      </a>
                    </li>
                  @endcan
                </ul>
              </div>
            </li>
          @endcan
          @can('viewAny', \App\Model\Manager::class)
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#manager">
                <i class="fas fa-address-card"></i>
                <p>Managers</p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="manager">
                <ul class="nav nav-collapse">
                  <li>
                    <a href="{{ route('managers.index') }}">
                      <span class="sub-item">Danh sách manager</span>
                    </a>
                  </li>
                  @can('create', \App\Model\Manager::class)
                    <li>
                      <a href="{{ route('managers.create') }}">
                        <span class="sub-item">Thêm mới manager</span>
                      </a>
                    </li>
                  @endcan
                </ul>
              </div>
            </li>
          @endcan

          @can('viewAny', \App\Model\Role::class)
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#role">
                <i class="fas fa-align-left"></i>
                <p>Roles</p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="role">
                <ul class="nav nav-collapse">
                  <li>
                    <a href="{{ route('roles.index') }}">
                      <span class="sub-item">Danh sách vai trò</span>
                    </a>
                  </li>
                  @can('create', \App\Model\Role::class)
                    <li>
                      <a href="{{ route('roles.create') }}">
                        <span class="sub-item">Thêm mới vai trò</span>
                      </a>
                    </li>
                  @endcan
                </ul>
              </div>
            </li>
          @endcan

          @can('viewAny', \App\Model\Permission::class)
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#permission">
                <i class="fas fa-cog"></i>
                <p>Permission</p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="permission">
                <ul class="nav nav-collapse">
                  <li>
                    <a href="{{ route('permissions.index') }}">
                      <span class="sub-item">Danh sách quyền</span>
                    </a>
                  </li>
                  @can('create', \App\Model\Permission::class)
                    <li>
                      <a href="{{ route('permissions.create') }}">
                        <span class="sub-item">Thêm mới quyền</span>
                      </a>
                    </li>
                  @endcan
                </ul>
              </div>
            </li>
          @endcan
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#donhang">
              <i class="fas fa-cart-arrow-down"></i>
              <p>Đơn hàng</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="donhang">
              <ul class="nav nav-collapse">
                <li>
                  <a href="{{ route('orders.index') }}">
                    <span class="sub-item">Danh sách đơn hàng</span>
                  </a>
                </li>
                {{-- @can('create', \App\Model\Permission::class) --}}
                  {{-- <li>
                    <a href="{{ route('permissions.create') }}">
                      <span class="sub-item">Thêm mới quyền</span>
                    </a>
                  </li> --}}
                {{-- @endcan --}}
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!-- End Sidebar -->