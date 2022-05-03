<nav class="page-sidebar" id="sidebar">
    <div id="sidebar-collapse">
        <div class="admin-block d-flex">
            <div>
                <img src="{{asset('/assets/admin/images/admin-avatar.png')}}" width="45px" />
            </div>
            <div class="admin-info align-self-center">
                <div class="font-strong">{{ is_alternative_login() ? alt_usr()->name : Auth::user()->name }}</div>
            </div>
        </div>
        <ul class="side-menu metismenu">
            <li>
                <a class="active" href="{{route('dashboard')}}">
                    <i class="sidebar-item-icon fa-solid fa-gauge"></i>
                    <span class="nav-label">Dashboard</span>
                </a>
            </li>

            <li class="heading">Store</li>

            @if(auth()->user()->hasRole('vendor'))
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-user-circle"></i>
                    <span class="nav-label"> Profile</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">
                    @if(!is_alternative_login())
                    <li>
                        <a href="{{route('editVendorProfile',auth()->id())}}">
                            <span class="fa fa-edit"></span>
                            Edit Profile
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="{{route('vendor.profile')}}">
                            <span class="fa fa-eye"></span>
                            View Profile
                        </a>
                    </li>
                </ul>
            </li>

            @can('accessChat')
            <li>
                <a href="/chat" target="_blank"><i class="sidebar-item-icon fa fa-comments"></i>
                    <span class="nav-label">Chat</span>
                    @if($hasUnseenMessages)
                    <i class="fa fa-circle text-success arrow"></i>
                    @endif
                </a>
            </li>
            @endcan
            @endif
            @can('manageDeals')
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa-solid fa-handshake"></i>
                    <span class="nav-label">Deals</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">
                    @if(auth()->user()->hasRole('vendor'))
                    <li>
                        <a href="{{route('deals.create')}}">
                            <span class="fa fa-plus"></span>
                            Create New Deal
                        </a>
                    </li>
                    @endif
                    @if(auth()->user()->hasAnyRole('admin|super_admin|vendor'))
                    <li>
                        <a href="{{route('deals.index')}}">
                            <span class="fa fa-eye"></span>
                            All Deals
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endcan

            @if(auth()->user()->hasAnyRole('super_admin|admin'))
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-user-circle"></i>
                    <span class="nav-label">Vendor Management</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">

                    <li>
                        <a href="{{route('vendor.getApprovedVendors')}}">
                            <span class="fa fa-eye"></span>
                            Approved Vendors
                        </a>
                    </li>

                    <li>
                        <a href="{{route('vendor.getNewVendors')}}">
                            <span class="fa fa-eye"></span>
                            Vendor Request
                        </a>
                    </li>

                    <li>
                        <a href="{{route('vendor.getSuspendedVendors')}}">
                            <span class="fa fa-eye"></span>
                            Suspended Vendors
                        </a>
                    </li>
                </ul>
            </li>
            @endif
            @if(auth()->user()->hasAnyRole(['admin|super_admin|vendor']) || !is_alternative_login())
            <li>
                <a href="{{ route('quotations.index') }}">
                    <i class="sidebar-item-icon fa fa-quote-left"></i>
                    <span class="nav-label">RFQ</span>
                </a>
            </li>
            @endif

            @can('viewSalesReport')
            <li>
                <a href="{{route('salesReport')}}">
                    <i class="sidebar-item-icon fa fa-bar-chart"></i>
                    <span class="nav-label">Sales Report</span>
                </a>
            </li>
            @endcan

            @can('manageOrders')
            <li>
                <a href="{{ route('orders.index') }}">
                    <i class="sidebar-item-icon fa-brands fa-first-order"></i>
                    <span class="nav-label">Orders</span>
                </a>
            </li>
            @endcan

            @if(auth()->user()->hasRole('vendor'))
            @can('viewTransactions')
            <li>
                <a href="/transactions/{{ auth()->id() }}">
                    <i class="sidebar-item-icon fa fa-credit-card "></i>
                    <span class="nav-label">Transactions</span>
                </a>
            </li>
            @endcan
            @endif

            @can('manageProducts')
            <li>
                @if( auth()->user()->hasRole('vendor'))
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa-brands fa-product-hunt"></i>
                    <span class="nav-label">Product</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                @endif
                @if( auth()->user()->hasAnyRole('super_admin|admin'))
            <li>
                <a href="{{route('product.index')}}">
                    <i class="sidebar-item-icon fa-brands fa-product-hunt "></i>
                    <span class="nav-label">Products</span>
                </a>
            </li>
            @endif
            @if( auth()->user()->hasRole('vendor'))
            <ul class="nav-2-level collapse">
                <li>
                    <a href="{{route('product.create')}}">
                        <span class="fa fa-plus"></span>
                        Add Product
                    </a>
                </li>
                <li>
                    <a href="{{route('product.index')}}">
                        <i class="fa-brands fa-osi"></i>
                        All Products
                    </a>
                </li>
            </ul>
            @endif
            </li>
            @endcan

            <li class="heading">Categories</li>

            @can('manageCategories')
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-list-alt"></i>
                    <span class="nav-label">Categories</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">

                    <li>
                        <a href="{{route('category.create')}}">
                            <span class="fa fa-plus"></span>
                            Add Category
                        </a>
                    </li>

                    <li>
                        <a href="{{route('category.index')}}">
                            <i class="fa-brands fa-osi"></i>
                            All Category
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-sort-amount-desc"></i>
                    <span class="nav-label">Sub Categories</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">

                    <li>
                        <a href="{{route('subcategory.create')}}">
                            <span class="fa fa-plus"></span>
                            Add Subcategory
                        </a>
                    </li>

                    <li>
                        <a href="{{route('subcategory.index')}}">
                            <i class="fa-brands fa-osi"></i>
                            All SubCategories
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-cube"></i>
                    <span class="nav-label">Product Categories</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">

                    <li>
                        <a href="{{route('product-category.create')}}">
                            <span class="fa fa-plus"></span>
                            Add New
                        </a>
                    </li>

                    <li>
                        <a href="{{route('product-category.index')}}">
                            <i class="fa-brands fa-osi"></i>
                            List All
                        </a>
                    </li>
                </ul>
            </li>
            @endcan
            @if(!is_alternative_login())
            <li class="heading">CMS</li>
            @endif

            @if(auth()->user()->hasAnyRole(['vendor']) && !is_alternative_login())
            <li>
                <a href="{{ route('getShippingInfo') }}">
                    <i class="sidebar-item-icon fa fa-thumbs-up"></i>
                    <span class="nav-label">Shipping & Return </span>
                </a>
            </li>
            @endif

            @if(auth()->user()->hasAnyRole('admin|super_admin'))
            <li>
                <a href="{{route('review.index')}}"><i class="sidebar-item-icon fa fa-th-large"></i>
                    <span class="nav-label">Reviews</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
            </li>
            @endif

            @if(auth()->user()->hasAnyRole('super_admin|admin'))
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-map-marker"></i>
                    <span class="nav-label">Country</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">

                    <li>
                        <a href="{{route('country.create')}}">
                            <span class="fa fa-plus"></span>
                            Add New Country
                        </a>
                    </li>

                    <li>
                        <a href="{{route('country.index')}}">
                            <i class="fa-brands fa-osi"></i>
                            All Countries Lists
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(auth()->user()->hasAnyRole('super_admin|admin'))
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-edit"></i>
                    <span class="nav-label">Blogs</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">

                    <li>
                        <a href="{{route('blog.create')}}">
                            <span class="fa fa-plus"></span>
                            Add New Blog
                        </a>
                    </li>

                    <li>
                        <a href="{{route('blog.index')}}">
                            <i class="fa-brands fa-osi"></i>
                            All Blogs
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(auth()->user()->hasAnyRole('super_admin|admin'))
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-question-circle"></i>
                    <span class="nav-label">FAQ</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">

                    <li>
                        <a href="{{route('faq.create')}}">
                            <span class="fa fa-plus"></span>
                            Add New FAQ
                        </a>
                    </li>

                    <li>
                        <a href="{{route('faq.index')}}">
                            <i class="fa-brands fa-osi"></i>
                            All FAQS
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(auth()->user()->hasAnyRole('super_admin|admin'))
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-address-card"></i>
                    <span class="nav-label">Partner</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="{{route('partner-request.index')}}">
                            <i class="fa-brands fa-osi"></i>
                            All Partner Requests
                        </a>
                    </li>
                    <li>
                        <a href="{{route('partner-type.create')}}">
                            <span class="fa fa-plus"></span>
                            Add New Partner Type
                        </a>
                    </li>

                    <li>
                        <a href="{{route('partner-type.index')}}">
                            <i class="fa-brands fa-osi"></i>
                            All Partner Types Lists
                        </a>
                    </li>
                    <li>
                        <a href="{{route('partner.create')}}">
                            <span class="fa fa-plus"></span>
                            Add New Partner
                        </a>
                    </li>

                    <li>
                        <a href="{{route('partner.index')}}">
                            <i class="fa-brands fa-osi"></i>
                            All Partners Lists
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(auth()->user()->hasAnyRole('super_admin|admin'))
            <li>
                <a href="{{route('subscriber.index')}}">
                    <i class="sidebar-item-icon fa fa-thumbs-up"></i>
                    <span class="nav-label">Subscribers</span>
                </a>
            </li>
            @endif

            @if(auth()->user()->hasAnyRole('super_admin|admin'))
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-image"></i>
                    <span class="nav-label">Sliders</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">

                    <li>
                        <a href="{{route('slider.create')}}">
                            <span class="fa fa-plus"></span>
                            Add Slider
                        </a>
                    </li>

                    <li>
                        <a href="{{route('slider.index')}}">
                            <i class="fa-brands fa-osi"></i>
                            All Slider
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(auth()->user()->hasAnyRole('super_admin|admin'))
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-user"></i>
                    <span class="nav-label">All Users</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="{{route('user.index')}}">
                            <i class="fa-brands fa-osi"></i>
                            All Vendors
                        </a>
                    </li>
                    <li>
                        <a href="{{route('user.getAllCustomers')}}">
                            <i class="fa-brands fa-osi"></i>
                            All Customers
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(auth()->user()->hasRole('super_admin'))
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-tasks"></i>
                    <span class="nav-label">Roles</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">
                    <!-- <li>
                        <a href="{{route('role.create')}}">
                            <span class="fa fa-plus"></span>
                            Add Role
                        </a>
                    </li> -->
                    <li>
                        <a href="{{route('role.index')}}">
                            <i class="fa-brands fa-osi"></i>
                            All Roles
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(auth()->user()->hasAnyRole(['vendor']) && !is_alternative_login())
            <li>
                <a href="{{ route('alternative-users.index') }}">
                    <i class="sidebar-item-icon fa fa-users"></i>
                    <span class="nav-label">Users</span>
                </a>
            </li>
            @endif

            @if(auth()->user()->hasAnyRole('admin|super_admin'))
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa-brands fa-adn"></i>
                    <span class="nav-label">Advertise</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="{{route('advertisement.create')}}">
                            <span class="fa fa-plus"></span>
                            Add New
                        </a>
                    </li>
                    <li>
                        <a href="{{route('advertisement.index')}}">
                            <i class="fa-brands fa-osi"></i>
                            All Lists
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(auth()->user()->hasAnyRole('super_admin|admin'))
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-cogs"></i>
                    <span class="nav-label">Settings</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="{{ route('settings.sastowholesale-mall.index') }}">
                            <i class="fa-brands fa-gg-circle"></i>
                            Sasto Wholesale Mall
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('settings.sms.index') }}">
                            <i class="fa-brands fa-gg-circle"></i>
                            <span>SMS Settings</span>
                        </a>
                    </li>
                    @if(auth()->user()->hasAnyRole('super_admin|admin'))
                    <li>
                        <a href="{{ route('settings.notification.index') }}">
                            <i class="fa-brands fa-gg-circle"></i>
                            <span>Test Notifications</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

        </ul>
    </div>
</nav>
