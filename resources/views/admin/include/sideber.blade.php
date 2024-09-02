<div id="sidebar" class="sidebar responsive ace-save-state">
    <script type="text/javascript">
        try{ace.settings.loadState('sidebar')}catch(e){}
    </script> 
    <ul class="nav nav-list">
        <li class="@if(Request::segment(1) == 'dashboard' ) active @endif">
            <a href="{{ route('dashboard') }}">
                <i class="menu-icon fa fa-tachometer"></i>
                <span class="menu-text"> Dashboard </span>
            </a>
            <b class="arrow"></b>
        </li>

        {{-- product section --}}
        <li class="@if(in_array(Request::segment(1), ['products', 'categories', 'subcategories', 'brands','product'])) active open @endif">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-archive"></i>
                <span class="menu-text">
                    Product Area
                </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            
            <ul class="submenu">
                <li class="{{ request()->routeIs('products.index') ? 'active' : '' }}">
                    <a href="{{route('products.index')}}">
                        Product List
                    </a>
                </li>
            </ul>
            <ul class="submenu">
                <li class="{{ request()->routeIs('products.create') ? 'active' : '' }}">
                    <a href="{{route('products.create')}}">
                        Add Product
                    </a>
                </li>
            </ul>
            
            
        </li>


        {{-- product section --}}
        <li class="@if(in_array(Request::segment(1), ['products', 'categories', 'subcategories', 'brands'])) active open @endif">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-shopping-cart"></i>
                <span class="menu-text">
                    Order
                </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            {{-- {{ request()->routeIs('products.index') ? 'active' : '' }} --}}
            <ul class="submenu">
                <li class="">
                    <a href="{{route('orders')}}">
                        Order
                    </a>
                </li>
            </ul>
        </li>
    </ul>
    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>
</div>






