@extends('Dashboard::dashboard.dashboard')
@section('content-header')

    <!-- Navigation Starts-->
    @include('Dashboard::dashboard.partials.headersidebar')
    <!-- Navigation Ends-->

@stop
@section('content-area')
    <div class="right_col" role="main">

        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                    <h2>{{$title}}</h2>
                </div>
            </div>
        </div>
        <?php
        if (isset($roles)) {
            $action = 'extensionsvalley.admin.updateroles';
        } else {
            $action = 'extensionsvalley.admin.saveroles';
        }
        if (isset($viewmode)) {
            $readonly = "readonly";
        } else {
            $readonly = "";
        }
        ?>
        <div class="x_panel">
            {!!Form::open(array('route' => $action, 'method' => 'post'))!!}
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }} control-required">
                        {!! Form::label('name', 'Name') !!} <span class="error_red">*</span>
                        {!! Form::text('name', isset($roles->name) ? $roles->name : \Input::old('name'), [
                            'class'       => 'form-control',
                            'placeholder' => 'Name',
                            'required'    => 'required',
                            $readonly
                        ]) !!}
                        <span class="error_red">{{ $errors->first('name') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }} control-required">
                        {!! Form::label('status', 'Status') !!} <span class="error_red">*</span>
                        {!! Form::select('status', array('1'=>'Publish','0'=>'Unpublish'), isset($roles->status) ? $roles->status :null, [
                            'class'       => 'form-control select2',
                            'required'    => 'required'
                        ]) !!}
                        <span class="error_red">{{ $errors->first('status') }}</span>

                    </div>
                </div>
            </div>

            @if(isset($roles->id))
                <Input type="hidden" name="roles_id" value="{{$roles->id}}"/>
            @endif

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <a onclick="history.go(-1);" class="btn btn-success pull-right">Cancel</a>
                    @if(!isset($viewmode))
                        {!! Form::submit('Submit', ['class' => 'btn btn-primary pull-right']) !!}
                    @endif
                </div>
            </div>
            <input type="hidden" name="accesstoken"
                   value="{{\Input::has('accesstoken') ? \Input::get('accesstoken') : ''}}"/>

            {!! Form::token() !!}
            {!! Form::close() !!}
        </div>
    </div>
@stop

