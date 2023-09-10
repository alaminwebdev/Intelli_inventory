<?php

namespace App\Http\Controllers\Backend\SiteMenu\FrontendMenu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\FrontendMenu;
use App\Services\MenuService\MenuService;

class FrontendMenuController extends Controller
{
    private $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function view(){
        $menus = $this->menuService->getAll();
        return view('backend.site_menu.menu.menu-view', compact('menus'));
    }

    public function add(){
        return view('backend.site_menu.menu.menu-add');
    }

    

    public function singleStore(Request $request){
        $this->menuService->singleStore($request);
        return redirect()->route('frontend-menu.menu.view')->with('success','Well done! successfully inserted');
    }

    public function store(Request $request){
        $this->menuService->create($request);
        return redirect()->route('frontend-menu.menu.view')->with('success','Well done! successfully inserted');
    }

    public function edit($id){
        $this->menuService->edit($id);

        return view('backend.site_menu.menu.menu-add', compact('editData','menu_number'));
    }

}
