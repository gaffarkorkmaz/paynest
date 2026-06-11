{{--
***********************************************************
Adı Soyadı: Gaffar Korkmaz
Öğrenci Numarası: 262484021
***********************************************************
--}}
@extends('layouts.app')

@section('title', 'Fatura Düzenle')

@php($sidebar = '')

@section('content')
    <style>
        .invoice-items {
            margin: 1.5rem 0;
        }

        .invoice-item {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr auto;
            gap: 1rem;
            margin-bottom: 1rem;
            align-items: end;
        }

        .invoice-item input {
            width: 100%;
        }

        .remove-item {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .remove-item:hover {
            background: #ef4444;
            color: white;
        }

        .totals-section {
            background: var(--bg-card, #f8f9fa); /* Tema değişkeni yoksa açık gri yapsın */
            padding: 1.5rem;
            border-radius: 12px;
            margin-top: 2rem;
        }

        .totals-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border-color, #dee2e6);
        }

        .totals-row:last-child {
            border: none;
            font-size: 1.25rem;
            font-weight: 600;
        }

        .customer-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .tax-settings {
            display: flex;
            justify-content: flex-end;
            margin-top: 1rem;
        }

        @media (max-width: 768px) {
            .invoice-item {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <main class="main-content">
        <div class="page-header">
            <div>
                <h1>Fatura Oluştur</h1>
                <p>Yeni bir fatura oluşturun</p>
            </div>
            <a href="{{ route('faturalar') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Geri Dön</a>

        </div>
        @if(session('error'))
            <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 10px;">
                {{ session('error') }}
            </div>
        @endif
        <div class="card">
            <form action="{{ route('faturaedit', $fatura->id) }}" method="POST">
                @csrf
                <h3 style="margin-bottom: 1rem;"><i class="fas fa-user"></i> Müşteri Bilgileri</h3>

                <div class="form-group">
                    <label class="form-label">Müşteri Seç *</label>
                    <input value="{{ $musterim->name." ".$musterim->surname }}" id="musteriad" class="form-input" type="text" placeholder="Müşteri Ara" autocomplete="off">

                    <select class="form-select" name="customer_id" required>
                        <option value="">-- Müşteri Seçin --</option>
                        @foreach($musteriler as $musteri)
                            <option @if($musterim->id == $musteri->id)selected @endif value="{{ $musteri->id }}">{{ $musteri->name." ".$musteri->surname }} ({{ $musteri->email }})</option>
                        @endforeach

                    </select>
                    <div class="customer-actions">
                        <a href="{{ route('musteri') }}?redirect=edit&id={{ $fatura->id }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-user-plus"></i> Yeni Müşteri Ekle
                        </a>
                    </div>
                </div>

                <h3 style="margin: 2rem 0 1rem;"><i class="fas fa-list"></i> Fatura Kalemleri</h3>
                <div id="invoiceItems" class="invoice-items">


                    <?php
                    $kalemler=json_decode($fatura->body,true);
                    $index=0;
                    ?>

                    @foreach($kalemler as $kalem)

                        <div class="invoice-item">
                            <div class="form-group">
                                <label class="form-label">Ürün/Hizmet</label>
                                <input value="{{ $kalem['name'] }}" type="text" class="form-input" name="items[{{$index}}][name]" placeholder="Ürün adı" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Miktar</label>
                                <input value="{{ $kalem['quantity'] }}" type="number" class="form-input" name="items[{{$index}}][quantity]" value="1" min="1" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Birim Fiyat (₺)</label>
                                <input value="{{ $kalem['price'] }}" type="number" class="form-input" name="items[{{$index}}][price]" step="0.01" placeholder="0.00" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tutar</label>
                                <input value="{{ $kalem['total'] }}" type="text" class="form-input item-total" readonly placeholder="₺0,00">
                            </div>
                            <button type="button" class="remove-item" onclick="removeItem(this)" title="Sil">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                            <?php
                            $index++;
                            ?>

                    @endforeach

                </div>
                <button type="button" class="btn btn-secondary" onclick="addItem()">
                    <i class="fas fa-plus"></i> Kalem Ekle
                </button>

                <div class="tax-settings">
                    <div class="form-group" style="width: 150px;">
                        <label class="form-label">KDV Oranı (%)</label>
                        <input type="number" id="taxRateInput" name="tax_rate" class="form-input" value="{{ $fatura->tax_rate }}" min="0" max="100">
                    </div>
                </div>

                <div class="totals-section">
                    <div class="totals-row">
                        <span>Ara Toplam</span>
                        <span id="subtotal">₺0,00</span>
                    </div>
                    <div class="totals-row">
                        <span>KDV (<span id="taxLabel">%20</span>)</span>
                        <span id="tax">₺0,00</span>
                    </div>
                    <div class="totals-row">
                        <span>Genel Toplam</span>
                        <span id="grandTotal">₺0,00</span>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <label class="form-label">Fatura Notu (Opsiyonel)</label>
                    <textarea class="form-textarea" name="notes" placeholder="Fatura üzerinde görünecek notlar..." rows="3">{{ $fatura->note }}</textarea>
                </div>

                <div style="margin-top: 2rem; display: flex; gap: 1rem; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Fatura Oluştur
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        const formatMoney = (amount) => {
            return new Intl.NumberFormat('tr-TR', { style: 'currency', currency: 'TRY' }).format(amount);
        };

        function calculateTotals() {
            const items = document.querySelectorAll('.invoice-item');
            let subtotal = 0;

            items.forEach(item => {
                const qtyInput = item.querySelector('input[name$="[quantity]"]');
                const priceInput = item.querySelector('input[name$="[price]"]');
                const totalInput = item.querySelector('.item-total');

                const qty = parseFloat(qtyInput.value) || 0;
                const price = parseFloat(priceInput.value) || 0;

                const rowTotal = qty * price;
                subtotal += rowTotal;

                if (totalInput) {
                    totalInput.value = formatMoney(rowTotal);
                }
            });

            const taxRate = parseFloat(document.getElementById('taxRateInput').value) || 0;

            const taxAmount = (subtotal * taxRate) / 100;
            const grandTotal = subtotal + taxAmount;

            document.getElementById('taxLabel').textContent = '%' + taxRate;
            document.getElementById('subtotal').textContent = formatMoney(subtotal);
            document.getElementById('tax').textContent = formatMoney(taxAmount);
            document.getElementById('grandTotal').textContent = formatMoney(grandTotal);
        }

        document.getElementById('invoiceItems').addEventListener('input', calculateTotals);
        document.getElementById('taxRateInput').addEventListener('input', calculateTotals);

        let itemIndex = {{ $index }};

        function addItem() {
            const container = document.getElementById('invoiceItems');
            const item = document.createElement('div');
            item.className = 'invoice-item';

            item.innerHTML = `
                <div class="form-group">
                    <input type="text" class="form-input" name="items[${itemIndex}][name]" placeholder="Ürün adı" required>
                </div>
                <div class="form-group">
                    <input type="number" class="form-input" name="items[${itemIndex}][quantity]" value="1" min="1" required>
                </div>
                <div class="form-group">
                    <input type="number" class="form-input" name="items[${itemIndex}][price]" step="0.01" placeholder="0.00" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-input item-total" readonly placeholder="₺0,00">
                </div>
                <button type="button" class="remove-item" onclick="removeItem(this)" title="Sil">
                    <i class="fas fa-trash"></i>
                </button>
            `;
            container.appendChild(item);
            itemIndex++;
            calculateTotals();
        }

        function removeItem(btn) {
            const items = document.querySelectorAll('.invoice-item');
            if (items.length > 1) {
                btn.closest('.invoice-item').remove();
                calculateTotals();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            calculateTotals();

            const searchInput = document.getElementById('musteriad');
            const selectBox = document.querySelector('select[name="customer_id"]');
            const allOptions = Array.from(selectBox.options);

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLocaleLowerCase('tr-TR');
                selectBox.innerHTML = '';
                selectBox.appendChild(allOptions[0]);

                allOptions.slice(1).forEach(option => {
                    const optionText = option.textContent.toLocaleLowerCase('tr-TR');
                    if (optionText.includes(searchTerm)) {
                        selectBox.appendChild(option);
                    }
                });

                if (searchTerm.length > 0 && selectBox.options.length > 1) {
                    let visibleItems = selectBox.options.length;
                    selectBox.size = visibleItems > 5 ? 5 : visibleItems;
                } else {
                    selectBox.size = 1;
                }
            });

            selectBox.addEventListener('change', function() {
                this.size = 1;
                if (this.value !== "") {
                    searchInput.value = this.options[this.selectedIndex].text.split(' (')[0];
                }
            });

            document.addEventListener('click', function(event) {
                if (event.target !== searchInput && event.target !== selectBox) {
                    selectBox.size = 1;
                }
            });
        });
    </script>
@endsection
