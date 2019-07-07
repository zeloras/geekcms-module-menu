<a href="{{ route('admin.menu', ['menu' => $item->menu_id, 'item' => $item->id]) }}" class="btn btn-sm btn-info">
    <i class="fa fa-edit"></i>
</a>

<a href="{{ route('admin.menu.item.delete', ['item' => $item->id]) }}" class="btn btn-sm btn-danger" data-delete>
    <i class="fa fa-trash"></i>
</a>