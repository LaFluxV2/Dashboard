<div class="col-md-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Assign Roles to Users / Groups</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            {!!Form::open(array('url' => Request::url(), 'method' => 'get')) !!}

            {{--<div class="col-md-4 col-sm-4 col-xs-12 form-group">--}}
            {{--{!! Form::label('filter_group', 'User Groups') !!}--}}
            {{--{!! Form::select('filter_group', array('0'=>'--Select--') + ExtensionsValley\Dashboard\Models\Group::getGroups()->toArray(), \Input::has('filter_group') ? \Input::get('filter_group') : '', [--}}
            {{--'class'       => 'form-control select2',--}}
            {{--]) !!}--}}
            {{--</div>--}}

            <div class="col-md-4 col-sm-4 col-xs-12 form-group">
                {!! Form::label('filter_user', 'Users') !!}
                {!! Form::select('filter_user', array('0'=>'--Select--') + ExtensionsValley\Dashboard\Models\User::getUsers()->toArray(),\Input::has('filter_user') ? \Input::get('filter_user') : '' , [
                    'class'       => 'form-control select2',
              ]) !!}
                <span class="error_red">{{ $errors->first('filter_user') }}</span>


            </div>
            <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4 form-group">
                {!! Form::label('filter_role', 'Roles') !!}
                {!! Form::select('filter_role',array('0'=>'--Select--') + ExtensionsValley\Dashboard\Models\Roles::getRoles()->toArray(),\Input::has('filter_role') ? \Input::get('filter_role') : '' , [
                    'class'       => 'form-control js-example-responsive filter_role select2',
                ]) !!}
                <span class="error_red">{{ $errors->first('filter_role') }}</span>

            </div>

            <div class="form-group pull-right">
                <div class="col-md-12 col-sm-2 col-xs-2 ">
                    <br>
                    <a href="#" onclick="assigncourseAction(this);" data-action="/admin/assignusers"
                       class="btn btn-primary">Assign</a>
                    <a href="{{Request::url()}}" class="btn btn-dark">Clear</a>
                    <button type="submit" class="btn btn-success">Filter</button>
                </div>
            </div>

            {{--<div class="form-group pull-right">--}}
            {{--<div class="col-md-12 col-sm-2 col-xs-2 ">--}}
            {{--<br>--}}
            {{--<a href="#" onclick="assigncourseAction(this);" data-action="/admin/assignusers"--}}
            {{--class="btn btn-primary">Assign</a>--}}
            {{--<a href="#" onclick="removecourseAction(this);" data-action="/admin/removeusers"--}}
            {{--class="btn btn-danger">Remove</a>--}}
            {{--</div>--}}
            {{--</div>--}}

            {!! Form::token() !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>


<script type="text/javascript">
    function assigncourseAction(thisitem) {
        var sel_length = $('.cid_checkbox:checked').length;
        var filter_role = jQuery('#filter_role').val();
//        var filter_group = jQuery('#filter_group').val();
        var filter_user = jQuery('#filter_user').val();

//        if (filter_group <= 0 && filter_user <= 0) {
//            alert("Please select a User or Group to assign a Role ..!");
//            return false;
//        }

        if (filter_user <= 0) {
            alert("Please select a User to assign a Role ..!");
            return false;
        }

        if (filter_role <= 0) {
            alert("Please select a Role to assign ..!");
            return false;
        }

        else {
            jQuery('#admin_listing').append('<input type="text" id="filter_role" name="filter_role" value="' + filter_role + '" />');
//            jQuery('#admin_listing').append('<input type="text" id="filter_group" name="filter_group" value="' + filter_group + '" />');
            jQuery('#admin_listing').append('<input type="text" id="filter_user" name="filter_user" value="' + filter_user + '" />');
            jQuery('#admin_listing').attr("action", jQuery(thisitem).attr('data-action'));
            jQuery('#admin_listing').submit();
        }
    }

    function removecourseAction(thisitem) {
        var sel_length = $('.cid_checkbox:checked').length;
        var filter_role = jQuery('#filter_role').val();

        if (sel_length <= 0) {
            alert("Please select at least one record to perform an action!");
            return false;
        }
        else {
            jQuery('#admin_listing').append('<input type="text" id="filter_role" name="filter_role" value="' + filter_role + '" />');
//            jQuery('#admin_listing').append('<input type="text" id="filter_group" name="filter_group" value="' + filter_group + '" />');
            jQuery('#admin_listing').attr("action", jQuery(thisitem).attr('data-action'));
            jQuery('#admin_listing').submit();
        }
    }
</script>
