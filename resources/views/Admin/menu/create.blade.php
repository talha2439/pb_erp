@extends('Admin.layout')
@php
    if($action == 'create'){
        $title = 'Create';
        $parentRoute = route('menusettings.store');
        $parentButton = 'Save';
    }
    else{
        $title = "Edit";
        $parentRoute = route('menusettings.store' ,$menu->id);
        $parentButton = 'Update';
    }
    @endphp
@section('content')
@section('title')
{{ $title }} Menus - Submenus
@endsection

<style>
    .subContainer{
        display: none;
    }
    .icon-option {
            display: flex;
            align-items: center;
        }

        .icon-option i {
            margin-right: 10px;
        }

        .icon-display {
            margin-top: 10px;
        }

        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #aaaaaa7d!important;
            border-radius: 5px!important;
            padding: 4px!important;
            position: relative!important;
            top: 2px!important;
        }
        .light-style .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height: 1.8rem!important;
        }
        .select2-container .select2-selection--single {

        height: 38px!important;

        }
        .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 29.5px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #cccccc73!important;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";

  left: 4px;
  bottom: 5px!important;
  background-color: white!important;
  -webkit-transition: .4s;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.301);
  transition: .4s;
}

input:checked + .slider {
  background-color: #4821f3!important;
}

input:focus + .slider {
  box-shadow: 0 0 1px #4821f3!important;
}

input:checked + .slider:before {
  -webkit-transform: translateX(30px);
  -ms-transform: translateX(30px);
  transform: translateX(30px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

</style>

<!-- Collapsible Section -->
<div class="row my-4">

    <div class="card-header"><h1>{{ $title }} Menus</h1></div>
    <div class="card p-3">
        <form id="menuForm">
            @csrf
            <input type="hidden" value="{{ csrf_token() }}" id="csrf-token">
        <div class="row">
           <div class="col-md-4 menu_container">
        <div class="form-group">
            <label for="name">Menu Name</label>
            <input type="text" name="name" placeholder="Enter Menu Name" class="form-control mt-3 mb-3">
        </div>
    </div>
    <div class="col-md-4 menu_container">
        <div class="form-group">
            <label for="name">Menu Icon</label>
            <select name="icon" class="form-control mt-3 mb-3 iconDropDown">
                <option value=""> Please wait Fetching Icons</option>
            </select>
        </div>
    </div>
    <div class="col-md-4 menu_route">
        <div class="form-group menuInputRoute">
            <label for="name">Menu Route</label>
            <input type="text" name="route[]" placeholder="Enter Menu Route" class="form-control mt-3 mb-3">
        </div>
    </div>
    <div class="col-md-12 mb-3">


<label class="switch">
    <input type="checkbox">
    <span class="slider round"></span>
  </label>

    </div><hr>
    <div class="col-md-12 subContainer">

    </div>
    <div class="col-md-12 d-flex justify-content-end ">
        <a href="{{ route('menusettings.index') }}" class="btn btn-primary" style="margin-right: 10px">Menu List</a>
        <button class="btn btn-success" type="submit">{{ $parentButton }}</button>
    </div>
</div>

        </form>
    </div>
</div>





@push('js')
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/custom/menu-setting.js') }}"></script>
<script>
    let baseUrl = "{{ asset("") }}";
    let menuCheckroute = "{{ route('menusettings.check_routes') }}";
    let StoreMenuRoute = "{{ route('menusettings.store') }}";
    let menuIndexUrl   = "{{ route('menusettings.index') }}";
    let action         = "{{ $action }}";

    let menusData      = <?php echo isset($menu) && $menu ? json_encode($menu) : 0 ;?>;
</script>
@endpush
@endsection
