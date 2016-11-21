<header>
	<nav class="nav has-shadow">
		<div class="container">
			<div class="nav-left">
				@if ($items = $menu->get_items())
					@foreach ($items as $item)
						<a class="nav-item is-tab" href="{{ $item->get_link() }}">{{ $item->get_title() }}</a>
						@if (!empty($item->get_children()))
							@foreach ($item->get_children() as $child_item)
								<a class="nav-item is-tab" href="{{ $child_item->get_link() }}">{{ $child_item->get_title() }}</a>
							@endforeach
						@endif
					@endforeach
				@endif
			</div>
		</div>
	</nav>
</header>
