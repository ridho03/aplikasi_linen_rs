<nav class="navbar">

    <div class="nav-container">

        <!-- LEFT -->
        <div class="nav-left">
            <h1 class="logo">🏥 Linen RS</h1>
            <span class="menu">Dashboard</span>
        </div>

        <!-- RIGHT -->
        <div class="nav-right">
            <span class="user">👤 {{ Auth::user()->name }}</span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-danger btn-sm">Logout</button>
            </form>
        </div>

    </div>

</nav>