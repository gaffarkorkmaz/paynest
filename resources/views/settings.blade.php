{{--
***********************************************************
Adı Soyadı: Gaffar Korkmaz
Öğrenci Numarası: 262484021
***********************************************************
--}}
@extends('layouts.app')

@section('title', 'Ayarlar')

<?php $sidebar = 'ayarlar'; ?>


@section('content')


    <main class="main-content">
        <div class="page-header">
            <div>
                <h1><i class="fas fa-cog"></i> Ayarlar</h1>
                <p>Hesap ve ödeme ayarlarınızı yönetin</p>
            </div>
        </div>

        <div class="settings-tabs">
            <a href="#" class="settings-tab active" data-tab="payment"><i class="fas fa-credit-card"></i> Ödeme
                Yöntemleri</a>
            <a href="#" class="settings-tab" data-tab="company"><i class="fas fa-building"></i> Şirket Bilgileri</a>
            <a href="#" class="settings-tab" data-tab="account"><i class="fas fa-user"></i> Hesap</a>
        </div>
        @if(session('error'))
            <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 10px;">
                {{ session('error') }}
            </div>
        @endif
        <div id="payment" class="settings-section active">
            <div class="card mb-4">
                <h3 style="margin-bottom: 0.5rem;"><i class="fas fa-info-circle" style="color: var(--primary);"></i>
                    Ödeme Entegrasyonları</h3>
                <p class="text-muted">Faturalarınızda kullanmak istediğiniz ödeme yöntemlerini aktif edin ve
                    yapılandırın.</p>
            </div>

            <div class="payment-methods-grid">
                <?php foreach($gateways as $gateway): ?>
                <div class="payment-method-card <?php if($gateway->status == 1) echo 'active'; ?>">
                    <div class="payment-method-status">

                            <?php if($gateway->status == 1){ echo '<span class="status-badge active"><i class="fas fa-check-circle"></i> Aktif</span>'; }else{ echo '<span class="status-badge inactive">Pasif</span>'; } ?>


                    </div>
                    <div class="payment-method-header">
                        <div class="payment-method-logo">
                            <img src="<?= $gateway->logo ?>" alt="<?= $gateway->name ?>"
                                 onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\'fas fa-credit-card\' style=\'color:#1E64FF\'></i>';">
                        </div>
                        <div class="payment-method-info">
                            <h4><?= $gateway->value ?></h4>
                            <p><?= $gateway->description ?></p>
                        </div>
                    </div>
                    <div class="payment-method-actions">
                        <button class="btn btn-secondary btn-sm" onclick="openModal('<?= $gateway->name ?>')"><i
                                class="fas fa-cog"></i> Ayarlar</button>
                        <?php
                            if ($gateway->status == 1) {
                            ?>
                        <a href="{{ route('pasif-et', $gateway->id) }}"><button class="btn btn-danger btn-sm"><i class="fas fa-power-off"></i> Devre Dışı Bırak</button></a>
                    <?php
                            }else{
                                ?>

                        <a href="{{ route('aktif-et', $gateway->id) }}"><button class="btn btn-success btn-sm"><i class="fas fa-power-off"></i> Aktif Et</button></a>

                        <?php
                        }
                        ?>
                    </div>


                </div>
                <?php endforeach; ?>

            </div>
        </div>

        <div id="company" class="settings-section">
            <div class="card">
                <form enctype="multipart/form-data" action="{{ route('sirket.post') }}" method="POST">
                    @csrf
                    <div class="settings-form-section">
                        <h3><i class="fas fa-building"></i> Şirket Bilgileri</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Şirket Adı *</label>
                                <input value="{{ getFunction("sirket") }}" type="text" class="form-input" name="company_name"
                                       placeholder="Şirketinizin adı">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Telefon</label>
                                <input value="{{ getFunction("telefon") }}" type="tel" class="form-input" name="phone" placeholder="+90 212 123 4567">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">E-posta</label>
                            <input value="{{ getFunction("eposta") }}" type="email" class="form-input" name="email" placeholder="info@sirket.com">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Adres</label>
                            <textarea class="form-textarea" name="address" placeholder="Şirket adresi"
                                      rows="3">{{ getFunction("adres") }}</textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Site Başlığı *</label>
                                <input value="{{ getFunction("site") }}" type="text" class="form-input" name="site"
                                       placeholder="Site başlığı">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Site Favicon</label>
                                <input type="file" class="form-input" name="favicon">
                            </div>
                        </div>
                    </div>



                    <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                        <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i>
                            Kaydet</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="account" class="settings-section">
            <div class="card">
                <form action="{{ route('profil.post') }}" method="POST">
                    @csrf
                    <div class="settings-form-section">
                        <h3><i class="fas fa-user"></i> Profil Bilgileri</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Ad Soyad</label>
                                <input value="{{ $user->name }}" type="text" class="form-input" required name="name" placeholder="Adınız Soyadınız">
                            </div>
                            <div class="form-group">
                                <label class="form-label">E-posta</label>
                                <input value="{{ $user->email }}" type="email" class="form-input" required name="email" placeholder="ornek@email.com">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Telefon</label>
                            <input value="{{ $user->phone }}" type="tel" class="form-input" required name="phone" placeholder="+90 555 123 4567">
                        </div>
                    </div>

                    <div class="settings-form-section">
                        <h3><i class="fas fa-lock"></i> Şifre Değiştir</h3>
                        <div class="form-group">
                            <label class="form-label">Mevcut Şifre</label>
                            <input type="password" class="form-input" name="current_password"
                                   placeholder="••••••••">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Yeni Şifre</label>
                                <input type="password" class="form-input" name="new_password"
                                       placeholder="••••••••">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Yeni Şifre (Tekrar)</label>
                                <input type="password" class="form-input" name="new_password_confirm"
                                       placeholder="••••••••">
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                        <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i>
                            Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <div class="modal-overlay" id="posModal">
        <div class="modal">
            <div class="modal-header">
                <h3><i class="fas fa-cog"></i> <span id="modalTitle">POS Ayarları</span></h3>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <form action="{{ route('ayarlar.pos') }}" method="POST" id="posForm">
                @csrf
                <input type="hidden" name="provider" id="posProvider">

                <?php foreach($gateways as $gateway): ?>

                <div id="form-<?= $gateway->name ?>" class="pos-form" style="display: none;">
                        <?php
                        $credentials = json_decode($gateway->credentials, true);
                        ?>

                        <?php foreach($credentials as $credential => $veri): ?>

                        <?php
                        if ($credential == "testMode") {

                            ?>
                    <div class="form-group">
                        <label class="form-label">Mod</label>
                        <select class="form-select" name="testMode">
                            <option <?php if ($veri == 1) { echo "selected"; } ?> value="1">Test</option>
                            <option <?php if ($veri == 0) { echo "selected"; } ?> value="0">Canlı</option>
                        </select>
                    </div>

                    <?php
                        continue;
                        }
                        ?>

                    <div class="form-group">
                        <label class="form-label"><?= $credential ?> *</label>
                        <input type="text" value="<?= $veri; ?>" class="form-input" name="<?= $credential ?>" placeholder="<?= $credential ?>">
                    </div>
                    <?php endforeach; ?>

                    <div class="webhook-box">
                        <h5>Webhook/Callback Ayarı</h5>
                        <p style="font-size: 0.875rem; color: var(--text-secondary);">
                            Bu URL adresini {{ $gateway->value }} panelinizdeki Webhook/Callback kısmına
                            yapıştırmalısınız.
                        </p>
                        <div class="webhook-url">
                            <span>{{ url($gateway->name."/callback") }}</span>

                        </div>
                    </div>

                </div>

                <?php endforeach; ?>


                <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">İptal</button>
                    <button type="submit" class="btn btn-primary" style="flex: 1;"><i class="fas fa-save"></i>
                        Kaydet</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Tab switching
        document.querySelectorAll('.settings-tab').forEach(tab => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();
                const tabId = tab.dataset.tab;

                // Update tabs
                document.querySelectorAll('.settings-tab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                // Update sections
                document.querySelectorAll('.settings-section').forEach(s => s.classList.remove('active'));
                document.getElementById(tabId).classList.add('active');
            });
        });

        // Modal functions
        const modalTitles = {
            'iyzico': 'iyzico Ayarları',
            'paytr': 'PayTR Ayarları',
            'param': 'Param Ayarları',
            'stripe': 'Stripe Ayarları',
            'bank': 'Banka Hesap Bilgileri'
        };

        function openModal(provider) {
            document.getElementById('posModal').classList.add('active');
            document.getElementById('modalTitle').textContent = modalTitles[provider] || 'POS Ayarları';
            document.getElementById('posProvider').value = provider;

            // Hide all forms, show selected
            document.querySelectorAll('.pos-form').forEach(f => f.style.display = 'none');
            const form = document.getElementById('form-' + provider);
            if (form) form.style.display = 'block';
        }

        function closeModal() {
            document.getElementById('posModal').classList.remove('active');
        }

        // Close modal on outside click
        document.getElementById('posModal').addEventListener('click', (e) => {
            if (e.target.id === 'posModal') closeModal();
        });

        // Close modal on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeModal();
        });
    </script>


    <style>
        .settings-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 2rem;
            border-bottom: 1px solid var(--border-color);
            overflow-x: auto;
        }

        .settings-tab {
            padding: 1rem 1.5rem;
            color: var(--text-muted);
            font-weight: 500;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease;
            white-space: nowrap;
            text-decoration: none;
        }

        .settings-tab:hover {
            color: var(--text-secondary);
        }

        .settings-tab.active {
            color: var(--primary-light);
            border-bottom-color: var(--primary);
        }

        .settings-section {
            display: none;
        }

        .settings-section.active {
            display: block;
        }

        /* Payment Methods Grid */
        .payment-methods-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
        }

        .payment-method-card {
            background: var(--gradient-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .payment-method-card:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow-glow);
        }

        .payment-method-card.active {
            border-color: var(--success);
        }

        .payment-method-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .payment-method-logo {
            width: 80px;
            height: 50px;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
            overflow: hidden;
        }

        .payment-method-logo img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .payment-method-logo i {
            font-size: 1.5rem;
            color: #333;
        }

        .payment-method-info {
            flex: 1;
        }

        .payment-method-info h4 {
            margin-bottom: 0.25rem;
            font-size: 1.125rem;
        }

        .payment-method-info p {
            font-size: 0.8125rem;
            color: var(--text-muted);
            margin: 0;
        }

        .payment-method-status {
            position: absolute;
            top: 1rem;
            right: 1rem;
        }

        .status-badge {
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-badge.active {
            background: rgba(34, 197, 94, 0.2);
            color: var(--success);
        }

        .status-badge.inactive {
            background: rgba(148, 163, 184, 0.2);
            color: var(--text-muted);
        }

        .payment-method-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.25rem;
            padding-top: 1.25rem;
            border-top: 1px solid var(--border-color);
        }

        .payment-method-actions .btn {
            flex: 1;
        }

        /* Settings Form */
        .settings-form-section {
            margin-bottom: 2.5rem;
        }

        .settings-form-section h3 {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--border-color);
        }

        .settings-form-section h3 i {
            color: var(--primary);
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            padding: 1rem;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 2rem;
            max-width: 550px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }

        .modal-overlay.active .modal {
            transform: scale(1);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .modal-header h3 {
            margin: 0;
        }

        .modal-close {
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0;
            transition: color 0.3s ease;
        }

        .modal-close:hover {
            color: var(--text-primary);
        }

        @media (max-width: 768px) {
            .payment-methods-grid {
                grid-template-columns: 1fr;
            }

            .payment-method-header {
                flex-direction: column;
                text-align: center;
            }

            .payment-method-status {
                position: static;
                margin-top: 0.5rem;
            }

            .settings-tabs {
                padding-bottom: 0.5rem;
            }

            .settings-tab {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }
        }
    </style>
@endsection
