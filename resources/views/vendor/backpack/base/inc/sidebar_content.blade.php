{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-th-list"></i> Users</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('category') }}"><i class="nav-icon la la-th-list"></i> Categories</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('product') }}"><i class="nav-icon la la-th-list"></i> Products</a></li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('product-specification') }}"><i class="nav-icon la la-th-list"></i> Product specifications</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('shopping-cart') }}"><i class="nav-icon la la-th-list"></i> Shopping carts</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('order') }}"><i class="nav-icon la la-th-list"></i> Orders</a></li>