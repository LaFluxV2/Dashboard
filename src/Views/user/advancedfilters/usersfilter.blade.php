<div class="col-md-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h5>Advanced Search Filter</h5>
            <ul class="nav navbar-right panel_toolbox">
                <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>
        </div>
        <div class="x_content">
            {!!Form::open(array('url' => Request::url(), 'method' => 'get')) !!}
            <div class="row>">
                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 form-group">
                    {!! Form::label('filter_role', 'Role') !!}
                    {!! Form::select('filter_role', array('0'=>'--Select--') + ExtensionsValley\Dashboard\Models\Roles::getRoles()->toArray(), \Input::has('filter_role') ? \Input::get('filter_role') : '', [
                        'class'       => 'form-control input-sm select2',
                  ]) !!}
                </div>
                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 form-group">
                    {!! Form::label('filter_status', 'User Status') !!}
                    {!! Form::select('filter_status', array('-1'=>'--Select--','0' => 'Unpublished','1' => 'Published')  ,\Input::has('filter_status') ? \Input::get('filter_status') : '' , [
                        'class'       => 'form-control input-sm js-example-responsive filter_status select2',
                    ]) !!}
                </div>
                <div class="form-group">
                    <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 form-group">
                        <br>
                        <a href="{{Request::url()}}" class="btn btn-sm btn-primary">Clear</a>
                        <button type="submit" class="btn btn-sm btn-success">Filter</button>
                    </div>
                </div>
            </div>

            {!! Form::token() !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
