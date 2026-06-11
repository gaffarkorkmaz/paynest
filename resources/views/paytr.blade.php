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
    <title>Online Ödeme - {{ getFunction('site') }}</title>
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
                <h1> Fatura Öde</h1>
            </div>

        </div>

        <!-- Invoice -->
        <div class="invoice-container">

            <script src="https://www.paytr.com/js/iframeResizer.min.js"></script>
            <iframe src="https://www.paytr.com/odeme/guvenli/{{ $token }}" id="paytriframe" frameborder="0" scrolling="no" style="width: 100%;"></iframe>
            <script>iFrameResize({},'#paytriframe');</script>

        </div>
    </main>
</div>

<script src="{{ url('js/app.js') }}"></script>
</body>

</html>
