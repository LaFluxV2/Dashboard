<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <?php
        $user_roles = \DB::table('user_role')->Where('user_id', \Auth::user()->id)->pluck('role_id');
        ?>
        @if(!\Schema::hasTable('acl_permission'))
            <?php
            $menugroups = new Illuminate\Support\Collection;
            \Event::fire('admin.menu.groups', [$menugroups]);
            ?>
            <ul class="nav side-menu">
                @foreach($menugroups as $key)
                    <li><a>{!! $key['menu_icon'] !!} {{$key['menu_text']}} <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            @foreach($key['sub_menu'] as $subkey)
                                <li><a href="{{$subkey['link']}}">{{$subkey['menu_text']}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        @else
            <?php
            $main_menu = \DB::table('acl_permission')
                ->WhereIn('role_id', $user_roles)
                ->Where('view', 1)
                ->Where('level', 0)
                ->orderBy('ordering', 'ASC')
                ->get();
            ?>
            {{-- 1st Level Menu--}}
            <ul class="nav side-menu">
                @foreach($main_menu as $key)
                    @if($key->parent_menu == 0)
                        <li>
                            <a class="material-ripple"
                               data-ripple-color="#CB8962">{!! $key->icon !!} {{$key->menu_text}}
                                <span class="fa fa-chevron-down"></span></a>
                            @endif
                            <?php
                            // $sub_menu = $main_menu->Where('parent_menu', $key->id)->all();
                            $sub_menu = \DB::table('acl_permission')
                                ->WhereIn('role_id', $user_roles)
                                ->Where('view', 1)
                                ->Where('level', 1)
                                ->Where('parent_menu', $key->id)
                                ->orderBy('ordering', 'ASC')
                                ->get();
                            // print_r($sub_menu);
                            ?>
                            {{-- 2nd Level Menu--}}
                            <ul class="nav child_menu">
                                @foreach($sub_menu as $subkey)
                                    <li>
                                        <a href="#" class="material-ripple"
                                           data-ripple-color="#CB8962">
                                            <!-- <i class="fa fa-arrow-right" aria-hidden="true"></i> -->
                                            <b>{{$subkey->menu_text}}</b>
                                            <span class="fa fa-chevron-down"></span></a>
                                        <?php
                                        // $sub_menu = $main_menu->Where('parent_menu', $key->id)->all();
                                        $sub_sub_menu = \DB::table('acl_permission')
                                            ->WhereIn('role_id', $user_roles)
                                            ->Where('view', 1)
                                            ->Where('level', 2)
                                            ->Where('parent_menu', $subkey->id)
                                            ->orderBy('ordering', 'ASC')
                                            ->get();
                                        ?>
                                        {{--3rd Level Menu--}}
                                        <ul class="nav child_menu">
                                            @foreach($sub_sub_menu as $subsubkey)
                                                <li>
                                                    <a href="{{$subsubkey->link}}" class="material-ripple"
                                                       data-ripple-color="#CB8962">
                                                        <!-- <i class="fa fa-circle-thin" aria-hidden="true"></i> -->
                                                        {{$subsubkey->menu_text}}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        @endforeach
            </ul>
        @endif
    </div>
</div>



