<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
    <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu"
        aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">Savora Junction Resto Admin</h5> <button type="button" class="btn-close"
                data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
            <ul class="nav flex-column">
                <li class="nav-item"> <a class="nav-link d-flex align-items-center gap-2 {{ Request::is('beranda*') ? 'active' : '' }}" aria-current="page"
                        href="{{ url('beranda') }}"> <i class="fas fa-chart-line" aria-hidden="true"></i>
                        Beranda
                    </a> </li>
                <li class="nav-item"> <a class="nav-link d-flex align-items-center gap-2 {{ Request::is('article*') ? 'active' : '' }}"
                        href="{{ url('/article') }}"> <i class="fas fa-newspaper" aria-hidden="true"></i>
                        Artikel
                    </a> </li>
                <li class="nav-item"> <a class="nav-link d-flex align-items-center gap-2 {{ Request::is('menu*') ? 'active' : '' }}"
                        href="{{ url('/menu') }}"> <i class="fas fa-utensils" aria-hidden="true"></i>
                        Menu
                    </a> </li>
                <li class="nav-item"> <a class="nav-link d-flex align-items-center gap-2 {{ Request::is('reservation*') ? 'active' : '' }}"
                        href="{{ url('/reservation')}}"> <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                        Reservasi
                    </a> </li>
                <li class="nav-item"> <a class="nav-link d-flex align-items-center gap-2 {{ Request::is('testimonial*') ? 'active' : '' }}""
                        href="{{ url('/testimonial') }}"> <i class="fas fa-star" aria-hidden="true"></i>
                        Testimoni
                    </a> </li>

                <li class="nav-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                    <a class="nav-link d-flex align-items-center gap-2 text-danger" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt" aria-hidden="true"></i>
                        Keluar
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
