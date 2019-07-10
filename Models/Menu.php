<?php

namespace GeekCms\Menu\Models;

use App\Models\MainModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * @return HasMany
     */
    public function items()
    {
        return $this->hasMany(Item::class, 'menu_id', 'id')
            ->orderBy('position')
            ->whereNull('item_id');
    }

    /**
     * All items.
     *
     * @return HasMany
     */
    public function allItems()
    {
        return $this->hasMany(Item::class, 'menu_id', 'id')
            ->orderBy('position');
    }
}
