<?php

namespace GeekCms\Menu\Http\Controllers;

use App;
use Exception;
use GeekCms\Menu\Models\Item;
use GeekCms\Menu\Models\Menu;
use GeekCms\Pages\Models\Page;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use MenuBuilder;
use Route;
use function count;
use function is_array;

class AdminController extends Controller
{
    /**
     * Index admin page.
     *
     * @param null|Menu $menu
     * @param null|Item $item
     *
     * @return Factory|View
     * @throws Exception
     */
    public function index(Menu $menu = null, Item $item = null)
    {
        $menu_lang = data_get($menu, 'lang', App::getLocale());
        $elements = MenuBuilder::getList();
        try {
            $locales = getSupportedLocales();
        } catch (Exception $e) {
            $locales = [];
        }

        $pages = Page::where([
            ['type', '=', Page::PAGE_TYPE_PAGE],
            ['parent_id', '=', 0],
        ])->with(['children'])->get();
        $routes = Route::getRoutes();
        $template = (empty($menu)) ? 'menu::index' : 'menu::detail';

        // For change page titles for select menu
        foreach ($pages as $pkey => $page) {
            if ($page->lang !== $menu_lang) {
                foreach ($page->children as $pchild) {
                    if ($pchild->lang === $menu_lang) {
                        $pages[$pkey]->name = $pchild->name;
                        $pages[$pkey]->lang = $pchild->lang;
                    }
                }
            }
        }

        return view($template, [
            'elements' => $elements ?? collect(),
            'menu' => $menu,
            'locales' => $locales,
            'pages' => $pages ?? collect(),
            'item' => $item,
            'routes' => $routes,
        ]);
    }

    /**
     * Save item.
     *
     * @param null|Item $item
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function saveItem(Item $item = null, Request $request)
    {
        $item = ($item) ? $item : new Item();
        $item->fill($request->all());
        $item->save();

        return redirect()->route('admin.menu', ['menu' => $item->menu_id]);
    }

    /**
     * Create new navigation.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function createMenu(Request $request)
    {
        try {
            $locales = getSupportedLocales();
        } catch (Exception $e) {
            $locales = [];
        }

        $menu = new Menu();

        if ($request->isMethod('post')) {
            $data = $request->all();
            if ($menu->fill($data) && !$menu->validate($data)->fails()) {
                $menu->save();

                return redirect()->route('admin.menu', ['menu' => $menu->id]);
            }
        }

        return view('menu::create', ['locales' => $locales]);
    }

    /**
     * Save menu items.
     *
     * @param null|Menu $menu
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function saveMenu(Menu $menu = null, Request $request)
    {
        $sorts = json_decode($request->post('sorts', '[]'), true);

        if (is_array($sorts)) {
            $this->updatePositionItems($menu, $sorts);
        }

        return redirect()->back();
    }

    /**
     * Sort all items (recurs).
     *
     * @param Menu $menu
     * @param $sorts
     * @param null $itemId
     */
    protected function updatePositionItems(Menu $menu, $sorts, $itemId = null)
    {
        $menu->load('allItems');

        foreach ($sorts as $position => $element) {
            $id = (int)array_get($element, 'id', 0);
            $item = $menu->allItems->where('id', $id)->first();

            if ($item) {
                $item->position = $position;
                $item->item_id = $itemId;
                $item->save();
            }

            if (is_array($childs = array_get($element, 'children', []))) {
                $this->updatePositionItems($menu, $childs, $id);
            }
        }
    }

    /**
     * Delete item.
     *
     * @param Item $item
     *
     * @return RedirectResponse
     * @throws Exception
     *
     */
    public function deleteItem(Item $item)
    {
        $menu_id = $item->menu_id;
        $item->delete();

        return redirect()->route('admin.menu', ['menu' => $menu_id]);
    }

    /**
     * Delete navigation.
     *
     * @param Menu $menu
     *
     * @return RedirectResponse
     * @throws Exception
     *
     */
    public function deleteMenu(Menu $menu = null)
    {
        $menu->delete();

        return redirect()->route('admin.menu');
    }

    /**
     * Delete selected navigations.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     * @throws Exception
     *
     */
    public function deleteAllMenu(Request $request)
    {
        $get_menus = $request->get('items', '');
        $get_menus = explode(',', $get_menus);

        if (count($get_menus)) {
            $find_menu = Menu::whereIn('id', $get_menus);
            if ($find_menu->count()) {
                $find_menu->delete();
            }
        }

        return redirect()->route('admin.menu');
    }
}
