{{--
***********************************************************
Adı Soyadı: Gaffar Korkmaz
Öğrenci Numarası: 262484021
***********************************************************
--}}
@extends('layouts.app')

@section('title', 'Müşteri Oluştur')

@php($sidebar = 'musteriolustur')

@section('content')


    <main class="main-content">
        <div class="page-header">
            <div>
                <h1>Müşteri Ekle</h1>
                <p>Yeni bir müşteri ekleyin</p>
            </div>
            <a href="{{ route('musteriler') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Geri Dön</a>
        </div>
        @if(session('error'))
            <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 10px;">
                {{ session('error') }}
            </div>
        @endif
        <div class="card">
            <form action="{{ route('musteri.store') }}" method="POST">
                @csrf
                <h3
                    style="margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border-color);">
                    <i class="fas fa-user" style="color: var(--primary);"></i> Kişisel Bilgiler
                </h3>

                @if(@$_GET['redirect'] == 'invoice')<input type="hidden" name="invoice" value="true"> @endif
                @if(@$_GET['redirect'] == 'edit')<input type="hidden" name="edit" value="true"> @endif
                @if(@$_GET['redirect'] == 'edit')<input type="hidden" name="invid" value="{{ $_GET['id'] }}"> @endif

                <div class="form-group">
                    <label class="form-label">Ad Soyad *</label>
                    <div class="input-group">
                        <i class="fas fa-user input-group-icon"></i>
                        <input type="text" class="form-input" name="name" placeholder="Müşteri adı soyadı" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">E-posta *</label>
                        <div class="input-group">
                            <i class="fas fa-envelope input-group-icon"></i>
                            <input type="email" class="form-input" name="email" placeholder="ornek@email.com"
                                   required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Telefon *</label>
                        <div class="input-group">
                            <i class="fas fa-phone input-group-icon"></i>
                            <input required type="tel" class="form-input" name="phone" placeholder="+90 555 123 4567">
                        </div>
                    </div>
                </div>

                <!-- Şirket Bilgileri -->
                <h3
                    style="margin: 2rem 0 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border-color);">
                    <i class="fas fa-building" style="color: var(--primary);"></i> Şirket Bilgileri
                </h3>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Şirket Adı</label>
                        <div class="input-group">
                            <i class="fas fa-building input-group-icon"></i>
                            <input type="text" class="form-input" name="company"
                                   placeholder="Şirket adı (opsiyonel)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Vergi No</label>
                        <div class="input-group">
                            <i class="fas fa-id-card input-group-icon"></i>
                            <input type="text" class="form-input" name="tax_no"
                                   placeholder="Vergi numarası (opsiyonel)">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Vergi Dairesi</label>
                        <div class="input-group">
                            <i class="fas fa-landmark input-group-icon"></i>
                            <input type="text" class="form-input" name="tax_office"
                                   placeholder="Vergi dairesi (opsiyonel)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Web Sitesi</label>
                        <div class="input-group">
                            <i class="fas fa-globe input-group-icon"></i>
                            <input type="url" class="form-input" name="website" placeholder="https://example.com">
                        </div>
                    </div>
                </div>

                <!-- Adres Bilgileri -->
                <h3
                    style="margin: 2rem 0 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border-color);">
                    <i class="fas fa-map-marker-alt" style="color: var(--primary);"></i> Adres Bilgileri
                </h3>

                <div class="form-group">
                    <label class="form-label">Adres</label>
                    <textarea class="form-textarea" name="address" placeholder="Sokak, cadde, bina no..."
                              rows="3"></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">İlçe</label>
                        <input type="text" class="form-input" name="district" placeholder="İlçe">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Şehir</label>
                        <input type="text" class="form-input" name="city" placeholder="Şehir">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Posta Kodu</label>
                        <input type="text" class="form-input" name="postal_code" placeholder="34000">
                    </div>
                </div>

                <!-- Ek Bilgiler -->
                <h3
                    style="margin: 2rem 0 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border-color);">
                    <i class="fas fa-info-circle" style="color: var(--primary);"></i> Ek Bilgiler
                </h3>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Müşteri Tipi</label>
                        <select class="form-select" name="customer_type">
                            <option value="1">Bireysel</option>
                            <option value="2">Kurumsal</option>
                        </select>
                    </div>

                </div>

                <div class="form-group">
                    <label class="form-label">Notlar</label>
                    <textarea class="form-textarea" name="notes" placeholder="Müşteri hakkında özel notlar..."
                              rows="4"></textarea>
                </div>

                <div
                    style="margin-top: 2.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color); display: flex; gap: 1rem; justify-content: flex-end; flex-wrap: wrap;">
                    <a href="{{ route('musteriler') }}" class="btn btn-secondary"><i class="fas fa-times"></i> İptal</a>
                    <button type="reset" class="btn btn-secondary"><i class="fas fa-undo"></i> Temizle</button>
                    <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Müşteri
                        Kaydet</button>
                </div>
            </form>
        </div>


    </main>


@endsection
