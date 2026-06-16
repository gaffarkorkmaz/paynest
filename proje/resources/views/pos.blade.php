@extends('layouts.app')

@section('title', 'API Anahtarları')

@php($sidebar = 'apikeys')

@section('content')
    <main class="main-content">
        <div class="page-header">
            <div>
                <h1>API Anahtarları</h1>
                <p>POS sistemlerine erişim için anahtar oluşturun ve yönetin.</p>
            </div>
        </div>

        <div class="card" style="margin-bottom: 1.5rem;">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-plus-circle"></i> Yeni Anahtar Oluştur</h3>
            </div>

            <form action="{{ route('apikey.store') }}" method="POST">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Anahtar Adı *</label>
                        <div class="input-group">
                            <i class="fas fa-tag input-group-icon"></i>
                            <input type="text" class="form-input" name="name" placeholder="ör: Üretim Sunucusu" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Durum</label>
                        <select class="form-select" name="status">
                            <option value="1">Aktif</option>
                            <option value="0">Pasif</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">POS Erişim İzinleri</label>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.75rem; margin-top: 0.5rem;">
                        @foreach($gateways as $gateway)
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; background: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 8px; padding: 0.5rem 0.875rem;">
                                <input type="checkbox" name="pos_access[]" value="{{ $gateway->name }}" style="accent-color: var(--primary); width: 14px; height: 14px;">
                                <img src="{{ $gateway->logo }}" alt="{{ $gateway->name }}" style="width: 18px; height: 18px; object-fit: contain;">
                                <span style="font-size: 0.85rem; color: var(--text-secondary);">{{ $gateway->value }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Kaydet
                    </button>
                </div>
            </form>
        </div>

        <div class="card" style="margin-bottom: 1.5rem;">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-list-ul"></i> Anahtar Listesi</h3>
            </div>
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Ad</th>
                        <th>Anahtar</th>
                        <th>Durum</th>
                        <th>POS Erişimi</th>
                        <th>Oluşturulma</th>
                        <th>İşlem</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($apiKeys as $key)
                        <tr>
                            <td><strong>{{ $key->id }}</strong></td>
                            <td>{{ $key->name }}</td>
                            <td>
                                    <span style="font-family: 'Courier New', monospace; font-size: 0.8rem; color: var(--text-muted); background: rgba(0,0,0,0.2); padding: 0.2rem 0.5rem; border-radius: 4px; border: 1px solid var(--border-color);">
                                        {{ $key->secret_key }}
                                    </span>
                            </td>
                            <td>
                                    <span class="badge badge-{{ $key->status == 1 ? 'success' : 'secondary' }}">
                                        {{ $key->status == 1 ? 'Aktif' : 'Pasif' }}
                                    </span>
                            </td>
                            <td>
                                <div style="display: flex; flex-wrap: wrap; gap: 0.3rem;">
                                    @foreach(explode(',', $key->permissions) as $pos)
                                        <span class="badge badge-info">{{ $pos }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td>{{ date('d.m.Y H:i', $key->time + 10800) }}</td>
                            <td>
                                <a href="{{ route('apikey.kapat', $key->id) }}" class="btn btn-sm btn-info btn-icon" title="Sil">
                                    <i class="fas fa-ban"></i>
                                </a>
                                <a href="{{ route('apikey.delete', $key->id) }}" class="btn btn-sm btn-danger btn-icon" title="Sil">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card" style="margin-bottom: 1.5rem;">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-code"></i> Entegrasyon Bilgileri</h3>
            </div>
            <div class="table-wrapper">
                <h4>Part 1 - Ödeme Oluşturma</h4>
                <hr>
                <br>
                <h5>Uç Nokta: <strong>{{ url('/api/v1/createpayment') }}</strong></h5>
                <br>
                <p>Beklenen Değerler
                    <br>
                    <strong>secretKey</strong> - Zorunlu - Yukarı da ki anahtar listesinde ki anahtar bilgisidir.<br>
                    <strong>tutar</strong> - Zorunlu - Çekilecek tutardır.<br>
                    <strong>shopId</strong> - Zorunlu - Ödeme sonrası callback adresine gönderilecektir. Kendi doğrulamalarınız için kullanabilirsiniz.<br>
                    <strong>metod</strong> - Zorunlu - Hangi sanal pos ile ödeme alınacağıdır, örn
                    @foreach($gateways as $gateway)
                        " {{ $gateway->name }} " ,
                    @endforeach; <br>
                    <strong>musteriAd</strong> - Zorunlu - Müşterinin adı. <br>
                    <strong>musteriSoyad</strong> - Zorunlu - Müşterinin soyadı. <br>
                    <strong>musteriEposta</strong> - Zorunlu - Müşteri eposta adresi. <br>
                    <strong>musteriTelefon</strong> - Zorunlu - Müşteri telefon numarası. <br>
                    <strong>musteriAdres</strong> - Zorunlu - Müşteri adresi. <br>
                    <strong>musteriIp</strong> - Zorunlu - Müşteri ip adresi. <br>
                    <strong>musteriTckn</strong> - Opsiyonel - Müşteri kimlik numarası. <br>
                    <strong>basariliUrl</strong> - Zorunlu - Ödeme başarılı olursa müşterinin gönderileceği adres. <br>
                    <strong>basarisizUrl</strong> - Zorunlu - Ödeme başarısız olursa müşterinin gönderileceği adres. <br>
                    <strong>callbackUrl</strong> - Zorunlu - Ödeme sonucunun gönderileceği callback adresi. <br>
                    <strong>urunAdi</strong> - Zorunlu - Ürünün adı. <br>
                    <strong>urunAdet</strong> - Zorunlu - Satılan ürünün adeti. <br>
                    <strong>urunFiyat</strong> - Zorunlu - Ürünün birim fiyatı <br>
                </p>
                <br>
                <h5><strong>Örnek Response:</strong></h5>
                <p>
                    {"status" => "success", "odeme_link" => "{{url('paytr/odeme/123456')}}", "message" => "Ödeme başarıyla oluşturuldu."}
                </p>

                <hr>
                <br>
                <br>
                <br>
                <h4>Part 2 - Callback Dönüşü</h4>
                <hr>
                <br>
                <p>
                    Callback adresinize iletilen değerler.
                    <br>
                    <strong>shopId</strong> - Ödeme oluştururken ilettiğiniz sipariş idsi. <br>
                    <strong>tutar</strong> - Ödeme oluştururken ilettiğiniz tutar<br>
                    <strong>urunAdi</strong> - Ödeme oluştururken ilettiğiniz ürün adı<br>
                    <strong>urunAdet</strong> - Ödeme oluştururken ilettiğiniz ürün adedi<br>
                    <strong>urunFiyat</strong> - Ödeme oluştururken ilettiğiniz ürünün birim fiyatı<br>
                    <strong>status</strong> - Ödeme durumu - Ödeme alındıysa "success" şeklinde iletilir<br>
                    <strong>message</strong> - Ödeme durum mesajı<br>
                    <strong>hash</strong> - Doğrulamanız gereken hash, isteğin paynestten geldiğini doğrulamanız gerekir.
                    <br>
                    <br>
                    <h5>Hash Doğrulaması</h5>
                <p>SECRET KEY - shopId - tutar - urunAdi - urunFiyat
                    <br>
                değerlerinin birleşimiyle oluşan uzun değişkenin SHA256 algoritması ile şifrelenmesi sonucu hash değeri oluşur.
                    Tüm bu değerleri gelen posttan çekip secret key ile birleştirin ve istek içinde gelen hash ile karşılaştırın.
                    Eğer uyuşma varsa istek gerçekten paynestten gelmiştir. Bu hash doğrulamasının güvenliği için secret keyin
                    gizli tutulması ve kimse ile paylaşılmaması mühimdir. Secret key yukarı da ki anahtar bilgisidir.
                </p>
                </p>
            </div>
        </div>



    </main>
@endsection
