<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <title>Struk {{ $transaksi->kode_transaksi }}</title>

    <style>
        @page {
            size: 80mm auto;
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 6mm 5mm;

            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 9px;
            line-height: 1.35;

            color: #111;
            background: #fff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 0;
            vertical-align: top;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        /* =========================
           HEADER
        ========================= */

        .store-name {
            font-size: 17px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .store-subtitle {
            margin-top: 2px;
            font-size: 9px;
            font-weight: bold;
            letter-spacing: .5px;
        }

        .store-info {
            margin-top: 4px;
            font-size: 8px;
            color: #555;
        }

        /* =========================
           GARIS
        ========================= */

        .line-solid {
            border-top: 2px solid #111;
            margin: 7px 0;
        }

        .line-dashed {
            border-top: 1px dashed #555;
            margin: 7px 0;
        }

        /* =========================
           INFO TRANSAKSI
        ========================= */

        .info-table {
            width: 100%;
        }

        .info-table td {
            padding: 2px 0;
        }

        .info-label {
            width: 34%;
            color: #555;
        }

        .info-value {
            width: 66%;
            text-align: right;
            font-weight: bold;

            /* Supaya teks panjang tidak keluar */
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        /* =========================
           PESANAN
        ========================= */

        .section-title {
            font-size: 9px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .item {
            margin-bottom: 7px;
        }

        .item-name {
            font-size: 9px;
            font-weight: bold;

            /* Nama menu panjang boleh turun */
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .item-detail {
            width: 100%;
            margin-top: 1px;
        }

        .item-qty {
            width: 55%;
            color: #444;
        }

        .item-price {
            width: 45%;
            text-align: right;
            color: #444;
            white-space: nowrap;
        }

        /* =========================
           RINGKASAN
        ========================= */

        .summary-table {
            width: 100%;
        }

        .summary-table td {
            padding: 2px 0;
        }

        .summary-label {
            width: 45%;
        }

        .summary-value {
            width: 55%;
            text-align: right;
            white-space: nowrap;
        }

        .grand-total td {
            padding: 3px 0;
            font-size: 12px;
            font-weight: bold;
        }

        /* =========================
           STATUS PEMBAYARAN
        ========================= */

        .payment-box {
            margin-top: 7px;
            padding: 6px;

            border: 1px solid #777;
            text-align: center;
        }

        .payment-title {
            font-size: 8px;
            color: #555;
            margin-bottom: 2px;
            text-transform: uppercase;
        }

        .payment-status {
            font-size: 10px;
            font-weight: bold;
        }

        /* =========================
           FOOTER
        ========================= */

        .footer {
            margin-top: 10px;
            text-align: center;
        }

        .footer-main {
            font-size: 9px;
            font-weight: bold;
        }

        .footer-small {
            margin-top: 2px;
            font-size: 7.5px;
            color: #666;
        }
    </style>
</head>

<body>

    {{-- =====================================
         HEADER
    ====================================== --}}

    <div class="center">

        <div class="store-name">
            RASA BERKISAH
        </div>

        <div class="store-subtitle">
            COFFEE POINT
        </div>

        <div class="store-info">
            Terima kasih telah berkunjung
        </div>

    </div>


    <div class="line-solid"></div>


    {{-- =====================================
         INFORMASI TRANSAKSI
    ====================================== --}}

    <table class="info-table">

        <tr>
            <td class="info-label">
                No. Transaksi
            </td>

            <td class="info-value">
                {{ $transaksi->kode_transaksi }}
            </td>
        </tr>

        <tr>
            <td class="info-label">
                Tanggal
            </td>

            <td class="info-value">
                {{ $transaksi->waktu_bayar
                    ? \Carbon\Carbon::parse($transaksi->waktu_bayar)->format('d/m/Y H:i')
                    : '-' }}
            </td>
        </tr>

        <tr>
            <td class="info-label">
                Meja
            </td>

            <td class="info-value">
                {{ $transaksi->meja?->nama_meja ?? '-' }}
            </td>
        </tr>

        <tr>
            <td class="info-label">
                Pelanggan
            </td>

            <td class="info-value">
                {{ $transaksi->nama_pelanggan ?: '-' }}
            </td>
        </tr>

    </table>


    <div class="line-dashed"></div>


    {{-- =====================================
         PESANAN
    ====================================== --}}

    <div class="section-title">
        PESANAN
    </div>


    @foreach($transaksi->detail as $detail)

        <div class="item">

            <div class="item-name">
                {{ $detail->menu?->nama_makanan ?? 'Menu' }}
            </div>

            <table class="item-detail">

                <tr>

                    <td class="item-qty">
                        {{ $detail->qty }}
                        x
                        Rp {{ number_format($detail->harga, 0, ',', '.') }}
                    </td>

                    <td class="item-price">
                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                    </td>

                </tr>

            </table>

        </div>

    @endforeach


    <div class="line-dashed"></div>


    {{-- =====================================
         TOTAL PEMBAYARAN
    ====================================== --}}

    <table class="summary-table">

        <tr class="grand-total">

            <td class="summary-label">
                TOTAL
            </td>

            <td class="summary-value">
                Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
            </td>

        </tr>

        <tr>

            <td class="summary-label">
                Bayar
            </td>

            <td class="summary-value">
                Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}
            </td>

        </tr>

        <tr>

            <td class="summary-label">
                Kembalian
            </td>

            <td class="summary-value">
                Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}
            </td>

        </tr>

    </table>


    {{-- =====================================
         STATUS PEMBAYARAN
    ====================================== --}}

    <div class="payment-box">

        <div class="payment-title">
            Status Pembayaran
        </div>

        <div class="payment-status">
            LUNAS
        </div>

    </div>


    {{-- =====================================
         FOOTER
    ====================================== --}}

    <div class="footer">

        <div class="footer-main">
            Terima Kasih ❤️
        </div>

        <div class="footer-small">
            Selamat menikmati pesanan Anda
        </div>

        <div class="footer-small">
            RASA BERKISAH • COFFEE POINT
        </div>

    </div>

</body>

</html>