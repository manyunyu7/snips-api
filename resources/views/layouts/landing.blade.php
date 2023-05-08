<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!--========== BOX ICONS ==========-->
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <!--========== CSS ==========-->
    <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap");

        * {
            font-family: 'Poppins', sans-serif !important;
        }

        a {
            text-decoration: none !important;
        }

        .circular-img {
            border-radius: 50%;
        }

        @font-face {
            font-family: gloss;
            src: url({{asset('/gloss-and-bloom/gloss.ttf')}});
        }

        p{
            transition: all ease 3s;
        }

        p:hover{
            size: 10%;
            transform: scale(0.99) translateY(5px);
            color: aqua;
        }


    </style>
    @yield('css')
    <title>{{config('app.name')}}</title>
</head>
<body>

<!--========== SCROLL TOP ==========-->
<a href="#" class="scrolltop" id="scroll-top">
    <i class='bx bx-chevron-up scrolltop__icon'></i>
</a>

<!--========== HEADER ==========-->
<header class="l-header d-flex align-items-center" id="header">
    <nav class="nav navbar navbar-expand-lg bd-container">
        <div class="container-fluid">
            <a href="{{route('landing')}}" class="nav__logo navbar-brand">BERSAMA</a>

            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li class="nav__item"><a href="{{route('landing')}}#home" class="nav__link active-link">Home</a>
                    </li>
                    <li class="nav__item"><a href="{{route('landing')}}#about" class="nav__link">About</a></li>
                    <li class="nav__item"><a href="{{route('landing')}}#services" class="nav__link">Services</a></li>
                    <li class="nav__item"><a href="{{route('landing')}}#menu" class="nav__link">Our Team</a></li>
                    <li class="nav__item"><a href="{{route('landing')}}#contact" class="nav__link">Contact us</a></li>
                    <li class="nav__item"><a href="{{url('/login')}}" class="nav__link">Login</a></li>
                    <li><i class='bx bx-moon change-theme' id="theme-button"></i></li>
                </ul>
            </div>

            <div class="nav__toggle" id="nav-toggle">
                <i class='bx bx-menu'></i>
            </div>
        </div>
    </nav>
</header>
@yield('content')

<!--========== FOOTER ==========-->
<footer class="footer section bd-container">
    <div class="footer__container bd-grid">
        <div class="footer__content">
            <a href="#" class="footer__logo">BERSAMA (Berbagi Bersama)</a>
            <span class="footer__description">Project</span>
            <div>
                <a href="#" class="footer__social"><i class='bx bxl-facebook'></i></a>
                <a href="#" class="footer__social"><i class='bx bxl-instagram'></i></a>
                <a href="#" class="footer__social"><i class='bx bxl-twitter'></i></a>
            </div>
        </div>

        <div class="footer__content">
            <h3 class="footer__title">Layanan Kami</h3>
            <ul>
                <li><a href="#" class="footer__link">Pembagian Makanan</a></li>
                <li><a href="#" class="footer__link">List Donatur</a></li>
            </ul>
        </div>

        <div class="footer__content">
            <h3 class="footer__title">Informasi</h3>
            <ul>
                <li><a href="#" class="footer__link">List Donatur</a></li>
                <li><a href="#" class="footer__link">Kontak Kami</a></li>

            </ul>
        </div>

        <div class="footer__content">
            <h3 class="footer__title">Alamat</h3>
            <ul>
                <li>Telkom University</li>

            </ul>
        </div>
    </div>

    <p class="footer__copy">&#169; 2021 TIM LindungiPeduli Innovillage</p>
</footer>

<!--========== SCROLL REVEAL ==========-->
<script src="https://unpkg.com/scrollreveal"></script>

<!--========== MAIN JS ==========-->
<script src="assets/js/main.js"></script>
</body>
</html>
