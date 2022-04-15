<header id="main-header">
    <h2>
        <label for="nav-toggle">
            <span class="fas fa-bars"></span>
        </label>
        Procedūros
    </h2>
    <div class="user-wrapper">
        <div>
            <ul id="nav-ul">
                <li id="nav-li">
                    <a  id="nav-a">Gyd. odontologas <i class="fas fa-angle-down"></i> </a>
                    <ul id="nav-ul" class="dropdown">      
                        <li id="nav-li">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button id="out" type="submit"><i id="out" class ="fas fa-power-off"></i>Atsijungti</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</header>