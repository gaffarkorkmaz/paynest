{{--
***********************************************************
Adı Soyadı: Gaffar Korkmaz
Öğrenci Numarası: 262484021
***********************************************************
--}}
@extends('layouts.app')

@section('title', 'Ana Panel')

@php($sidebar = 'anasayfa')


@section('content')
    <main class="main-content">
        <div class="page-header">
            <div>
                <h1>Anasayfa</h1>
                <p>Hoş geldin, <span>Admin</span>!</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('fatura') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Yeni Fatura</a>
                <a href="{{ route('musteri') }}" class="btn btn-success"><i class="fas fa-user-plus"></i> Yeni
                    Müşteri</a>
            </div>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon primary"><i class="fas fa-file-invoice"></i></div>
                <div class="stat-content">
                    <h3>{{ $toplamfaturasayisi }}</h3>
                    <p>Toplam Fatura</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon success"><i class="fas fa-check-circle"></i></div>
                <div class="stat-content">
                    <h3>{{ $odenenfaturasayisi }}</h3>
                    <p>Ödenen Fatura</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon accent"><i class="fas fa-clock"></i></div>
                <div class="stat-content">
                    <h3>{{ $bekleyenfaturasayisi }}</h3>
                    <p>Bekleyen Fatura</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon secondary"><i class="fas fa-lira-sign"></i></div>
                <div class="stat-content">
                    <h3>₺{{ $gelir }}</h3>
                    <p>Toplam Gelir</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-history"></i> Son Faturalar</h3>
                <a href="{{ route('faturalar') }}" class="btn btn-sm btn-secondary">Tümünü Gör</a>
            </div>
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fatura No</th>
                            <th>Müşteri</th>
                            <th>Tarih</th>
                            <th>Tutar</th>
                            <th>Durum</th>
                            <th>İşlem</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($faturalar->take(10) as $fatura)

                            <tr>
                                <td><strong>{{ $fatura->id }}</strong></td>
                                <td>{{ $musteriler->where("id", $fatura->cid)->first()->name." ".$musteriler->where("id", $fatura->cid)->first()->surname }}</td>
                                <td>{{ date("d.m.Y H:i", $fatura->created_time+10800) }}</td>
                                <td>₺{{ $fatura->total }}</td>
                                <td><span
                                        class="badge badge-@if ($fatura->status == 1)success @elseif ($fatura->status == 0)warning @endif">
                                        @if ($fatura->status == 1)Ödendi @elseif ($fatura->status == 0)Bekliyor @endif
                                    </span></td>
                                <td><a href="{{ route('fatura.show', [$fatura->id, $fatura->invoiceid]) }}" class="btn btn-sm btn-secondary"><i
                                            class="fas fa-eye"></i></a>
                                </td>
                            </tr>

                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-history"></i> Son Müşteriler</h3>
                <a href="{{ route('musteriler') }}" class="btn btn-sm btn-secondary">Tümünü Gör</a>
            </div>
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Müşteri No</th>
                            <th>Ad Soyad</th>
                            <th>Eposta</th>
                            <th>Telefon</th>
                            <th>İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($musteriler->take(10) as $musteri)
                            <tr>
                                <td><strong>{{ $musteri->id }}</strong></td>
                                <td>{{ $musteri->name." ".$musteri->surname }}</td>
                                <td>{{ $musteri->email }}</td>
                                <td>{{ $musteri->phone }}</td>
                                <td><a href="{{ route('musteri.goruntule', $musteri->id); }}" class="btn btn-sm btn-secondary"><i
                                            class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-box"></i> Ürünlerim</h3>
                <a href="{{ route('urun.ekle') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Yeni Ürün</a>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">

                @foreach($products as $product)


                <div class="card" style="padding: 1rem;">
                    <h4 style="margin-bottom: 0.5rem;">{{ $product->baslik }}</h4>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <strong style="color: #22c55e;">₺{{ $product->fiyat }}</strong>
                        <a href="{{ route('urun.goruntule', $product->url) }}" class="btn btn-sm btn-outline" target="_blank">Görüntüle</a>
                    </div>
                </div>
                @endforeach


            </div>
        </div>
    </main>
@endsection
