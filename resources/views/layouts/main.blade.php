<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'ระบบจัดการบุคลากร - คณะแพทยศาสตร์')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ระบบจัดการหนังสือเวียนออนไลน์ คณะแพทยศาสตร์ มหาวิทยาลัยเชียงใหม่">

    <!-- Fonts & Bootstrap & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        :root {
            --primary-color: #1a5d46;
            --secondary-color: #2d7d5a;
            --accent-color: #4caf50;
            --light-green: #e8f5e9;
            --dark-green: #0d3b2a;
            --text-color: #2e3c3a;
            --light-text: #f1f8e9;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.15);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.2);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        body {
            font-family: 'Prompt', sans-serif;
            margin: 0;
            padding: 0;
            color: var(--text-color);
            background: linear-gradient(135deg, #f5fdf9, #e0f7ed);
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header Styles */
        header {
            background: linear-gradient(135deg, var(--primary-color), var(--dark-green));
            padding: 1rem 0;
            box-shadow: var(--shadow-md);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 3px solid rgba(255, 255, 255, 0.1);
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .brand-section {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .logo {
            height: 50px;
            transition: var(--transition);
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .system-title {
            font-size: 1.6rem;
            font-weight: 600;
            color: white;
            margin: 0;
            line-height: 1.2;
            letter-spacing: 0.5px;
        }

        .system-subtitle {
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.85rem;
            letter-spacing: 0.3px;
            margin-top: 0.2rem;
        }

        /* Navigation Styles */
        .nav-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .nav-menu {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .nav-icon-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: white;
            font-weight: 500;
            font-size: 0.9rem;
            transition: var(--transition);
            padding: 0.5rem 0.8rem;
            border-radius: 8px;
        }

        .nav-icon-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        .nav-icon-btn i {
            font-size: 1.6rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 0.3rem;
            transition: var(--transition);
        }

        .nav-icon-btn:hover i {
            color: white;
            transform: scale(1.1);
        }

        .nav-icon-btn span {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.85);
            transition: var(--transition);
        }

        .nav-icon-btn:hover span {
            color: white;
        }

        /* User Dropdown Styles */
        .user-dropdown {
            position: relative;
        }

        .dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: white;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.1);
            transition: var(--transition);
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .dropdown-toggle:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .dropdown-menu {
            background: white;
            border: none;
            border-radius: 12px;
            box-shadow: var(--shadow-lg);
            padding: 0.5rem 0;
            margin-top: 0.5rem;
            min-width: 280px;
            overflow: hidden;
            animation: fadeIn 0.3s ease-out;
        }

        .dropdown-header {
            padding: 0.75rem 1rem;
            background: var(--light-green);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .dropdown-item {
            padding: 0.75rem 1.5rem;
            color: var(--text-color);
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .dropdown-item:hover {
            background: var(--light-green);
            color: var(--primary-color);
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
        }

        .dropdown-divider {
            margin: 0.25rem 0;
            border-color: rgba(0, 0, 0, 0.05);
        }

        /* Main Content Styles */
        main {
            flex: 1;
            padding: 3rem 0;
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
        }

        /* Footer Styles */
        footer {
            background: linear-gradient(135deg, var(--primary-color), var(--dark-green));
            color: white;
            text-align: center;
            padding: 1.5rem 0;
            font-size: 0.9rem;
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Button Styles */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transition: var(--transition);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        .btn-outline-light {
            color: white;
            border-color: rgba(255, 255, 255, 0.3);
            transition: var(--transition);
        }

        .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: white;
            transform: translateY(-2px);
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .nav-container {
                flex-direction: column;
                align-items: stretch;
                gap: 1rem;
            }

            .brand-section {
                justify-content: center;
                text-align: center;
            }

            .nav-menu {
                justify-content: center;
                flex-wrap: wrap;
            }

            .user-dropdown {
                margin-top: 1rem;
                align-self: center;
            }
        }

        @media (max-width: 576px) {
            .header-container {
                padding: 0 1rem;
            }

            .system-title {
                font-size: 1.4rem;
            }

            .nav-icon-btn {
                padding: 0.5rem;
            }

            .nav-icon-btn span {
                font-size: 0.8rem;
            }
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 1.2rem;
            margin-left: 0;
            padding-left: 0;
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 100%;
            padding-left: 2rem;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
            max-width: 100%;
        }

        .brand-section {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .brand-section img.logo {
            height: 50px;
        }
    </style>

    @yield('head')
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Header -->
    <header class="header-bar">
        <div class="header-container px-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap w-100">

                <!-- 🔹 ซ้าย: โลโก้ + ชื่อระบบ -->
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('circulars.index') }}" class="d-flex align-items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="CMU Logo" class="logo" style="height: 50px;">
                    </a>
                    <div class="brand-text">
                        <h1 class="system-title mb-0 text-white" style="font-size: 1.5rem;">หนังสือเวียนออนไลน์</h1>
                        <small class="system-subtitle text-white-50">คณะแพทยศาสตร์ มหาวิทยาลัยเชียงใหม่</small>
                    </div>
                </div>

                <!-- 🔹 กลาง: ปุ่มเมนู (เฉพาะ admin) -->
                @if(session('user') && session('role') === 'admin')
                <div class="d-flex gap-4 justify-content-center flex-wrap">
                    <a href="{{ route('circulars.create') }}" class="nav-icon-btn text-white text-center">
                        <i class="bi bi-file-earmark-plus-fill fs-4"></i><br>
                        <span>เพิ่มหนังสือ</span>
                    </a>
                    <a href="{{ route('record.index') }}" class="nav-icon-btn text-white text-center">
                        <i class="bi bi-building fs-4"></i><br>
                        <span>หน่วยงาน</span>
                    </a>
                    <a href="{{ route('validate.index') }}" class="nav-icon-btn text-white text-center">
                        <i class="bi bi-person-gear fs-4"></i><br>
                        <span>กำหนดสิทธิ์</span>
                    </a>
                </div>
                @endif

                <!-- 🔹 ขวาสุด: ปุ่มผู้ใช้งาน -->
                <div>
                    @if(session('user'))
                    <div class="user-dropdown dropdown">
                        <button class="dropdown-toggle d-flex align-items-center gap-2 px-3 py-2 rounded-pill bg-opacity-10 border-0 text-white"
                            type="button"
                            id="userDropdown"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                            style="background: rgba(255,255,255,0.15);">
                            <div class="user-avatar bg-white text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                {{ mb_substr(session('user.fname'), 0, 1) }}
                            </div>
                            <span>{{ session('user.prefix_short') }}{{ session('user.fname') }} {{ session('user.lname') }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li class="dropdown-header">
                                <div class="d-flex flex-column">
                                    <strong class="text-dark">{{ session('user.prefix_short') }}{{ session('user.fname') }} {{ session('user.lname') }}</strong>
                                    <small class="text-muted">{{ session('user.T_Work_name') }}</small>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right"></i> ออกจากระบบ
                                </a>
                            </li>
                        </ul>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light">
                        <i class="bi bi-box-arrow-in-right me-2"></i> เข้าสู่ระบบ
                    </a>
                    @endif
                </div>

            </div>
        </div>
    </header>



    <!-- Main Content -->
    <main class="animate__animated animate__fadeIn">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="footer-content">
            &copy; {{ date('Y') }} คณะแพทยศาสตร์ มหาวิทยาลัยเชียงใหม่ |
            <a href="#" class="text-white-50 text-decoration-none">นโยบายความเป็นส่วนตัว</a> |
            <a href="#" class="text-white-50 text-decoration-none">เงื่อนไขการใช้งาน</a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Enable tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
    @yield('scripts')
</body>

</html>