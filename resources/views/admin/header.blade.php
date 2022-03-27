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
                    <a  id="nav-a">Administratorius</a>
                    <ul id="nav-ul" class="dropdown">      
                        <li id="nav-li">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button id="nav-li" type="submit"><i class="fas fa-sign-out-alt"></i>Atsijungti</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</header>