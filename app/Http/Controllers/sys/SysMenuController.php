<?php

namespace App\Http\Controllers\sys;

use App\Models\SysMenu;

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
                        array_push($CTree,$menu2);
                    }

                }
                $menu->childMenu = $CTree;

                array_push($menuTree,$menu);
            }
        }

       return response()->json($menuTree);

    }



}
