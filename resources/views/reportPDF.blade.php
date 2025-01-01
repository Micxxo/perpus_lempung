<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan @if ($report->report_type === 'loans')
            Peminjaman
        @elseif ($report->report_type === 'visits')
            Kunjungan
        @elseif ($report->report_type === 'fines')
            Denda
        @elseif ($report->report_type === 'members')
            Member
        @endif
    </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<style scoped>
    body {
        font-family: Arial, Helvetica, sans-serif;
        color: #111827;
    }

    .header-container {
        text-align: center;
        margin-bottom: 32px;
    }

    .header-container h1 {
        font-weight: bold;
        font-size: 24px;
    }

    .header-container p {
        color: #4b5563;
        font-size: 14px;
    }

    .report-details p {
        color: #4b5563;
        font-size: 14px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table th,
    table td {
        border: 1px solid #ddd;
        text-align: left;
        padding: 8px;
    }

    table th {
        background-color: #f4f4f4;
        font-weight: bold;
        text-align: center;
    }

    table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    table tbody tr:hover {
        background-color: #f1f1f1;
    }

    table td p {
        margin: 0;
        font-size: 14px;
    }

    footer {
        width: 100%;
        position: fixed;
        bottom: 0;
        margin-top: 20px;
    }

    footer p {
        color: #6b7280;
        font-size: 0.875rem;
        text-align: center;
    }
</style>

<body>
    <header class="header-container">
        <h1>{{ $report->title }}</h1>
        <p>Dilaporkan oleh: {{ $report->reporter->username }}</p>
    </header>
    <main class="container">
        <!-- Table -->
        <div class="report-details">
            <p>Dilaporkan Pada: {{ $report->created_at }}</p>
            <p>Tipe Laporan: @if ($report->report_type === 'loans')
                    Peminjaman
                @elseif ($report->report_type === 'visits')
                    Kunjungan
                @elseif ($report->report_type === 'fines')
                    Denda
                @elseif ($report->report_type === 'members')
                    Member
                @endif
            </p>
        </div>
        @if ($report->report_type === 'loans')
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Buku</th>
                        <th>Peminjam</th>
                        <th>Status</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($details as $detail)
                        <tr>
                            <td>
                                <p>{{ $loop->iteration }}</p>
                            </td>
                            <td>
                                <p>{{ $detail->book->name }}</p>
                            </td>
                            <td>
                                <p>{{ $detail->member->user->username }}</p>
                            </td>
                            <td>
                                <p>
                                    @if ($detail->status === 'borrowed')
                                        Dipinjam
                                    @elseif ($detail->status === 'returned')
                                        Dikembalikan
                                    @elseif ($detail->status === 'late')
                                        Telat
                                    @elseif ($detail->status === 'fine')
                                        Denda
                                    @elseif ($detail->status === 'deadline')
                                        Deadline
                                    @endif
                                </p>
                            </td>
                            <td>
                                <p>{{ $detail->description ? $detail->description : '-' }}</p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif ($report->report_type === 'visits')
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama pengunjung</th>
                        <th>Tanggal kedatangan</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($details as $detail)
                        <tr>
                            <td>
                                <p>{{ $loop->iteration }}</p>
                            </td>
                            <td>
                                <p>{{ $detail->name }}</p>
                            </td>
                            <td>
                                <p>{{ $detail->date }}</p>
                            </td>
                            <td>
                                <p>{{ $detail->description ? $detail->description : '-' }}</p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif ($report->report_type === 'fines')
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Judul Buku</th>
                        <th>Status Buku</th>
                        <th>Status Denda</th>
                        <th>Tanggal</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($details as $detail)
                        <tr>
                            <td>
                                <p>{{ $loop->iteration }}</p>
                            </td>
                            <td>
                                <p>{{ $detail->loan->member->user->username }}</p>
                            </td>
                            <td>
                                <p>{{ $detail->loan->book->name }}</p>
                            </td>
                            <td>
                                <p>
                                    @if ($detail->status === 'pay_for_book')
                                        Membayar seharga buku
                                    @elseif ($detail->status === 'change_book')
                                        Mengganti buku
                                    @elseif ($detail->status === 'paying_fine')
                                        Membayar denda
                                    @endif
                                </p>
                            </td>
                            <td>
                                <p>{{ $detail->is_done === 1 ? 'Selesai' : 'Diproses' }}</p>
                            </td>
                            <td>
                                <p>{{ $detail->date }}</p>
                            </td>
                            <td>
                                <p>{{ $detail->description ? $detail->description : '-' }}</p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif ($report->report_type === 'members')
            Member
        @endif
    </main>


    <footer>
        <p>
            &copy; {{ now()->year }} Perpustakaan Lempuing. Semua hak cipta dilindungi.
        </p>
    </footer>

</body>

</html>
