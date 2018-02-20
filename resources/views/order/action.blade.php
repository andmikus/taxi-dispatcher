@unless(auth()->user()->isDriver())
    <a href="{!! route('order.edit', compact('order')) !!}" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-edit"></i> Edit
    </a>
@endunless