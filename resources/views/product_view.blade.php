<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $urun->baslik }}</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/' . getFunction('favicon')) }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ url('css/style.css') }}">
    <style>
        html {
            scroll-behavior: smooth;
        }
        .product-hero {
            padding: 4rem 0;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(139, 92, 246, 0.05) 100%);
            min-height: 70vh;
            display: flex;
            align-items: center;
        }

        .product-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        @media (max-width: 900px) {
            .product-container {
                grid-template-columns: 1fr;
                text-align: center;
            }
        }

        .product-image {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            border: 1px solid var(--border-color);
            background: var(--bg-card);
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-image i {
            font-size: 6rem;
            color: var(--text-muted);
        }

        .product-title {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .product-price {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--success);
            margin-bottom: 1.5rem;
        }

        .product-description {
            font-size: 1.125rem;
            color: var(--text-secondary);
            line-height: 1.8;
            margin-bottom: 2rem;
        }

        .product-features {
            list-style: none;
            margin-bottom: 2rem;
        }

        .product-features li {
            padding: 0.75rem 0;
            display: flex;
            align-items: center;
            gap: 1rem;
            color: var(--text-secondary);
        }

        .product-features li i {
            color: var(--success);
            font-size: 1.25rem;
        }

        .buy-btn {
            padding: 1.25rem 3rem;
            font-size: 1.25rem;
        }

        .checkout-section {
            padding: 4rem 0;
            background: var(--bg-card);
        }

        .checkout-card {
            max-width: 600px;
            margin: 0 auto;
            background: var(--bg-dark);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 2.5rem;
        }

        .checkout-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .order-summary {
            background: var(--bg-card);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .order-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .order-row:last-child {
            border: none;
            font-weight: 600;
            font-size: 1.25rem;
            color: var(--success);
        }

        .product-image {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            border: 1px solid var(--border-color);
            background: var(--bg-card);
            min-height: 400px;
            max-height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
            max-width: 100%;
            display: block;
        }

        .product-image i.placeholder-icon {
            font-size: 6rem;
            color: var(--text-muted);
        }
    </style>
</head>

<body>
<section class="product-hero">
    <div class="product-container">
        <div class="product-image">
            @if(!empty($urun->resim))
                <img src="{{ url('storage/' . $urun->resim) }}" alt="{{ $urun->baslik }}">
            @else
                <i class="fas fa-box placeholder-icon"></i>
            @endif
        </div>
        <div class="product-info">
            <h1 class="product-title">{{ $urun->baslik }}</h1>
            <div class="product-price">₺{{ $urun->fiyat }}</div>
            <p class="product-description">
                {{ $urun->aciklama }}
            </p>
            <ul class="product-features">

                @foreach(explode("||", $urun->ozellikler) as $ozellik)
                    <li><i class="fas fa-check-circle"></i> {{ $ozellik }}</li>
                @endforeach

            </ul>

        </div>
    </div>
</section>

<section class="checkout-section" id="checkout">
    @if($urun->stok == -1)
        <div class="checkout-card">
            <div class="checkout-header">
                <h2><i class="fas fa-shopping-bag"></i> Sipariş Bilgileri</h2>
                <p class="text-muted">Bu ürün için stok kalmamıştır.</p>
            </div>

        </div>

    @else

    <div class="checkout-card">
        <div class="checkout-header">
            <h2><i class="fas fa-shopping-bag"></i> Sipariş Bilgileri</h2>
            <p class="text-muted">Bilgilerinizi girerek siparişi tamamlayın</p>
        </div>

        <div class="order-summary">
            <div class="order-row"><span>Ürün</span><span>{{ $urun->baslik }}</span></div>
            <div class="order-row"><span>Fiyat</span><span>₺{{$urun->fiyat}}</span></div>
            <div class="order-row"><span>KDV (%{{$urun->kdv}})</span><span>₺{{ ($urun->fiyat*$urun->kdv)/100 }}</span></div>
            <div class="order-row"><span>Toplam</span><span>₺{{ (($urun->fiyat*$urun->kdv)/100)+$urun->fiyat }}</span></div>
        </div>

        <form action="{{ route('urun.post', $urun->url) }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Ad *</label>
                    <input type="text" class="form-input" name="ad" placeholder="Adınız" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Soyad *</label>
                    <input type="text" class="form-input" name="soyad" placeholder="Soyadınız" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">E-posta *</label>
                <input type="email" class="form-input" name="eposta" placeholder="ornek@email.com" required>
            </div>
            <div class="form-group">
                <label class="form-label">Telefon *</label>
                <input type="tel" class="form-input" name="telefon" placeholder="+90 555 123 4567" required>
            </div>
            <div class="form-group">
                <label class="form-label">Adres</label>
                <textarea class="form-textarea" name="adres" placeholder="Teslimat adresi (opsiyonel)"
                          rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-success btn-lg" style="width: 100%;">
                <i class="fas fa-credit-card"></i> Ödeme Sayfasına Git
            </button>
        </form>
    </div>
    @endif

</section>

<script src="{{ url('js/app.js') }}"></script>

</body>

</html>
