@extends('setup.template.default')

@section('title_menu', 'Customization')

@section('navbar')
    <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="padding: 0px !important">
        <ul class="navbar-nav menu_servicedesk">
            {{-- <li class="nav-item">
                <a href="#" class="nav-link">PALAPA RING OPERATION & MAINTENANCE</a>
            </li> --}}
            <?php 
            $id_type = isset($id_type)?$id_type:'';
            $path = "setup/Customization/$id_type";
            $type = \App\Model\TaskType::where('id_type',$id_type)->first();
            ?>
            <li class="nav-item">
                <a href="category" class="nav-link text-header {{request()->path() == $path.'/category' ? 'bg-primary':''}}">Category</a>
            </li>
            <!--<li class="nav-item">-->
            <!--    <a href="mode" class="nav-link text-header1 {{request()->path() == $path.'/mode' ? 'bg-primary':''}}">Mode</a>-->
            <!--</li>-->
            @if($id_type == 2)
            <li class="nav-item">
                <a href="checklist" class="nav-link text-header1 {{request()->path() == $path.'/checklist' ? 'bg-primary':''}}">Checklist</a>
            </li>
            @endif
            <li class="nav-item">
                <a href="impact" class="nav-link text-header1 {{request()->path() == $path.'/impact' ? 'bg-primary':''}}">Impact</a>
            </li>
            <li class="nav-item">
                <a href="priority" class="nav-link text-header1 {{request()->path() == $path.'/priority' ? 'bg-primary':''}}">Priority</a>
            </li>
            
         
            <li class="nav-item">
              <a href="status" class="nav-link text-header1 {{request()->path() == $path.'/status' ? 'bg-primary':''}}">Status</a>
            </li>
            
         
            <li class="nav-item pull-right" style="position: absolute; right: 0;">
                <a class="nav-link text-header1 bg-gray">{{isset($type->type_name)?$type->type_name:''}}</a>
            </li>
        </ul>
    </nav>
@endsection
@section('content')
    @yield('customization')
@endsection