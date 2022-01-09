<!-- SIDEBAR START -->
<nav class="sidebar sidebar-offhasPermissionTovas" id="sidebar">
    <ul class="nav">
        @if(auth()->user()->is_profile_completed == 1)
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Access Business Unit Page') || auth()->user()->hasPermissionTo('Access Outlet Page'))
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#business" aria-expanded="false" aria-controls="ui-basic">
                <i class="icon-briefcase menu-icon"></i>
                <span class="menu-title">Business</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="business">
                <ul class="nav flex-column sub-menu">
                    @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Access Business Unit Page'))
                    <li class="nav-item"> <a class="nav-link" href="{{ route('business-unit.index') }}">Business Unit</a></li>
                    @endif
                    @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Access Outlet Page'))
                    <li class="nav-item"> <a class="nav-link" href="{{ route('outlet.index') }}">Outlet</a></li>
                    @endif
                </ul>
            </div>
        </li>
        @endif
        @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Access Category Page') || auth()->user()->hasPermissionTo('Access Product Page'))
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#inventory" aria-expanded="false" aria-controls="ui-basic">
                <i class="icon-box menu-icon"></i>
                <span class="menu-title">Inventory</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="inventory">
                <ul class="nav flex-column sub-menu">
                    @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Access Category Page'))
                    <li class="nav-item"> <a class="nav-link" href="{{ route('category.index') }}">Category</a></li>
                    @endif
                    @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Access Product Page'))
                    <li class="nav-item"> <a class="nav-link" href="{{ route('product.index') }}">Product</a></li>
                    @endif
                </ul>
            </div>
        </li>
        @endif
        @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Access Employee Page') || auth()->user()->hasPermissionTo('Access Role Page') || auth()->user()->hasPermissionTo('Access Permission Page'))
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#employee" aria-expanded="false" aria-controls="ui-basic">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">Employee</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="employee">
                <ul class="nav flex-column sub-menu">
                    @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Access Employee Page'))
                    <li class="nav-item"> <a class="nav-link" href="{{ route('user.index') }}">Employee</a></li>
                    @endif
                    @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Access Role Page'))
                    <li class="nav-item"> <a class="nav-link" href="{{ route('role.index') }}">Role</a></li>
                    @endif
                    @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Access Permission Page'))
                    <li class="nav-item"> <a class="nav-link" href="{{ route('permission.roles_permission') }}">Permission</a></li>
                    @endif
                </ul>
            </div>
        </li>
        @endif
        @endif
        @if (auth()->user()->is_profile_completed == 0)
        <li class="nav-item">
            <a class="nav-link" href="{{ route('wizard.index') }}">
                <i class="icon-command menu-icon"></i>
                <span class="menu-title">Registration Wizard</span>
            </a>
        </li>
        @endif
        <!-- <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#discount" aria-expanded="false" aria-controls="ui-basic">
                <i class="icon-marquee-minus menu-icon"></i>
                <span class="menu-title">Discount</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="discount">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="#">For Business Unit</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">For Outlet</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">For Product</a></li>
                </ul>
            </div>
        </li> -->
        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('transaction.index') }}">
        <i class="icon-bag menu-icon"></i>
        <span class="menu-title">Transaction</span>
        </a>
        </li> --}}
        <!-- <li class="nav-item">
            <a class="nav-link" href="">
                <i class="icon-bar-graph menu-icon"></i>
                <span class="menu-title">Report</span>
            </a>
        </li> -->
        <!-- <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">UI Elements</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/buttons.html">Buttons</a></li>
                    <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/dropdowns.html">Dropdowns</a></li>
                    <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/typography.html">Typography</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                <i class="icon-columns menu-icon"></i>
                <span class="menu-title">Form elements</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="../../pages/forms/basic_elements.html">Basic Elements</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                <i class="icon-bar-graph menu-icon"></i>
                <span class="menu-title">Charts</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="../../pages/charts/chartjs.html">ChartJs</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                <i class="icon-grid-2 menu-icon"></i>
                <span class="menu-title">Tables</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="../../pages/tables/basic-table.html">Basic table</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
                <i class="icon-contract menu-icon"></i>
                <span class="menu-title">Icons</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="icons">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="../../pages/icons/mdi.html">Mdi icons</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">User Pages</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="../../pages/samples/login.html"> Login </a></li>
                    <li class="nav-item"> <a class="nav-link" href="../../pages/samples/register.html"> Register </a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#error" aria-expanded="false" aria-controls="error">
                <i class="icon-ban menu-icon"></i>
                <span class="menu-title">Error pages</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="error">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="../../pages/samples/error-404.html"> 404 </a></li>
                    <li class="nav-item"> <a class="nav-link" href="../../pages/samples/error-500.html"> 500 </a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../../pages/documentation/documentation.html">
                <i class="icon-paper menu-icon"></i>
                <span class="menu-title">Documentation</span>
            </a>
        </li> -->
    </ul>
</nav>
<!-- SIDEBAR END -->