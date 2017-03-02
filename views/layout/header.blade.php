<header>
	<nav class="nav has-shadow">
		<div class="container">
			<div class="nav-center">
				@if ($items = $menu->get_items(0, 2))
					@foreach ($items as $index => $item)
						@if (!empty($item->get_children()))
							<span class="nav-item is-tab"><a href="javascript:void(0)">{{ $item->get_title() }}</a>
								<aside class="menu">
									<ul class="menu-list">
										@foreach ($item->get_children() as $child_item)
											<li><a href="{{ $child_item->get_link() }}">{{ $child_item->get_title() }}</a></li>
										@endforeach
									</ul>
								</aside>
							</span>
						@else
							<span class="nav-item is-tab"><a href="{{ $item->get_link() }}">{{ $item->get_title() }}</a></span>
						@endif
					@endforeach
				@endif
				{{ get_custom_logo() }}
				@if ($items = $menu->get_items(2, 2))
					@foreach ($items as $index => $item)
						@if (!empty($item->get_children()))
							<span class="nav-item is-tab"><a href="javascript:void(0)">{{ $item->get_title() }}</a>
								<aside class="menu">
									<ul class="menu-list">
										@foreach ($item->get_children() as $child_item)
											<li><a href="{{ $child_item->get_link() }}">{{ $child_item->get_title() }}</a></li>
										@endforeach
									</ul>
								</aside>
							</span>
						@else
							<span class="nav-item is-tab"><a href="{{ $item->get_link() }}">{{ $item->get_title() }}</a></span>
						@endif
					@endforeach
				@endif
			</div>
		</div>
	</nav>
</header>
