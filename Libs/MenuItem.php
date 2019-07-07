<?php

namespace Modules\Menu\Libs;

use Nwidart\Menus\MenuItem as MainMenuItem;

/**
 * @property string url
 * @property string route
 * @property string title
 * @property string name
 * @property string icon
 * @property int parent
 * @property array attributes
 * @property bool active
 * @property int order
 */
class MenuItem extends MainMenuItem
{
    /**
     * {@inheritdoc}
     */
    public function getIcon($default = null)
    {
        if (null !== $this->icon && '' !== $this->icon && !\is_array($this->icon)) {
            $additional_class = (empty($default)) ? '' : 'active';

            return '<i class="'.$this->icon.' '.$additional_class.'"></i>';
        }

        if (\is_array($this->icon) && isset($this->icon['svg']) && null !== $this->icon['svg']) {
            return $this->icon['svg'];
        }

        if (null === $default) {
            return $default;
        }

        return '<i class="'.$default.'"></i>';
    }
}
