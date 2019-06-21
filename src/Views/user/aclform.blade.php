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
        $action = 'extensionsvalley.admin.setpermission2';
        ?>
        <div class="x_panel">
            {!!Form::open(array('route' => $action, 'method' => 'post','onsubmit' => 'return ConfirmCheck()'))!!}
            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group {{ $errors->has('group') ? 'has-error' : '' }} control-required">
                        {!! Form::label('role_id', 'User Role') !!}
                        {!! Form::select('role_id', array("0"=> " Choose Group")+ExtensionsValley\Dashboard\Models\Roles::getRoles()->toArray(), (\Input::has('id')) ? Input::get('id') : null, [
                            'class'       => 'form-control js-permission-role select2',
                            'required'    => 'required'
                        ]) !!}
                    </div>
                </div>
                <input type="hidden" name="current_user_group" id="current_user_group" value="1">

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group control-required" style="margin-top: 25px;">
                        {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            </div>
            {{--Selecting Firm and Department--}}
            <br>
            <br>
            <?php
            $menugroups = new Illuminate\Support\Collection;
            \Event::fire('admin.menu.groups', [$menugroups]);
            ?>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <table class="table table-responsive">
                            <tr class="pull-right">
                                <th>Menus</th>
                                <th>Order</th>
                                <th>
                                    <input type="checkbox" id="view_all_permissions" class="flat ch_box">
                                    View
                                </th>
                                <th>
                                    <input type="checkbox" id="add_all_permissions" class="flat ch_box">
                                    Add
                                </th>
                                <th>
                                    <input type="checkbox" id="edit_all_permissions" class="flat ch_box">
                                    Edit
                                </th>
                                <th>
                                    <input type="checkbox" id="delete_all_permissions" class="flat ch_box">
                                    Delete
                                </th>
                                <th>
                                    <input type="checkbox" id="check_all_permissions" class="flat ch_box">
                                    All
                                </th>
                            </tr>
                        </table>
                    </div>
                </div>

                @if(sizeof($menugroups->all()))
                    <?php
                    $count = 1;
                    $maincounter = 0;
                    $subcounter = 0;
                    $subsubcounter = 0;
                    ?>
                    @foreach($menugroups as $key)
                        <?php
                        if (sizeof($result)) {
                            $main_menu_data = $result->Where('acl_key', $key['acl_key'])
                                ->Where('role_id', \Input::get('id'))
                                ->Where('level', 0)
                                ->first();
                        } else {
                            $main_menu_data = [];
                        }
                        if (isset($key['main_menu_key'])) {
                            $main_menu_key = $key['main_menu_key'];
                        } else {
                            $main_menu_key = "No key set";
                        }
                        ?>
                        @if(!empty($key))
                            @foreach($key['sub_menu'] as $sub_key)
                                <?php
                                if (sizeof($result)) {
                                    $sub_menu_data = \DB::table('acl_permission')->Where('acl_key', $sub_key['acl_key'])
                                        ->Where('role_id', \Input::get('id'))
                                        ->Where('level', 1)
                                        ->first();
                                } else {
                                    $sub_menu_data = [];
                                }
                                if (isset($sub_key['sub_menu_key'])) {
                                    $sub_menu_key = $sub_key['sub_menu_key'];
                                } else {
                                    $sub_menu_key = "No key set";
                                }
                                ?>
                                @if(isset($sub_key['sub_menu_key']))
                                    @if( $main_menu_key == $sub_key['sub_menu_key'])
                                        @if(!empty($sub_key))
                                            @foreach($sub_key['sub_sub_menu'] as $sub_sub_key)
                                                @if(isset($sub_sub_key['sub_sub_menu_key']))
                                                    @if( $sub_menu_key == $sub_sub_key['sub_sub_menu_key'])
                                                        <?php
                                                        if (sizeof($result)) {
                                                            $sub_sub_menu_data = $result->Where('acl_key', $sub_sub_key['acl_key'])
                                                                ->Where('role_id', \Input::get('id'))
                                                                ->Where('level', 2)
                                                                ->first();
                                                        } else {
                                                            $sub_sub_menu_data = [];
                                                        }
                                                        ?>
                                                        <div class="row">
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                <?php
                                                                $skip_main_menu = 0;
                                                                if (isset($temp_key_acl)) {
                                                                    if ($temp_key_acl == $key['acl_key']) {
                                                                        $skip_main_menu = 1;
                                                                    }
                                                                } else {
                                                                    $skip_main_menu = 0;
                                                                }
                                                                ?>
                                                                @if($skip_main_menu == 0)
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                                                        <table class="table table-responsive">
                                                                            <tr class="pull-right">
                                                                                <td>{!! $key['menu_icon'] !!}
                                                                                    {{$key['menu_text']}}
                                                                                    <input type="hidden"
                                                                                           name="main_menu_text[]"
                                                                                           value="{{$key['menu_text']}}"/>
                                                                                    <input type="hidden"
                                                                                           name="main_menu_icon[]"
                                                                                           value="{{$key['menu_icon']}}"/>
                                                                                    <input type="hidden"
                                                                                           name="main_menu_acl_key[]"
                                                                                           value="{{$key['acl_key']}}"/>
                                                                                </td>
                                                                                <td><input type="number"
                                                                                           name="main_menu_order[]"
                                                                                           style="width: 50px;"
                                                                                           @if(!empty($main_menu_data->ordering))
                                                                                           value="{{$main_menu_data->ordering}}"
                                                                                        @endif
                                                                                    /></td>
                                                                                <td><input type="checkbox"
                                                                                           @if(!empty($main_menu_data->view)) checked="checked"
                                                                                           @endif
                                                                                           name="main_menu_view_{{$maincounter}}"
                                                                                           class="view_chk flat ch_box"/>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                @else
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                                                    </div>
                                                                @endif
                                                                <?php $temp_key_acl = $key['acl_key']; ?>
                                                                <?php
                                                                $skip_sub_menu = 0;
                                                                if (isset($temp_sub_key_acl)) {
                                                                    if ($temp_sub_key_acl == $sub_key['acl_key']) {
                                                                        $skip_sub_menu = 1;
                                                                    }
                                                                } else {
                                                                    $skip_sub_menu = 0;
                                                                }
                                                                ?>
                                                                @if($skip_sub_menu == 0)
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                                                        <table class="table table-responsive">
                                                                            <tr class="pull-right">

                                                                                <td>{!! $sub_key['menu_icon'] !!} {{$sub_key['menu_text']}}
                                                                                    <input type="hidden"
                                                                                           name="sub_menu_text[]"
                                                                                           value="{{$sub_key['menu_text']}}"/>
                                                                                    <input type="hidden"
                                                                                           name="sub_menu_icon[]"
                                                                                           value="{{$sub_key['menu_icon']}}"/>
                                                                                    <input type="hidden"
                                                                                           name="sub_menu_acl_key[]"
                                                                                           value="{{$sub_key['acl_key']}}"/>
                                                                                    <input type="hidden"
                                                                                           name="sub_menu_parent_acl_key[]"
                                                                                           value="{{$key['acl_key']}}"/>
                                                                                </td>
                                                                                <td><input type="number"
                                                                                           name="sub_menu_order[]"
                                                                                           style="width: 50px;"
                                                                                           @if(!empty($sub_menu_data->ordering))
                                                                                           value="{{$sub_menu_data->ordering}}"
                                                                                        @endif
                                                                                    /></td>
                                                                                <td><input type="checkbox"
                                                                                           @if(!empty($sub_menu_data->view)) checked="checked"
                                                                                           @endif
                                                                                           name="sub_menu_view_{{$subcounter}}"
                                                                                           class="view_chk flat ch_box"/>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                @else
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                                                    </div>
                                                                @endif
                                                                <?php $temp_sub_key_acl = $sub_key['acl_key']; ?>
                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                                                    <table class="table table-responsive">
                                                                        <tr class="pull-right">
                                                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                {{$sub_sub_key['menu_text']}}
                                                                                <input type="hidden"
                                                                                       name="sub_sub_menu_link[]"
                                                                                       value="{{$sub_sub_key['link']}}"/>
                                                                                <input type="hidden"
                                                                                       name="sub_sub_menu_text[]"
                                                                                       value="{{$sub_sub_key['menu_text']}}"/>
                                                                                <input type="hidden"
                                                                                       name="sub_sub_menu_acl_key[]"
                                                                                       value="{{$sub_sub_key['acl_key']}}"/>
                                                                                <input type="hidden"
                                                                                       name="sub_sub_menu_parent_acl_key[]"
                                                                                       value="{{$sub_key['acl_key']}}"/>
                                                                                <input type="hidden"
                                                                                       name="sub_sub_menu_vendor[]"
                                                                                       value="{{$sub_sub_key['vendor'] ?? 0}}"/>
                                                                                <input type="hidden"
                                                                                       name="sub_sub_menu_namespace[]"
                                                                                       value="{{$sub_sub_key['namespace'] ?? 0}}"/>
                                                                                <input type="hidden"
                                                                                       name="sub_sub_menu_model[]"
                                                                                       value="{{$sub_sub_key['model'] ?? 0}}"/>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number"
                                                                                       name="sub_sub_menu_order[]"
                                                                                       @if(!empty($sub_sub_menu_data->ordering))
                                                                                       value="{{$sub_sub_menu_data->ordering}}"
                                                                                    @endif
                                                                                />
                                                                            </td>
                                                                            <td>
                                                                                <?php $subsubcounter = $count - 1;?>
                                                                                <input type="checkbox"
                                                                                       name="sub_sub_menu_view_{{$subsubcounter}}"
                                                                                       class="view_chk flat ch_box view_{{$count}}"
                                                                                       @if(!empty($sub_sub_menu_data->view)) checked="checked" @endif />
                                                                            </td>
                                                                            <td>
                                                                                <input type="checkbox"
                                                                                       name="sub_sub_menu_add_{{$subsubcounter}}"
                                                                                       class="add_chk flat ch_box add_{{$count}}"
                                                                                       @if(!empty($sub_sub_menu_data->adding)) checked="checked" @endif />
                                                                            </td>
                                                                            <td>
                                                                                <input type="checkbox"
                                                                                       name="sub_sub_menu_edit_{{$subsubcounter}}"
                                                                                       class="edit_chk flat ch_box edit_{{$count}}"
                                                                                       @if(!empty($sub_sub_menu_data->edit)) checked="checked" @endif />
                                                                            </td>
                                                                            <td>
                                                                                <input type="checkbox"
                                                                                       name="sub_sub_menu_delete_{{$subsubcounter}}"
                                                                                       class="del_chk flat ch_box del_{{$count}}"
                                                                                       @if(!empty($sub_sub_menu_data->trash)) checked="checked" @endif />
                                                                            </td>
                                                                            <td><input type="checkbox"
                                                                                       id="check_current_row_{{$count}}"
                                                                                       class="chk_current_row flat ch_box"/>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                    <?php
                                                                    $count++;
                                                                    $subsubcounter++;
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endif
                                        <?php $subcounter++; ?>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                        <?php $maincounter++; ?>
                    @endforeach
                @endif
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
                <script>
                    function ConfirmCheck() {
                        return true;
                    }
                </script>
                {!! Form::token() !!}
                {!! Form::close() !!}
            </div>
        </div>
@stop

