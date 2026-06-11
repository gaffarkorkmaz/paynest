{{--
***********************************************************
Adı Soyadı: Gaffar Korkmaz
Öğrenci Numarası: 262484021
***********************************************************
--}}
@extends('layouts.app')

@section('title', 'Ürün Düzenle')

@php($sidebar = 'urunler')

@section('content')

    <main class="main-content">
        <div class="page-header">
            <div>
                <h1>Ürün Düzenle</h1>
                <p>Mevcut ürünü düzenleyin</p>
            </div>
            <a href="{{ route('urunler') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Geri Dön</a>
        </div>
        @if(session('error'))
            <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 10px;">
                {{ session('error') }}
            </div>
        @endif
        <div class="card">
            <form enctype="multipart/form-data" action="{{ route('urun.guncelle', $urun->id) }}" method="POST">
                @csrf
                <h3
                    style="margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border-color);">
                    <i class="fas fa-user" style="color: var(--primary);"></i> Ana Bilgiler
                </h3>

                <div class="form-group">
                    <label class="form-label">Başlık *</label>
                    <div class="input-group">
                        <i class="fas fa-user input-group-icon"></i>
                        <input type="text" class="form-input" name="baslik" value="{{ $urun->baslik }}" placeholder="Ürün başlığı" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Url *</label>
                        <div class="input-group">
                            <i class="fas fa-envelope input-group-icon"></i>
                            <input type="text" class="form-input" name="url" value="{{ $urun->url }}" placeholder="Url yapısına uygun, url yazısı örn (yazilim-hizmeti)"
                                   required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Fiyat *</label>
                        <div class="input-group">
                            <i class="fas fa-phone input-group-icon"></i>
                            <input required type="number" class="form-input" name="fiyat" value="{{ $urun->fiyat }}" placeholder="123">
                        </div>
                    </div>
                </div>

                <h3
                    style="margin: 2rem 0 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border-color);">
                    <i class="fas fa-map-marker-alt" style="color: var(--primary);"></i> Diğer Bilgiler
                </h3>

                <div class="form-group">
                    <label class="form-label">Açıklama</label>
                    <textarea class="form-textarea" name="aciklama" placeholder="Gösterilecek uzun açıklama..."
                              rows="3">{{ $urun->aciklama }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Özellikler</label>
                    <textarea class="form-textarea" name="ozellikler" placeholder="Gösterilecek özellikler || işareti ile her özelliği ayırın..."
                              rows="3">{{ $urun->ozellikler }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Kdv *</label>
                        <input type="text" class="form-input" value="{{ $urun->kdv }}" required name="kdv" placeholder="Kdv oranı">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Stok *</label>
                        <input type="text" class="form-input" value="{{ $urun->stok }}" required name="stok" placeholder="Stok sayısı, 0 (sıfır) sınırsızdır.">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Resim</label>
                        <input type="file" class="form-input" name="resim">
                        @if($urun->resim)
                            <small style="display:block; margin-top:5px; color:#666;">Yeni resim seçmezseniz mevcut resim korunacaktır.</small>
                        @endif
                    </div>
                </div>

                <div
                    style="margin-top: 2.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color); display: flex; gap: 1rem; justify-content: flex-end; flex-wrap: wrap;">
                    <a href="{{ route('urunler') }}" class="btn btn-secondary"><i class="fas fa-times"></i> İptal</a>
                    <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Ürünü
                        Güncelle</button>
                </div>
            </form>
        </div>

    </main>

@endsection
