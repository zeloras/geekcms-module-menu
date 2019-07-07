<?php

namespace Modules\Menu\Models;

use App\Models\MainModel;

class Menu extends MainModel
{
    public $rules = [
        'name' => ['required', 'max:255', 'min:1'],
        'lang' => ['required', 'max:3', 'min:1'],
    ];
    protected $table = 'menu';

    protected $with = ['items'];

    protected $guarded = [];

    protected $fillable = ['name', 'lang'];

    /**
     * Все эелементы навигации текущего меню.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(Item::class, 'menu_id', 'id')
            ->orderBy('position')
            ->whereNull('item_id')
        ;
    }

    /**
     * All items.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allItems()
    {
        return $this->hasMany(Item::class, 'menu_id', 'id')
            ->orderBy('position')
        ;
    }
}
