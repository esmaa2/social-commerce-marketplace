<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mix Group</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        * {
            box-sizing: border-box;
        }
        
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
        }
        
        body {
            background: #111827;
            color: #E5E7EB;
            overflow-x: hidden;
        }
        
        .app-container {
            display: flex;
            min-height: 100vh;
            position: relative;
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            background: linear-gradient(180deg, #0F172A 80%, #14B8A6 200%);
            border-right: 1px solid #1F2937;
            display: flex;
            flex-direction: column;
            padding: 0;
            box-shadow: 2px 0 16px 0 rgba(0, 0, 0, 0.1);
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
        }
        
        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.02);
            pointer-events: none;
        }
        
        /* Sidebar Logo */
        .sidebar-logo {
            height: 88px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #1F2937;
            margin-bottom: 1.5rem;
            padding: 1.5rem 1.25rem;
            background: rgba(15, 23, 42, 0.3);
        }
        
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .logo {
            padding: 8px;
            background: rgba(20, 184, 166, 0.1);
            border-radius: 8px;
            border: 1px solid rgba(20, 184, 166, 0.2);
        }
        
        .brand-text {
            font-weight: 600;
            font-size: 1.25rem;
            letter-spacing: 0.5px;
            color: #14B8A6;
        }
        
        /* Navigation Links */
        .sidebar .nav {
            width: 100%;
            padding: 0 1rem;
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 14px;
            border-radius: 8px;
            padding: 12px 18px;
            margin-bottom: 6px;
            position: relative;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        
        .sidebar .nav-link .icon {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.35em;
            transition: color 0.2s ease;
        }
        
        .sidebar .nav-link.active {
            background: rgba(20, 184, 166, 0.12);
            color: #14B8A6 !important;
            border: 1px solid rgba(20, 184, 166, 0.2);
            border-left: 4px solid #14B8A6;
        }
        
        .sidebar .nav-link.active .icon {
            color: #14B8A6;
        }
        
        /* Sidebar Profile Section */
        .sidebar-profile {
            border-top: 1px solid #1F2937;
            padding-top: 1rem;
            background: rgba(15, 23, 42, 0.2);
        }
        
        .sidebar-profile-img {
            width: 32px;
            height: 32px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #14B8A6;
            background: #fff;
            transition: all 0.2s ease;
        }
        
        /* Toggle Button */
        #sidebarToggle {
            background: rgba(20, 184, 166, 0.1) !important;
            border: 1px solid rgba(20, 184, 166, 0.2) !important;
            color: #14B8A6 !important;
            border-radius: 6px;
            padding: 6px 8px;
            transition: all 0.2s ease;
        }
        
        /* Main Content Area */
        .main-wrapper {
            margin-left: 280px;
            width: calc(100% - 280px);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        
        .main-content {
    flex: 1;
    padding: 20px;
    background: transparent;
    position: relative;
    overflow-y: auto;
    overflow-x: hidden; /* Add this line */
    min-height: calc(100vh - 200px);
    max-width: 100%; /* Add this line */
}
        
        /* Shrunk Sidebar */
        .sidebar.shrunk {
            width: 85px !important;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .sidebar.shrunk .brand-text {
            display: none !important;
        }
        
        .sidebar.shrunk .nav-link span {
            display: none !important;
        }
        
        .sidebar.shrunk .nav-link {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }
        
        .sidebar.shrunk .nav-link .icon {
            margin: 0;
        }
        
        .sidebar.shrunk .sidebar-logo {
            justify-content: center;
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .sidebar.shrunk #sidebarToggle {
            position: absolute;
            top: 50%;
            right: -18px;
            transform: translateY(-50%);
            border-radius: 50%;
            padding: 6px;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #14B8A6 !important;
            color: white !important;
        }
        
        .sidebar.shrunk #sidebarToggle i {
            transform: rotate(180deg);
        }
        
        .main-wrapper.sidebar-shrunk {
            margin-left: 85px;
            width: calc(100% - 85px);
        }
        
        /* Enhanced Footer */
        footer {
            background: #1F2937 ;
            color: #E5E7EB ;
            padding: 28px 0 18px 0;
            text-align: center;
            border-top: 2px solid #334155;
            font-size: 1.08rem;
            letter-spacing: 0.5px;
            margin-top: 32px;
        }
        .footer-social {
            margin: 12px 0 6px 0;
            display: flex;
            gap: 18px;
            justify-content: center;
        }
        .footer-social a {
            color: #14B8A6;
            font-size: 1.35rem;
            margin: 0 6px;
            transition: color 0.18s;
        }
        .footer-social a:hover {
            color: #fff;
        }
        .footer-brand {
            color: #14B8A6;
            font-weight: bold;
            font-size: 1.25rem;
            letter-spacing: 1px;
        }
        .footer-desc {
            color: #94A3B8;
            font-size: 0.97rem;
            margin-bottom: 2px;
        }
        .footer-copy {
            color: #64748B;
            font-size: 0.93rem;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                width: 85px !important;
            }
            .sidebar .nav-link span {
                display: none !important;
            }
            .sidebar .brand-text {
                display: none !important;
            }
            .main-wrapper {
                margin-left: 85px;
                width: calc(100% - 85px);
            }
            .main-content {
                padding: 15px;
            }
        }
        
        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: flex !important;
            }
            
            .sidebar {
                transform: translateX(-100%);
                z-index: 1050;
                box-shadow: none;
                width: 280px !important;
            }
            .sidebar .nav-link span {
                display: block !important;
            }
            .sidebar .brand-text {
                display: block !important;
            }
            .sidebar.mobile-open {
                transform: translateX(0);
                box-shadow: 4px 0 20px rgba(0, 0, 0, 0.3);
            }
            .main-wrapper {
                margin-left: 0;
                width: 100%;
                padding-top: 20px;
            }
            .main-wrapper.sidebar-shrunk {
                margin-left: 0;
                width: 100%;
            }
            .main-content {
                padding: 15px;
            }
            
            /* Hide desktop toggle button on mobile */
            #sidebarToggle {
                display: none !important;
            }
        }
        
        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: none;
            position: fixed;
            top: 15px;
            right: 15px;
            z-index: 1060;
            background: #14B8A6;
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
            box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
            transition: all 0.2s ease;
            cursor: pointer;
            align-items: center;
            justify-content: center;
        }
        
        .mobile-menu-btn:active {
            transform: scale(0.95);
        }
        
        /* Close button when sidebar is open */
        .mobile-menu-btn.close-btn {
            background: #ef4444;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
            right: 15px;
            top: 15px;
        }
        
        .mobile-menu-btn .btn-text {
            display: none;
        }
        
        /* Overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1040;
        }
        
        @media (max-width: 768px) {
            .sidebar-overlay.show {
                display: block;
            }
        }
        
        /* Scrollbar Styling */
        .main-content::-webkit-scrollbar {
            width: 6px;
        }
        
        .main-content::-webkit-scrollbar-track {
            background: rgba(31, 41, 55, 0.3);
        }
        
        .main-content::-webkit-scrollbar-thumb {
            background: rgba(20, 184, 166, 0.3);
            border-radius: 3px;
        }
        
        .main-content::-webkit-scrollbar-thumb:hover {
            background: rgba(20, 184, 166, 0.5);
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Mobile Menu Button -->
        <button class="mobile-menu-btn" id="mobileMenuBtn">
            <i class="bi bi-list"></i>
        </button>
        
        <!-- Sidebar Overlay for Mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        
        <!-- Sidebar -->
        <div class="sidebar shadow-lg" id="sidebar">
            <div class="sidebar-logo">
                <div class="brand">
                    <div class="logo" aria-hidden="true">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                            <path d="M7 7V6a5 5 0 1 1 10 0v1" stroke="white" stroke-width="2" stroke-linecap="round"/>
                            <rect x="4" y="7" width="16" height="14" rx="3" stroke="white" stroke-width="2"/>
                        </svg>
                    </div>
                    <span class="brand-text">NotFbMarketplace</span>
                </div>
                <button id="sidebarToggle" class="btn btn-sm" title="Toggle sidebar">
                    <i class="bi bi-chevron-left"></i>
                </button>
            </div>
            
            <ul class="nav flex-column flex-grow-1">
                <li class="nav-item">
                    <a href="{{ url('/') }}" 
   class="nav-link{{ Request::is('/') ? ' active' : '' }}">
    <i class="bi {{ Request::is('/') ? 'bi-house-door-fill' : 'bi-house-door' }} icon"></i>
    <span>Home</span>
</a>

                </li>
                <li class="nav-item">
     <a href="{{ route('products.index') }}" class="nav-link">
    <i class="bi bi-bag icon"></i>
    <span>Marketplace</span>
</a>



                </li>
                <li class="nav-item">
                    <a href="{{ route('feed.create') }}" class="nav-link{{ Request::is('add-post') ? ' active' : '' }}">
                        <i class="bi {{ Request::is('add-post') ? 'bi-plus-square-fill' : 'bi-plus-square' }} icon"></i>
                        <span>Add Post</span>
                    </a>
                </li>
                <li class="nav-item">
              <a href="{{ route('products.create') }}" class="nav-link{{ Request::is('products/create') ? ' active' : '' }}">
    <i class="bi {{ Request::is('products/create') ? 'bi-bag-plus-fill' : 'bi-bag-plus' }} icon"></i>
    <span>Add Product</span>
</a>

                </li>
            </ul>
            
            <ul class="nav flex-column sidebar-profile">
               <li class="nav-item">
    <a href="{{ route('profile.show') }}" class="nav-link d-flex align-items-center{{ Request::is('profile') ? ' active' : '' }}">
        <img src="{{ auth()->user()?->avatar_url ?: asset('images/default-avatar.png') }}" 
             alt="Profile" 
             class="sidebar-profile-img me-2">
        <span>Profile</span>
    </a>
</li>

                <li class="nav-item">
                    <a href="" class="nav-link{{ Request::is('settings') ? ' active' : '' }}">
                        <i class="bi {{ Request::is('settings') ? 'bi-gear-fill' : 'bi-gear' }} icon"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Section -->
        <div class="main-wrapper" id="mainWrapper">
            <main class="main-content">
                @yield('main_content')
            </main>
            @include('components.footer')
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainWrapper = document.getElementById('mainWrapper');
            const toggleBtn = document.getElementById('sidebarToggle');
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const SIDEBAR_KEY = 'sidebarShrunk';

            // Set sidebar state
            const isShrunk = localStorage.getItem(SIDEBAR_KEY) === 'true';
            if (isShrunk && window.innerWidth > 768) {
                sidebar.classList.add('shrunk');
                mainWrapper.classList.add('sidebar-shrunk');
            }

            // Desktop toggle
            toggleBtn.addEventListener('click', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.toggle('shrunk');
                    mainWrapper.classList.toggle('sidebar-shrunk');
                    localStorage.setItem(SIDEBAR_KEY, sidebar.classList.contains('shrunk'));
                }
            });

            // Mobile menu
            mobileMenuBtn.addEventListener('click', function() {
                const isOpen = sidebar.classList.contains('mobile-open');
                
                if (isOpen) {
                    // Close menu
                    sidebar.classList.remove('mobile-open');
                    sidebarOverlay.classList.remove('show');
                    mobileMenuBtn.classList.remove('close-btn');
                    mobileMenuBtn.innerHTML = '<i class="bi bi-list"></i>';
                } else {
                    // Open menu
                    sidebar.classList.add('mobile-open');
                    sidebarOverlay.classList.add('show');
                    mobileMenuBtn.classList.add('close-btn');
                    mobileMenuBtn.innerHTML = '<i class="bi bi-x-lg"></i>';
                }
            });

            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('mobile-open');
                sidebarOverlay.classList.remove('show');
                mobileMenuBtn.classList.remove('close-btn');
                mobileMenuBtn.innerHTML = '<i class="bi bi-list"></i>';
            });

            // Close mobile menu when clicking on a nav link
            const navLinks = sidebar.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        sidebar.classList.remove('mobile-open');
                        sidebarOverlay.classList.remove('show');
                        mobileMenuBtn.classList.remove('close-btn');
                        mobileMenuBtn.innerHTML = '<i class="bi bi-list"></i>';
                    }
                });
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('mobile-open');
                    sidebarOverlay.classList.remove('show');
                    mobileMenuBtn.classList.remove('close-btn');
                    mobileMenuBtn.innerHTML = '<i class="bi bi-list"></i>';
                    
                    // Restore desktop sidebar state
                    const isShrunk = localStorage.getItem(SIDEBAR_KEY) === 'true';
                    if (isShrunk) { 
                        sidebar.classList.add('shrunk');
                        mainWrapper.classList.add('sidebar-shrunk');
                    }
                } else {
                    // On mobile, always reset to expanded state
                    sidebar.classList.remove('shrunk');
                    mainWrapper.classList.remove('sidebar-shrunk');
                }
            });
        });
    </script>
</body>
</html>