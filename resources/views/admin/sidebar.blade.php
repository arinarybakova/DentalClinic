<div class="sidebar">
    <div class="sidebar-brand">
        <h2><span class="fas fa-tooth"></span> <span>DentalClinic</span></h2>
    </div>
    <div class="sidebar-menu">
        <ul>
            @foreach ($links as $link)
                <li>
                    <a href="{{ $link->href }}" class="{{ (request()->is($link->route)) ? 'active' : '' }}"><span class="{{ $link->icon }}"></span>
                        <span>{{ $link->name }}</span></a>
                </li>
            @endforeach
        </ul>
    </div>
</div>