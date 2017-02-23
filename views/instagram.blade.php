<div class="columns">
    @foreach($instagram as $url)
        <div class="column is-2">
            <div style="height: 200px; width: 100%; background-size: cover; background-image: url({{ $url }})"></div>
        </div>
    @endforeach
</div>
