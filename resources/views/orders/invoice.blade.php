<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>INVOICE - {{ $order->order_number }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; font-size: 12px; color: #333; margin: 0; padding: 20px; line-height: 1.5; }
        .invoice-box { max-w: 800px; margin: auto; padding: 30px; border: 1px solid #eee; border-radius: 12px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.05); }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #16a34a; padding-bottom: 20px; margin-bottom: 20px; }
        .logo { font-size: 24px; font-weight: 900; color: #16a34a; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { padding: 10px; border-bottom: 1px solid #eee; text-align: left; }
        .table th { background: #f9fafb; font-weight: bold; text-transform: uppercase; font-size: 10px; color: #666; }
        .total-box { margin-top: 20px; text-align: right; }
        .total-box table { float: right; width: 250px; }
        .btn-print { background: #16a34a; color: white; border: none; padding: 10px 20px; border-radius: 6px; font-weight: bold; cursor: pointer; margin-bottom: 20px; }
        @media print { .btn-print { display: none; } .invoice-box { border: none; shadow: none; } }
    </style>
</head>
<body>

    <button onclick="window.print()" class="btn-print">🖨️ Cetak Invoice / Download PDF</button>

    <div class="invoice-box">
        <div class="header">
            <div>
                <div class="logo">TOKO PAK IMAM</div>
                <div style="font-size: 10px; color: #666;">Minimarket Online Kebutuhan Harian</div>
                <div style="font-size: 10px; color: #666;">Jl. Raya Kebayoran Baru No. 88, Jakarta Selatan</div>
            </div>
            <div style="text-align: right;">
                <h2 style="margin: 0; color: #16a34a;">INVOICE</h2>
                <div>No: <strong>{{ $order->order_number }}</strong></div>
                <div>Tanggal: {{ $order->created_at->format('d M Y H:i') }}</div>
            </div>
        </div>

        <table style="width: 100%; margin-bottom: 20px;">
            <tr>
                <td style="vertical-align: top; width: 50%;">
                    <strong>Penerima:</strong><br>
                    {{ $order->recipient_name }}<br>
                    Telp: {{ $order->phone }}<br>
                    Alamat: {{ $order->address_text }}
                </td>
                <td style="vertical-align: top; width: 50%; text-align: right;">
                    <strong>Info Pengiriman & Bayar:</strong><br>
                    Kurir: {{ $order->courier_name }}<br>
                    Metode Bayar: {{ strtoupper($order->payment ? $order->payment->payment_method : 'COD') }}<br>
                    Status: <strong>{{ strtoupper($order->status) }}</strong>
                </td>
            </tr>
        </table>

        <table class="table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th style="text-align: center;">Harga</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td style="text-align: center;">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right;">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-box">
            <table>
                <tr>
                    <td>Subtotal:</td>
                    <td>Rp{{ number_format($order->subtotal, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Ongkos Kirim:</td>
                    <td>Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                </tr>
                @if($order->discount_amount > 0)
                <tr>
                    <td>Diskon:</td>
                    <td>-Rp{{ number_format($order->discount_amount, 0, ',', '.') }}</td>
                </tr>
                @endif
                <tr style="font-weight: bold; font-size: 14px; border-top: 2px solid #16a34a;">
                    <td>Total Tagihan:</td>
                    <td style="color: #16a34a;">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                </tr>
            </table>
            <div style="clear: both;"></div>
        </div>

        <div style="margin-top: 40px; text-align: center; color: #888; font-size: 11px;">
            Terima kasih telah berbelanja di <strong>Toko Pak Imam</strong>!<br>
            Untuk pertanyaan seputar pesanan ini, hubungi Customer Care kami di 0812-3456-7890.
        </div>
    </div>

</body>
</html>
