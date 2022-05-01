<div class="sidebar">
    <div class="sidebar-brand">
        <h2><span class="fas fa-tooth"></span> <span>Odontologijos klinika</span></h2>
    </div>
    <div class="sidebar-menu">
        <ul>
            @foreach ($links as $link)
                @if (!$link->dentistHidden || auth()->user()->usertype == Config::get('app.usertype_admin'))
                    <li>
                        <a href="{{ $link->href }}" class="{{ (request()->is($link->route)) ? 'active' : '' }}"><span class="{{ $link->icon }}"></span>
                            <span>{{ $link->name }}</span></a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>