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
    <title>Fatura Detayı - {{ getFunction('site') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/' . getFunction('favicon')) }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ url('css/style.css') }}">
    <style>
        .payment-section {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #e2e8f0;
            background: #ffffff;
            border-radius: 8px;
            padding: 2rem;
            color: #1e293b;
        }

        .payment-method-option .pm-info h5 {
            color: #0f172a;
            font-weight: 600;
            margin: 0 0 0.25rem 0;
            font-size: 1rem;
        }

        .payment-method-option .pm-info p {
            color: #64748b;
            margin: 0;
            font-size: 0.875rem;
        }

        .payment-section h4 {
            color: #6366f1;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .payment-methods-list {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .payment-method-option input[type="radio"],
        .payment-method-option .radio-circle {
            display: none;
        }

        .payment-method-option {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 3rem 1rem 1rem;
            background: #ffffff;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .payment-method-option:hover {
            border-color: #6366f1;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .payment-method-option.selected {
            border-color: #22c55e;
            background: #ffffff;
            box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.2);
        }

        .payment-method-option.selected::after {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: #22c55e;
            position: absolute;
            right: 1rem;
            font-size: 1.2rem;
        }

        /* Hide the default radio circle when selected if we use custom styling,
           or style it better. Let's rely on the custom visual cues. */

        .bank-info-box {
            display: none;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .bank-info-box.visible {
            display: block;
        }

        .bank-info-box h5 {
            margin: 0 0 0.75rem 0;
            color: #6366f1;
            font-size: 0.8125rem;
        }

        .bank-info-row {
            display: flex;
            justify-content: space-between;
            padding: 0.375rem 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .bank-info-row:last-of-type {
            border-bottom: none;
        }

        .bank-info-row .label {
            color: #64748b;
        }

        .bank-info-row .value {
            font-weight: 500;
            color: #1e293b;
        }

        .copy-btn {
            background: none;
            border: none;
            color: #6366f1;
            cursor: pointer;
            padding: 2px 6px;
            margin-left: 4px;
            border-radius: 4px;
            font-size: 0.75rem;
        }

        .copy-btn:hover {
            background: rgba(99, 102, 241, 0.1);
        }

        /* Pay Button */
        .pay-btn {
            width: 100%;
            padding: 0.875rem 1.5rem;
            background: linear-gradient(135deg, #22c55e 0%, #10b981 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .pay-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.4);
        }

        .pay-btn:disabled {
            background: #94a3b8;
            cursor: not-allowed;
        }

        @media (max-width: 768px) {
            .payment-method-option {
                padding: 0.625rem 0.75rem;
            }

            .payment-method-option .pm-logo {
                width: 32px;
                height: 22px;
            }

            .payment-method-option .pm-info h5 {
                font-size: 0.8125rem;
            }
        }

        @media print {
            .payment-section {
                display: none !important;
            }
        }
    </style>
</head>

<body>
<div class="page-wrapper" style="margin-left: 0;">
    <main class="main-content" style="margin-left: 0; max-width: 900px; margin: 0 auto;">
        <div class="page-header no-print">
            <div>
                <h1> Fatura Detayı</h1>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-secondary" onclick="window.print()"><i class="fas fa-print"></i>
                    Yazdır</button>
            </div>
        </div>

        <!-- Invoice -->
        <div class="invoice-container">
            <div class="invoice-header">
                <div class="invoice-logo">
                    <h2> {{ getFunction('site') }}</h2>
                    <p style="color: #64748b;">Fatura</p>
                </div>
                <div class="invoice-details">
                    <h3>INV-{{ $invoice->id }}</h3>
                    <p><strong>Tarih:</strong> {{ date("d.m.Y", $invoice->created_time+10800) }}</p>
                    <p><strong>Durum:</strong> <span class="badge badge-@if ($invoice->status == 1)success @elseif ($invoice->status == 0)warning @endif">@if ($invoice->status == 1)Ödendi @elseif ($invoice->status == 0)Bekliyor @endif</span></p>
                </div>
            </div>
            @if(session('error'))
                <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 10px;">
                    {{ session('error') }}
                </div>
            @endif
            <div class="invoice-parties">
                <div class="invoice-party">
                    <h4>Gönderen</h4>
                    <p><strong>{{ getFunction('sirket') }}</strong></p>
                    <p>{{ getFunction('adres') }}</p>
                    <p>{{ getFunction('eposta') }}</p>
                    <p>{{ getFunction('telefon') }}</p>
                </div>
                <div class="invoice-party">
                    <h4>Alıcı</h4>
                    <p><strong>{{ $customer->name." ".$customer->surname }}</strong></p>
                    <p>{{ $customer->district.", ".$customer->city }}</p>
                    <p>{{ $customer->email }}</p>
                    <p>{{ $customer->phone }}</p>
                </div>
            </div>

            <table class="invoice-table">
                <thead>
                <tr>
                    <th>Ürün/Hizmet</th>
                    <th style="text-align: center;">Miktar</th>
                    <th style="text-align: right;">Birim Fiyat</th>
                    <th style="text-align: right;">Toplam</th>
                </tr>
                </thead>
                <tbody>
                @php
                $urunler=json_decode($invoice->body, true);
                @endphp
                @foreach( $urunler as $urun )
                <tr>
                    <td>{{ $urun['name'] }}</td>
                    <td style="text-align: center;">{{ $urun['quantity'] }}</td>
                    <td style="text-align: right;">₺{{ $urun['price'] }}</td>
                    <td style="text-align: right;">₺{{ $urun['total'] }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>

            <div class="invoice-totals">
                <table class="invoice-totals-table">
                    <tr>
                        <td>Ara Toplam</td>
                        <td>₺{{ $invoice->total }}</td>
                    </tr>
                    @php
                        $kdvtutar=(($invoice->total*$invoice->tax_rate)/100)
                    @endphp
                    @if($invoice->tax_rate != 0)
                        <tr>
                            <td>KDV (%{{ $invoice->tax_rate }})</td>
                            <td>₺{{ $kdvtutar }}</td>
                        </tr>
                    @endif
                    <tr class="total">
                        <td>TOPLAM</td>
                        <td>₺{{ $kdvtutar+$invoice->total }}</td>
                    </tr>
                </table>
            </div>

            <div class="payment-section">
                <h4><i class="fas fa-credit-card"></i> Ödeme Yöntemi Seçin</h4>

                <form action="{{ route('fatura.payment', [$invoice->id,$invoice->invoiceid]) }}" method="POST" id="paymentForm">
                   @csrf
                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                    <input type="hidden" name="payment_method" id="selectedMethod" value="">

                    <div class="payment-methods-list">

                        @foreach($gateways as $gateway)
                            <label class="payment-method-option" data-method="{{ $gateway->name }}">
                                <input type="radio" name="method" value="{{ $gateway->name }}">
                                <span class="radio-circle"></span>
                                <div class="pm-logo">
                                    <img width="50" src="{{ $gateway->logo }}" alt="{{ $gateway->name }}"
                                         onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\'fas fa-credit-card\' style=\'color:#1E64FF\'></i>';">
                                </div>
                                <div class="pm-info">
                                    <h5>{{ $gateway->value }} ile Öde</h5>
                                    <p>{{ $gateway->description }}</p>
                                </div>
                            </label>
                        @endforeach




                    </div>



                    <button type="submit" class="pay-btn" id="payButton" disabled>
                        <i class="fas fa-lock"></i> <span id="payButtonText">Ödeme Yöntemi Seçin</span>
                    </button>
                </form>
            </div>

        </div>
    </main>
</div>

<script src="{{ url('js/app.js') }}"></script>
<script>
    const paymentOptions = document.querySelectorAll('.payment-method-option');
    const selectedMethodInput = document.getElementById('selectedMethod');
    const payButton = document.getElementById('payButton');
    const payButtonText = document.getElementById('payButtonText');
    const totalAmount = '₺{{$kdvtutar+$invoice->total}}';

    paymentOptions.forEach(option => {
        option.addEventListener('click', () => {
            paymentOptions.forEach(o => o.classList.remove('selected'));
            option.classList.add('selected');
            const method = option.dataset.method;
            selectedMethodInput.value = method;


                payButtonText.textContent = 'Güvenli Ödeme Yap - ' + totalAmount;

            payButton.disabled = false;
        });
    });

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            showNotification('Kopyalandı!', 'success');
        });
    }

    document.getElementById('paymentForm').addEventListener('submit', (e) => {
        if (!selectedMethodInput.value) {
            e.preventDefault();
            showNotification('Lütfen bir ödeme yöntemi seçin', 'error');
        }
    });
</script>
</body>

</html>
