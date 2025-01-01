<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peringatan Pengembalian Buku</title>
</head>

<body class="bg-gray-100 font-sans">
    <div class="max-w-xl mx-auto my-10 bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 text-white text-center py-4">
            <h1 class="text-2xl font-bold">Peringatan Pengembalian Buku</h1>
        </div>

        <!-- Content -->
        <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Halo, {{ $data['username'] }}</h2>
            <p class="text-gray-700 mb-4">
                Terima kasih telah meminjam buku di Perpustakaan Lempuing. Kami ingin mengingatkan Anda untuk
                segera mengembalikan buku yang Anda pinjam dalam <strong>2 hari ke depan.</strong>
            </p>
            <p class="text-gray-700 mb-4">
                Judul buku yang harus dikembalikan: <strong>{{ $data['book'] }}</strong>.
            </p>
            <p class="text-gray-700 mb-4">
                Jika Anda membutuhkan informasi lebih lanjut, silakan hubungi pihak perpustakaan kami.
            </p>
            <a href="http://127.0.0.1:8000/peminjaman"
                class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Lihat data peminjaman anda
            </a>
        </div>

        <!-- Footer -->
        <div class="bg-gray-100 text-center py-4">
            <p class="text-gray-500 text-sm">
                &copy; 2024 Perpustakaan Lempuing. Semua hak cipta dilindungi.
            </p>
        </div>
    </div>
</body>

</html>
