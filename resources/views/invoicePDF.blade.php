<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Denda - Perpustakaan Lempuing</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<style scoped>
    body {
        font-family: Arial, Helvetica, sans-serif;
        color: #111827;
        padding: 20px;
    }

    .header,
    .footer {
        text-align: center;
        margin-bottom: 20px;
    }

    .header h1,
    .footer h4 {
        margin: 0;
    }

    footer {
        position: fixed;
        bottom: 0;
        width: 100%;
    }

    .invoice-details {
        margin-bottom: 30px;
    }

    .invoice-details th,
    .invoice-details td {
        padding: 10px;
        text-align: left;
    }

    .total {
        font-weight: bold;
    }
</style>

<body>

    <header class="header">
        <h1>Perpustakaan Lempuing</h1>
        <p>Jl. Bukit DSN 1 Desa Tugu Mulyo Kec. Lempuing Kab. OKI Sumatera Selatan</p>
        <p>Email: - | Telp: 0821-8265-4583</p>
    </header>

    <section>
        <h2>Invoice Denda</h2>
        <p>Invoice ID: {{ $invoice->paymentId }}</p>
        <p>Tanggal: {{ \Carbon\Carbon::parse($invoice->created_at)->translatedFormat('d F Y') }}</p>
        <p>Nama Member: {{ $invoice->fine->loan->member->user->username }}</p>
        <p>NISN: {{ $invoice->fine->loan->member->user->nisn }}</p>
    </section>

    <table class="table table-bordered invoice-details">
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th>Harga Denda</th>
                <th>Jumlah Dibayar</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Denda Buku: "{{ $invoice->fine->loan->book->name }}"</td>
                <td>Rp{{ number_format($invoice->total_price, 0, ',', '.') }}</td>
                <td>Rp{{ number_format($invoice->total_paid, 0, ',', '.') }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="text-right total">Jumlah Kembalian</td>
                <td class="total">Rp{{ number_format($invoice->return, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <footer class="footer">
        <h4>Terima Kasih Atas Tanggung Jawab Anda</h4>
        <p>Harap lakukan pengembalian buku tepat waktu untuk menghindari denda.</p>
    </footer>

</body>

</html>
