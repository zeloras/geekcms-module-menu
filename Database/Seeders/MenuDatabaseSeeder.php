<?php

namespace Modules\Menu\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Menu\Models\Item;
use Modules\Menu\Models\Menu;

class MenuDatabaseSeeder extends Seeder
{
    public function run()
    {
        Menu::truncate();
        Item::truncate();

        $menuRu = Menu::create([
            'name' => 'default-header',
            'lang' => 'ru',
        ]);

        $menuEn = Menu::create([
            'name' => 'default-header',
            'lang' => 'en',
        ]);

        $this->createRu($menuRu);
        $this->createEn($menuEn);
    }

    public function createRu($menu)
    {
        // home
        $menu->items()->save($home = new Item([
            'menu_id' => $menu->id,
            'position' => 0,
            'type' => 'item',
            'name' => 'Главная',
            'action' => [
                'route' => 'page.open',
                'params' => ['page' => 'home'],
            ],
            'options' => [],
        ]));

        // contacts
        $menu->items()->save($contacts = new Item([
            'menu_id' => $menu->id,
            'position' => 1,
            'type' => 'item',
            'name' => 'Контакты',
            'action' => [
                'route' => 'page.open',
                'params' => ['page' => 'contacts'],
            ],
            'options' => [],
        ]));

        // catalog
        $menu->items()->save($catalog = new Item([
            'menu_id' => $menu->id,
            'position' => 2,
            'type' => 'item',
            'name' => 'Каталог',
            'action' => [],
            'options' => [],
        ]));

        // catalog 1.1
        $catalog->items()->save($catalog1 = new Item([
            'menu_id' => $menu->id,
            'item_id' => $catalog->id,
            'position' => 1,
            'type' => 'item',
            'name' => 'Книги',
            'action' => [],
            'options' => [],
        ]));

        // catalog 1.2
        $catalog->items()->save($catalog2 = new Item([
            'menu_id' => $menu->id,
            'item_id' => $catalog->id,
            'position' => 0,
            'type' => 'item',
            'name' => 'Журналы',
            'action' => [],
            'options' => [],
        ]));
    }

    public function createEn($menu)
    {
        // home
        $menu->items()->save($home = new Item([
            'menu_id' => $menu->id,
            'position' => 0,
            'type' => 'item',
            'name' => 'Home',
            'action' => [
                'route' => 'page.open',
                'params' => ['page' => 'home'],
            ],
            'options' => [],
        ]));

        // contacts
        $menu->items()->save($contacts = new Item([
            'menu_id' => $menu->id,
            'position' => 1,
            'type' => 'item',
            'name' => 'Contacts',
            'action' => [
                'route' => 'page.open',
                'params' => ['page' => 'contacts'],
            ],
            'options' => [],
        ]));

        // catalog
        $menu->items()->save($catalog = new Item([
            'menu_id' => $menu->id,
            'position' => 2,
            'type' => 'item',
            'name' => 'Catalog',
            'action' => [],
            'options' => [],
        ]));

        // catalog 1.1
        $catalog->items()->save($catalog1 = new Item([
            'menu_id' => $menu->id,
            'item_id' => $catalog->id,
            'position' => 1,
            'type' => 'item',
            'name' => 'Books',
            'action' => [],
            'options' => [],
        ]));

        // catalog 1.2
        $catalog->items()->save($catalog2 = new Item([
            'menu_id' => $menu->id,
            'item_id' => $catalog->id,
            'position' => 0,
            'type' => 'item',
            'name' => 'Journals',
            'action' => [],
            'options' => [],
        ]));
    }
}
