<header>
	<nav class="nav has-shadow">
		<div class="container">
			<div class="nav-center">
				@if ($items = $menu->get_items(0, 2))
					@foreach ($items as $index => $item)
						<span class="nav-item is-tab"><a href="{{ $item->get_link() }}">{{ $item->get_title() }}</a>
						@if (!empty($item->get_children()))
							<aside class="menu">
								<ul class="menu-list">
									@foreach ($item->get_children() as $child_item)
										<li><a href="{{ $child_item->get_link() }}">{{ $child_item->get_title() }}</a></li>
									@endforeach
								</ul>
							</aside>
						@endif
						</span>
					@endforeach
				@endif
				{{ get_custom_logo() }}
				@if ($items = $menu->get_items(0, 2))
					@foreach ($items as $item)
						<span class="nav-item is-tab"><a href="{{ $item->get_link() }}">{{ $item->get_title() }}</a>
						@if (!empty($item->get_children()))
							<aside class="menu">
								<ul class="menu-list">
									@foreach ($item->get_children() as $child_item)
										<li><a href="{{ $child_item->get_link() }}">{{ $child_item->get_title() }}</a></li>
									@endforeach
								</ul>
							</aside>
						@endif
						</span>
					@endforeach
				@endif
			</div>
		</div>
	</nav>
</header>
