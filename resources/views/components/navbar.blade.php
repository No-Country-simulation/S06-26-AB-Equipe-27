 @props([
 'activePage',
 ])

 @php
 $activePage = $activePage ?? 'home';
 $user = auth()->user();
 $isCompany = $user && $user->company()->exists();
 @endphp

 <style>
     .navbar {
         background-color: rgba(255, 255, 255, .85);
         backdrop-filter: saturate(180%) blur(14px);
         -webkit-backdrop-filter: saturate(180%) blur(14px);
         border-bottom: 1px solid var(--color-border);
     }

     .navbar-brand {
         font-family: var(--font-display);
         font-weight: 700;
         color: var(--color-ink);
         font-size: 1.15rem;
         letter-spacing: -0.01em;
     }

     .brand-icon {
         background: linear-gradient(155deg, var(--color-primary), var(--color-primary-dark));
         color: #fff;
         border-radius: 9px;
         width: 34px;
         height: 34px;
         display: inline-flex;
         align-items: center;
         justify-content: center;
         margin-right: 10px;
         font-size: 1.05rem;
         box-shadow: 0 4px 10px -3px rgba(124, 58, 237, .55);
     }

     .navbar-collapse {
         gap: 1.5rem;
     }

     @media (min-width: 992px) {
         .navbar-collapse {
             align-items: center;
             justify-content: flex-end;
         }
     }

     .nav-link-custom {
         color: var(--color-muted);
         font-weight: 600;
         font-size: 0.88rem;
         padding: 0.55rem 1.05rem !important;
         border-radius: 999px;
         display: flex;
         align-items: center;
         gap: 0.5rem;
         transition: background-color .18s ease, color .18s ease;
         white-space: nowrap;
     }

     .nav-link-custom:hover {
         color: var(--color-ink);
         background-color: var(--color-primary-softer);
     }

     .nav-link-custom.active {
         background-color: var(--color-primary);
         color: #fff;
         box-shadow: 0 6px 14px -6px rgba(124, 58, 237, .55);
     }

     .navbar-actions {
         display: flex;
         align-items: center;
         gap: 0.9rem;
         flex-shrink: 0;
     }

     .icon-btn {
         color: var(--color-muted);
         font-size: 1.15rem;
         transition: color .18s ease;
     }

     .icon-btn:hover {
         color: var(--color-ink);
     }

     .navbar-toggler {
         width: 36px;
         height: 36px;
         display: inline-flex;
         align-items: center;
         justify-content: center;
         border-radius: 10px;
         background-color: var(--color-primary-softer);
     }

     .navbar-toggler:focus {
         box-shadow: none;
     }

     .navbar-toggler-icon {
         width: 18px;
         height: 18px;
         background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%237C3AED' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2.5' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
     }

     .avatar-badge {
         width: 36px;
         height: 36px;
         border-radius: 100%;
         background: linear-gradient(155deg, var(--color-primary), var(--color-primary-dark));
         color: #fff;
         font-weight: 700;
         font-size: 0.8rem;
         display: flex;
         align-items: center;
         justify-content: center;
     }

     .dropdown-menu {
         border: 1px solid var(--color-border);
         box-shadow: var(--shadow-pop);
         border-radius: 12px;
         padding: 0.5rem 0;
         margin-top: 0.5rem !important;
         top: 83% !important;
     }

     .dropdown-item {
         color: var(--color-body);
         font-weight: 500;
         transition: all 0.15s ease;
         padding: 0.5rem 1.25rem;
         font-size: .85rem;
     }

     .dropdown-item:hover {
         background-color: var(--color-primary-soft);
         color: var(--color-primary-dark);
     }

     .dropdown-item.active {
         background-color: var(--color-primary);
         color: #FFFFFF;
     }

     @media (min-width: 992px) {
         .nav-item.dropdown {
             position: relative;
         }

         .nav-item.dropdown .dropdown-menu {
             display: none;
         }

         .nav-item.dropdown:hover .dropdown-menu {
             display: block;
         }

         .nav-item.dropdown .dropdown-toggle::after {
             transition: transform 0.2s ease;
         }

         .nav-item.dropdown:hover .dropdown-toggle::after {
             transform: rotate(180deg);
         }
     }
 </style>

 {{-- NAVBAR SUPERIOR --}}
 <nav class="navbar navbar-expand-lg sticky-top py-2">
     <div class="container px-4">
         <a class="navbar-brand d-flex align-items-center" href="{{ url($isCompany ? '/dashboard' : '/jobs') }}">
             <span class="brand-icon"><i class="bi bi-graph-up-arrow"></i></span>
             Skill<span style="color: var(--color-primary);">Focus</span>
         </a>

         <button class="navbar-toggler border-0 shadow-none p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Abrir menu">
             <span class="navbar-toggler-icon"></span>
         </button>

         <div class="collapse navbar-collapse" id="navbarNav">

             @if ($isCompany)
             {{-- Company Navigation --}}
             <ul class="navbar-nav flex-lg-row gap-lg-1 gap-1">
                 <li class="nav-item">
                     <a class="nav-link-custom {{ $activePage === 'dashboard' ? 'active' : '' }}" href="{{ url('/dashboard') }}">
                         <i class="bi bi-grid-1x2"></i> Dashboard
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link-custom {{ $activePage === 'jobs' ? 'active' : '' }}" href="{{ url('/jobs') }}">
                         <i class="bi bi-briefcase"></i> Vagas
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link-custom {{ $activePage === 'mapa-talentos' ? 'active' : '' }}" href="{{ url('/mapa-talentos') }}">
                         <i class="bi bi-map"></i> Mapa de Calor
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link-custom {{ $activePage === 'reports' ? 'active' : '' }}" href="{{ url('/reports') }}">
                         <i class="bi bi-bar-chart"></i> Relatórios
                     </a>
                 </li>
                 <li class="nav-item dropdown">
                     <a class="nav-link-custom dropdown-toggle {{ $activePage === 'esg-progress' || $activePage === 'diversity-progress' ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                         <i class="bi bi-shield-check"></i> Progresso
                     </a>
                     <ul class="dropdown-menu">
                         <li><a class="dropdown-item {{ $activePage === 'esg-progress' ? 'active' : '' }}" href="{{ route('esg-progress.index') }}">Progresso ESG</a></li>
                         <li><a class="dropdown-item {{ $activePage === 'diversity-progress' ? 'active' : '' }}" href="{{ route('diversity-progress.index') }}">Progresso de Diversidade</a></li>
                     </ul>
                 </li>
             </ul>
             @else
             {{-- Candidate Navigation --}}
             <ul class="navbar-nav flex-lg-row gap-lg-1 gap-1">
                 <li class="nav-item">
                     <a class="nav-link-custom {{ $activePage === 'dashboard' ? 'active' : '' }}" href="{{ url('/dashboard') }}">
                         <i class="bi bi-grid-1x2"></i> Dashboard
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link-custom {{ $activePage === 'jobs' ? 'active' : '' }}" href="{{ url('/jobs') }}">
                         <i class="bi bi-briefcase"></i> Vagas
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link-custom {{ $activePage === 'match' ? 'active' : '' }}" href="{{ url('/jobs') }}#matches">
                         <i class="bi bi-star"></i> Matches
                     </a>
                 </li>
             </ul>
             @endif

             <div class="navbar-actions">
                 <div class="avatar-badge" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                     <i class="bi bi-person-fill"></i>
                 </div>
                 <ul class="dropdown-menu dropdown-menu-end mt-2">
                     @if ($isCompany)
                     <li><a class="dropdown-item py-2" href="{{ route('dashboard') }}"><i class="bi bi-briefcase-fill me-2 text-muted"></i>Dashboard</a></li>
                     <li><a class="dropdown-item py-2" href="{{ route('esg-progress.index') }}"><i class="bi bi-bar-chart-fill me-2 text-muted"></i>Progresso ESG</a></li>
                     <li><a class="dropdown-item py-2" href="{{ url('/jobs/create') }}"><i class="bi bi-plus-circle-fill me-2 text-muted"></i>Criar vaga</a></li>
                     <li><a class="dropdown-item py-2" href="{{ url('/jobs') }}"><i class="bi bi-eye-fill me-2 text-muted"></i>Vagas criadas</a></li>
                     <li><a class="dropdown-item py-2" href="{{ url('/reports') }}"><i class="bi bi-clipboard2-fill me-2 text-muted"></i>Relatórios</a></li>
                     @else
                     <li><a class="dropdown-item py-2" href="{{ url('/jobs') }}"><i class="bi bi-briefcase-fill me-2 text-muted"></i>Vagas</a></li>
                     <li><a class="dropdown-item py-2" href="{{ route('candidate-setup.step1') }}"><i class="bi bi-person-fill me-2 text-muted"></i>Perfil</a></li>
                     <li><a class="dropdown-item py-2" href="{{ route('candidate-setup.step1') }}"><i class="bi bi-gear-fill me-2 text-muted"></i>Configurações</a></li>
                     @endif
                     <li>
                         <hr class="dropdown-divider">
                     </li>
                     <li><a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}"><i class="bi bi-box-arrow-right me-2"></i> Sair</a></li>
                 </ul>
             </div>

         </div>
     </div>
 </nav>

 <script>
     document.addEventListener('DOMContentLoaded', function() {
         const dropdownToggles = document.querySelectorAll('.nav-item.dropdown .dropdown-toggle');
         if (typeof bootstrap !== 'undefined') {
             dropdownToggles.forEach(toggle => {
                 new bootstrap.Dropdown(toggle);
             });
         }
     });
 </script>