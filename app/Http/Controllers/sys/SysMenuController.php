<?php

namespace App\Http\Controllers\sys;

use App\Models\SysMenu;
use App\Models\SysRole;
use App\Models\SysUser;
use App\util\AuthPermissionUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\VarDumper\Cloner\VarCloner;

class SysMenuController
{

    public function getTreeMenu(){

        $menus = SysMenu::all();

        $menuTree = array();

        foreach ($menus as $menu){

            if ($menu->parent_id === 0){

                $CTree = array();

                foreach ($menus as $menu2){
                    if ($menu2->parent_id === $menu->menu_id){
                        $MTree = array();

                        foreach ($menus as $menu3){
                            if ($menu3->parent_id === $menu2->menu_id){
                                array_push($MTree,$menu3);
                            }
                        }

                        $menu2->childMenu = $MTree;

                        array_push($CTree,$menu2);
                    }

                }
                $menu->childMenu = $CTree;

                array_push($menuTree,$menu);
            }
        }

       return response()->json($menuTree);

    }


    public function getAuthMenu(Request $request){



        $userId = $request->session()->get('userId');


        $roles = SysUser::find($userId)->sysRoles()->get();

        $authMenus = [];
        $menuflag = [];

        foreach ($roles as $role){
            $menus = SysRole::find($role->role_id)->sysMenus()->get();

            foreach ($menus as $menu){
                if (!in_array($menu->menu_id,$menuflag)){
                    array_push($authMenus,$menu);
                    array_push($menuflag,$menu->menu_id);
                }
            }
        }


        //变为树结构
        $treeMenu = [];

        foreach ($authMenus as $menu){

            if ($menu->parent_id === 0){

                $CTree = array();

                foreach ($authMenus as $menu2){
                    if ($menu2->parent_id === $menu->menu_id){
                        $MTree = array();

                        foreach ($authMenus as $menu3){
                            if ($menu3->parent_id === $menu2->menu_id){
                                array_push($MTree,$menu3);
                            }
                        }

                        $menu2->childMenu = $MTree;

                        array_push($CTree,$menu2);
                    }

                }
                $menu->childMenu = $CTree;

                array_push($treeMenu,$menu);
            }
        }

        return response()->json($treeMenu);
    }


    public function menuView(Request $request){

        $userId = $request->session()->get('userId');

        if (!AuthPermissionUtil::AuthPermission('system:menu:view',$userId)){
            echo "没有权限";
            return;
        };

        return view('sys.menu.menu-list');
    }

    public function menuList(Request $request){

        $userId = $request->session()->get('userId');
        if (!AuthPermissionUtil::AuthPermission('system:menu:list',$userId)){
            echo "没有权限";
            return;
        };


        $menus = SysMenu::all();

        foreach ($menus as $menu){
            if ($menu->parent_id === 0){
                $menu->pName = '目录没有父级';
            }else{
                $pMenu = SysMenu::where('menu_id', $menu->parent_id)->first();
                $menu->pName = $pMenu->menu_name;
            }
        }

        return response()->json($menus);
    }

    public function menuAddPage(){
        return view('sys.menu.menu-add');
    }

    public function menuAdd(Request $request){

        $userId = $request->session()->get('userId');
        if (!AuthPermissionUtil::AuthPermission('system:menu:add',$userId)){
            echo "没有权限";
            return;
        };

        $menuName = $request->input('menuName');
        $menu_url = $request->input('menuUrl');
        $menuPerms= $request->input('menuPerms');
        $cat= $request->input('cat');
        $Pmenu= $request->input('Pmenu');

        DB::table('sys_menu')->insert([
            'menu_name' => $menuName,
            'menu_url' => $menu_url,
            'menu_perms' => $menuPerms,
            'parent_id' => $Pmenu,
            'menu_type' => $cat,

        ]);




    }


    public function menuEditPage(Request $request){

        $userId = $request->session()->get('userId');
        if (!AuthPermissionUtil::AuthPermission('system:menu:edit',$userId)){
            echo "没有权限";
            return;
        };

        return view('sys.menu.menu-edit');
    }


    public function menuEdit(Request $request){

        $userId = $request->session()->get('userId');
        if (!AuthPermissionUtil::AuthPermission('system:menu:edit',$userId)){
            echo "没有权限";
            return;
        };

        $menuId = $request->input('menuId');
        $menuName = $request->input('menuName');
        $menu_url = $request->input('menuUrl');
        $menuPerms= $request->input('menuPerms');
        $cat= $request->input('cat');
        $Pmenu= $request->input('Pmenu');


        DB::table('sys_menu')->where('menu_id', $menuId)->update([
                'menu_name' => $menuName,
                'menu_url' => $menu_url,
                'menu_perms' => $menuPerms,
                'parent_id' => $Pmenu,
                'menu_type' => $cat
            ]);
    }

    public function menuRemove(Request $request){

        $userId = $request->session()->get('userId');
        if (!AuthPermissionUtil::AuthPermission('system:menu:remove',$userId)){
            echo "没有权限";
            return;
        };

        $menuId = $request->input('menuId');


        $existence = DB::table('sys_role_menu')->where('menu_id', '=', $menuId)->first();


        if ($existence !== null){
            echo "有角色使用该菜单，无法删除！";
            return;
        }

        DB::table('sys_menu')->where('menu_id', '=', $menuId)->delete();
    }


    public function getAllML(){
        $MLs = SysMenu::where('menu_type', 'M')->get();

        return response()->json($MLs);
    }

    public function getAllCD(){
        $CDs = SysMenu::where('menu_type','C')->get();

        return response()->json($CDs);
    }

    public function getMenu(Request $request){
        $menuId = $request->input('menuId');

        $menu = SysMenu::where('menu_id', $menuId)->get();

        return response()->json($menu);
    }



}
