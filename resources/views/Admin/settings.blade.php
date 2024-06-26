@extends('Admin.layout')
@section('title')
Panel Setting {{ ucfirst($action) }}
@endsection
@php
    $parentRoute = $action == 'edit' ? route('settings.store' ,$settings->id) : route('settings.store');
    $parentButton = $action == 'edit'? 'Update' : 'Save';
@endphp
@section('content')
    <div class="row my-4">
        <div class="card-header mb-2">
            <h1>{{ ucfirst($action) }} Settings</h1>
        </div>
        <div class="card p-3">

            <form id="settingForm" action="{{ $parentRoute }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mt-2 mb-2">
                        <div class="form-group">
                            <label for="site_name">Site Name <small class="text-danger">( * )</small></label>
                            <input type="text" name="site_name"  @if($action == 'edit') value="{{ $settings->site_name }}" @endif placeholder="Site Name" class="form-control" data-type="required" data-name="Site Name">
                        </div>
                    </div>
                    <div class="col-md-6 mt-2 mb-2">
                        <div class="form-group">
                            <label for="site_url">Site URL <small class="text-danger">( * )</small></label>
                            <input type="text" name="site_url"  @if($action == 'edit') value="{{ $settings->site_url }}" @endif  placeholder="Site URL" class="form-control" data-type="required" data-name="Site URL">
                        </div>
                    </div>
                    <div class="col-md-4 mt-2 mb-2">
                        <div class="form-group">
                            <label for="favicon">Site Favicon <small class="text-danger">( * )</small></label>
                            <input type="file" id="favicon" name="favicon"class="form-control" @if($action == 'create')  data-type="required" data-name="Site Favicon" @endif>
                        </div>
                    </div>
                    <div class="col-md-4 mt-2 mb-2">
                        <div class="form-group">
                            <label for="logo">Site Main Logo <small class="text-danger">( * )</small></label>
                            <input type="file" id="logo" name="logo"class="form-control" @if($action == 'create') data-type="required" data-name="Site Main Logo" @endif>
                        </div>
                    </div>
                    <div class="col-md-4 mt-2 mb-2">
                        <div class="form-group">
                            <label for="light_logo">Site Light Logo </label>
                            <input type="file" id="light_logo" name="light_logo"class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4 mt-2 mb-2">
                        <div class="form-group">
                            <label for="light_logo">Meta Title <small class="text-danger">( * )</small></label>
                            <input type="text" placeholder="Meta Title"  @if($action == 'edit') value="{{ $settings->meta_title }}" @endif  name="meta_title"class="form-control" data-type="required" data-name="Meta Title">
                        </div>
                    </div>
                    <div class="col-md-4 mt-2 mb-2">
                        <div class="form-group">
                            <label for="light_logo">Meta Description <small class="text-danger">( * )</small></label>
                            <input type="text" placeholder="Meta Description" @if($action == 'edit') value="{{ $settings->meta_description }}"@endif name="meta_description"class="form-control" data-type="required" data-name="Meta Description">
                        </div>
                    </div>

                    <div class="col-md-4 mt-2 mb-2">
                        <div class="form-group">
                            <label for="light_logo">Meta Keywords <small>comma sperated</small> </label>
                            <input type="text" placeholder="Meta Keywords" @if($action == 'edit') value="{{ $settings->meta_keywords }}"@endif name="meta_keywords"class="form-control" >
                        </div>
                    </div>

                <div class="col-md-12 mb-3 mt-3">
                    <label class="switch">
                        <input type="checkbox" @if($action == 'edit' && $settings->email_send == 1) checked @endif class="switch-input" name="email_send">
                        <span class="slider round"></span>
                    </label>&nbsp; <strong class="text-primary mt-5">
                        Allow Mail Sending ? <small class="text-secondary">Allowing it will open mail sending for modules</small>
                    </strong>
            </div>
            <hr>

            <div class="col-md-12">
                <button class="btn-primary btn" id="submitBtn">{{ $parentButton }}</button>
            </div>
        </div>
            </form>
        </div>
    </div>
    @push('js')
    <script src="{{ asset('assets/custom/setting.js') }}"></script>
    @endpush

@endsection
