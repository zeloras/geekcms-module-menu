<?php

namespace GeekCms\Menu\Libs\Admin;

use GeekCms\Menu\Libs\MenuItem;
use Nwidart\Menus\Presenters\Presenter;

class AdminSidenav extends Presenter
{
    /**
     * {@inheritdoc}
     */
    public function getOpenTagWrapper()
    {
        return PHP_EOL;
    }

    /**
     * {@inheritdoc}
     */
    public function getCloseTagWrapper()
    {
        return PHP_EOL;
    }

    /**
     * {@inheritdoc}
     */
    public function getMenuWithoutDropdownWrapper($item)
    {
        $item = MenuItem::make($item->getProperties());
        $is_active = $this->getActiveState($item);

        return '
        <li class="purple '.$is_active.'">
            <a href="'.$item->getUrl().'">
                '.$item->getIcon($is_active).'
                <span class="lbl">'.\Translate::get($item->title).'</span>
            </a>
        </li>';
    }

    /**
     * {@inheritdoc}
     */
    public function getActiveState($item)
    {
        $request_item = (string) $item->getRequest();
        $request_real = (string) \Request::getRequestUri();
        $match = preg_match('@'.$request_item.'@ius', $request_real);
        if ($match) {
            $request_item_cnt = \count(explode(DIRECTORY_SEPARATOR, $request_item));
            $request_real_cnt = \count(explode(DIRECTORY_SEPARATOR, $request_real)) - 1;
            if ($request_real_cnt === $request_item_cnt || $request_item_cnt > 1 && $request_real_cnt >= $request_item_cnt) {
                $match = true;
            } else {
                $match = false;
            }
        }

        return $match ? 'opened' : '';
    }

    /**
     * {@inheritdoc}
     */
    public function getDividerWrapper($divider_name = null)
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getMenuWithDropDownWrapper($item)
    {
        $active = null;

        foreach ($item->getChilds() as $sitem) {
            if ($this->getActiveState($sitem)) {
                $active = 'opened';

                break;
            }
        }

        $item_custom = MenuItem::make($item->getProperties());

        return '
        <li class="purple with-sub '.$active.'">
	            <span>
	                '.$item_custom->getIcon($active).'
	                <span class="lbl">'.\Translate::get($item_custom->title).'</span>
	            </span>
            <ul>
                '.$this->getChildMenuItems($item).'
            </ul>
        </li>'.PHP_EOL;
    }
}
