<?php

namespace GeekCms\Menu\Libs;

use GeekCms\Menu\Models\Menu;
use Illuminate\Support\Collection;

class MenuBuilder
{
    /**
     * @var Collection
     */
    protected $storage;

    /**
     * @var bool
     */
    protected $_isLoad = false;

    /**
     * @var Menu
     */
    protected $menu;

    /**
     * Default empty menu.
     *
     * @var object
     */
    protected $default;

    /**
     * MenuBuilder constructor.
     */
    public function __construct()
    {
        $this->storage = ($this->storage) ? $this->storage : collect();
        $this->load();

        // default
        $this->default = (object)[
            'items' => [],
        ];
    }

    /**
     * Load menu with items to storage.
     */
    protected function load()
    {
        if (!$this->_isLoad) {
            $this->storage = Menu::all();
            $this->_isLoad = true;
        }
    }

    /**
     * Get menu by name.
     *
     * @param string $name
     * @param null|string $lang
     *
     * @return Menu|object|null
     */
    public function get($name, $lang = null)
    {
        $lang = $lang ?? config('app.locale');

        $this->menu = $this->storage
            ->where('lang', '=', $lang)
            ->where('name', '=', $name)
            ->first();

        return $this->menu ?? $this->default;
    }

    /**
     * Get all menus.
     *
     * @return Collection
     */
    public function getList()
    {
        return $this->storage;
    }

    /**
     * Refresh storage.
     *
     * @return $this
     */
    public function refresh()
    {
        $this->_isLoad = false;
        $this->load();

        return $this;
    }
}
