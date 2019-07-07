<?php

namespace Modules\Menu\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'menu_items';

    protected $guarded = [];

    protected $with = ['items.items'];

    public function getUrlAttribute()
    {
        $url = '#';

        // route name
        if ($route = array_get($this->action, 'route')) {
            return route($route, array_get($this->action, 'params'));
        }

        // link
        if ($link = array_get($this->action, 'link')) {
            return $link;
        }

        if ($anhor = array_get($this->action, 'anhor')) {
            return $anhor;
        }

        return $url;
    }

    /**
     * Навигация.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    /**
     * Родительский элемент
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'item_id');
    }

    /**
     * Вложенные эелементы.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(self::class, 'item_id')
            ->orderBy('position')
        ;
    }

    /**
     * Парсим правила для форматирование url
     * route::page.open|page=home;method=post;par3=value3;par4=value4.
     *
     * @param $action
     */
    public function setActionAttribute($action = null)
    {
        if (!$action) {
            $action = 'anhor::#';
        }

        if (!\is_array($action)) {
            $routeRexex = '/(?:(?<class>.*)\::(?<method>[^|\n]+)(?:\||\n|$)+)?(?:(?<key>[^\|\;\=]+)\=(?<value>[^\|\;\n]+))?/';

            preg_match_all($routeRexex, $action, $actionMatch, PREG_SET_ORDER);

            $action = [
                array_get($actionMatch, '0.class', 'link') => array_get($actionMatch, '0.method'),
            ];

            $params = [];

            foreach ($actionMatch as $actionMatchGroup) {
                if ($key = array_get($actionMatchGroup, 'key')) {
                    $params[$key] = array_get($actionMatchGroup, 'value');

                    continue;
                }
            }

            if (\count($params)) {
                $action['params'] = $params;
            }
        }

        $this->attributes['action'] = serialize($action);
    }

    public function getActionAttribute()
    {
        return unserialize($this->attributes['action']);
    }

    public function setOptionsAttribute($options)
    {
        $this->attributes['options'] = serialize($options);
    }

    public function getOptionsAttribute()
    {
        return unserialize($this->attributes['options']);
    }
}
