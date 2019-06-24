<div class="col-md-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h5>Advanced Search Filter</h5>
        </div>
        <div class="x_content">
            {!!Form::open(array('url' => Request::url(), 'method' => 'get')) !!}
            <div class="row>">
                 <div class="col-md-2 col-lg-2 col-sm-12 col-xs-12 form-group">
                    {!! Form::label('filter_role', 'Role') !!}
                    {!! Form::select('filter_role', array('0'=>'--Select--') + ExtensionsValley\Dashboard\Models\Roles::getRoles()->toArray(), \Input::has('filter_role') ? \Input::get('filter_role') : '', [
                        'class'       => 'form-control input-sm',
                  ]) !!}
                </div>
                <div class="col-md-2 col-lg-2 col-sm-12 col-xs-12 form-group">
                    {!! Form::label('filter_status', 'User Status') !!}
                    {!! Form::select('filter_status', array('-1'=>'--Select--','0' => 'Unpublished','1' => 'Published')  ,\Input::has('filter_status') ? \Input::get('filter_status') : '' , [
                        'class'       => 'form-control input-sm js-example-responsive filter_status',
                    ]) !!}
                </div>
            </div>

                <div class="form-group pull-right">
                    <div class="col-md-12 col-sm-2 col-xs-2 ">
                        <br>
                            <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-filter"></i>  Filter</button>
                            <a href="{{Request::url()}}" class="btn btn-sm btn-danger"><i class="fa fa-close"></i> Clear</a>
                    </div>
                </div>
            
            {!! Form::token() !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
