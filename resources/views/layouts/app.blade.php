{{--
***********************************************************
Adı Soyadı: Gaffar Korkmaz
Öğrenci Numarası: 262484021
***********************************************************
--}}
    <!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ getFunction("site") }}</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/' . getFunction('favicon')) }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ url('css/style.css') }}">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>



<body>
    <button class="mobile-menu-toggle"><i class="fas fa-bars"></i></button>

    <div class="page-wrapper">
        <aside class="sidebar">
            <div class="sidebar-logo"><span>PayNEST</span></div>
            <nav>
                <div class="nav-section">
                    <div class="nav-section-title">Ana Menü</div>
                    <a href="{{ route('dashboard') }}" class="nav-link @if ($sidebar == 'anasayfa') active @endif "><i
                            class="fas fa-home"></i> Anasayfa</a>
                    <a href="{{ route('faturalar') }}" class="nav-link @if ($sidebar == 'faturalar') active @endif"><i
                            class="fas fa-file-invoice"></i> Faturalar</a>
                    <a href="{{ route('fatura') }}" class="nav-link @if ($sidebar == 'faturaolustur') active @endif"><i class="fas fa-plus-circle"></i> Fatura Oluştur</a>
                </div>
                <div class="nav-section">
                    <div class="nav-section-title">Müşteriler</div>
                    <a href="{{ route('musteriler') }}" class="nav-link @if ($sidebar == 'musteriler') active @endif"><i class="fas fa-users"></i> Müşteriler</a>
                    <a href="{{ route('musteri') }}" class="nav-link @if ($sidebar == 'musteriolustur') active @endif"><i class="fas fa-user-plus"></i> Müşteri Ekle</a>
                </div>
                <div class="nav-section">
                    <div class="nav-section-title">Ürünler</div>
                    <a href="{{ route('urun.ekle') }}" class="nav-link @if ($sidebar == 'urunekle') active @endif"><i class="fas fa-box"></i> Ürün Ekle</a>
                    <a href="{{ route('urunler') }}" class="nav-link @if ($sidebar == 'urunler') active @endif"><i class="fas fa-boxes"></i> Ürünlerim</a>
                </div>
                <div class="nav-section">
                    <div class="nav-section-title">Yönetim</div>
                    <a href="{{ route('pos.ayarlar') }}" class="nav-link @if ($sidebar == 'apikeys') active @endif"><i class="fas fa-credit-card"></i> Sanal POS</a>
                    <a href="{{ route('ayarlar') }}" class="nav-link @if ($sidebar == 'ayarlar') active @endif"><i class="fas fa-cog"></i> Genel Ayarlar</a>
                    <a href="{{ route('cikis-yap') }}" class="nav-link"><i class="fas fa-sign-out-alt"></i> Çıkış
                        Yap</a>
                </div>
            </nav>
        </aside>

        @yield('content')


    </div>

    <script src="{{ url('js/app.js') }}"></script>
</body>

</html>
