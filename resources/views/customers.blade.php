{{--
***********************************************************
Adı Soyadı: Gaffar Korkmaz
Öğrenci Numarası: 262484021
***********************************************************
--}}
@extends('layouts.app')

@section('title', 'Müşteriler')

@php($sidebar = 'musteriler')

@section('content')


    <style>
        .dataTables_wrapper { color: #a0aec0; font-family: 'Inter', sans-serif; }

        .dataTables_filter label, .dataTables_info, .dataTables_length label { color: #a0aec0 !important; font-size: 13px; }

        table.dataTable thead th {
            background-color: #1a1c2e !important;
            color: #718096 !important;
            border-bottom: 1px solid #2d3748 !important;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 1px;
            padding: 15px !important;
        }

        table.dataTable tbody tr {
            background-color: #242640 !important;
            border: none !important;
        }

        table.dataTable tbody td {
            padding: 18px 15px !important;
            color: #e2e8f0 !important;
            border-bottom: 8px solid #1a1c2e !important;
        }

        table.dataTable tbody tr:hover { background-color: #2d304f !important; }

        .dataTables_filter input {
            background: #1a1c2e !important;
            border: 1px solid #4a5568 !important;
            color: white !important;
            border-radius: 8px !important;
            padding: 6px 12px !important;
        }

        .dataTables_paginate .paginate_button {
            color: #a0aec0 !important;
            border: 1px solid #2d3748 !important;
            background: #242640 !important;
            border-radius: 6px !important;
        }

        .dataTables_paginate .paginate_button.current {
            background: #6366f1 !important;
            color: white !important;
            border: none !important;
        }

        .badge { border: none !important; font-weight: 600; text-transform: uppercase; font-size: 10px; }

        .dataTables_paginate {
            margin-top: 15px !important;
            display: flex !important;
            align-items: center;
            gap: 5px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background: #242640 !important;
            color: #a0aec0 !important;
            border: 1px solid #3d4161 !important;
            border-radius: 6px !important;
            padding: 5px 12px !important;
            margin: 0 2px !important;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #3d4161 !important;
            color: white !important;
            border-color: #6366f1 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #6366f1 !important;
            color: white !important;
            border: 1px solid #6366f1 !important;
            font-weight: bold;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.4;
            cursor: not-allowed;
            background: #1a1c2e !important;
        }

        .dataTables_info {
            color: #718096 !important;
            font-size: 13px;
            padding-top: 20px !important;
        }
    </style>
    <main class="main-content">
        <div class="page-header">
            <div>
                <h1>Müşteriler</h1>
                <p>Tüm müşterilerinizi yönetin</p>
            </div>
            <a href="{{ route('musteri') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Yeni Müşteri</a>
        </div>



        <!-- Table -->
        <div class="card">
            <div class="table-wrapper">

                <table id="invoices-table" class="display" style="width:100%">
                    <thead>
                    <tr>
                        <th>Müşteri No</th>
                        <th>Müşteri Adı</th>
                        <th>Eposta</th>
                        <th>Telefon</th>
                        <th>Tür</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <script>
                    $('#invoices-table').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "dom": '<"d-flex justify-content-between align-items-center mb-3"f>rt<"d-flex justify-content-between align-items-center mt-3"ip>',
                        "ajax": {
                            "url": "{{ route('musteri.data') }}",
                            "type": "GET"
                        },
                        "columns": [
                            { "data": "id" },
                            { "data": "ad_soyad" },
                            { "data": "email" },
                            { "data": "telefon" },
                            { "data": "tip" },
                            { "data": "islemler", "orderable": false, "searchable": false }
                        ],
                        "language": {
                            "url": "cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json",
                            "search": "Ara:",
                            "lengthMenu": "_MENU_ kayıt göster",
                            "info": "_TOTAL_ fatura arasından _START_ - _END_ arası gösteriliyor",
                        }
                    });
                </script>
            </div>
        </div>
    </main>


@endsection
