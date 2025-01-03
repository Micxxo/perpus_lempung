@extends('layout.dashboard')

@section('section')
    <div class="p-10 flex flex-col h-full">
        <div class="w-full flex items-center justify-between">
            <x-badge class="px-4 rounded-md">
                <p class="font-medium">Detail
                    @if ($report->report_type === 'loans')
                        Laporan Peminjaman
                    @elseif ($report->report_type === 'visits')
                        Laporan Kunjungan
                    @elseif ($report->report_type === 'fines')
                        Laporan Denda
                    @elseif ($report->report_type === 'members')
                        Laporan Member
                    @else
                        Laporan
                    @endif
                </p>
            </x-badge>

            <form action="{{ route('laporan.generate', $report->id) }}" method="GET">
                <button class="bg-accent px-3 py-1 rounded-md text-white">Cetak</button>
            </form>
        </div>

        <div class="flex-1 overflow-hidden">
            @if ($details->isEmpty())
                <div class="w-full h-full">
                    <x-book-error-state>
                        <div class="mt-4 md:mt-7">
                            <p class="font-semibold text-3xl md:text-4xl text-center md:text-left">Detail <br> tidak
                                ditemukan
                            </p>
                        </div>
                    </x-book-error-state>
                </div>
            @endif

            <div class="w-full mt-5 !h-full flex flex-col">
                <div class="mt-1 space-y-1">
                    <h1 class="font-semibold text-3xl">{{ $report->title }}</h1>
                    <p class="text-xs">Dilaporkan oleh: <span>{{ $report->reporter->username }}</span></p>
                    <p class="text-xs">Dilaporkan pada: <span>{{ $report->created_at }}</span></p>
                    <p class="text-xs">Deskripsi/catatan:
                        <span>{{ $report->description ? $report->description : '-' }}</span>
                    </p>
                </div>

                <div class="overflow-y-auto custom-scrollbar pr-2 flex-1 mt-5 mb-5">
                    {{-- Loan detail  --}}
                    @if ($report->report_type === 'loans')
                        <table class="w-full rounded-md flex-1 max-h-full">
                            <thead class="bg-gray-200 rounded-md w-full sticky top-0 z-10">
                                <th class="font-semibold border-r border-gray-300 text-left py-2 px-4 rounded-tl-md">No
                                </th>
                                <th class="font-semibold border-r border-gray-300 text-left py-2 px-4">Nama buku</th>
                                <th class="font-semibold border-r border-gray-300 text-left py-2 px-4 ">Peminjam
                                </th>
                                <th class="font-semibold border-r border-gray-300 text-left py-2 px-4 ">Status
                                </th>
                                <th class="font-semibold text-left py-2 px-4">Deskripsi</th>
                            </thead>
                            <tbody>
                                @foreach ($details as $detail)
                                    <tr class="border border-gray-100 even:bg-gray-50">
                                        <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                            <p>{{ $loop->iteration }}</p>
                                        </td>
                                        <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                            <p>{{ $detail->book->name }}</p>
                                        </td>
                                        <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                            <p>{{ $detail->member->user->username }}</p>
                                        </td>
                                        <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                            <x-loan-status variant="{{ $detail->status }}" />
                                        </td>
                                        <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                            <p>{{ $detail->description ? $detail->description : '-' }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @elseif ($report->report_type === 'visits')
                        <table class="w-full rounded-md flex-1 max-h-full">
                            <thead class="bg-gray-200 rounded-md w-full sticky top-0 z-10">
                                <th class="font-semibold border-r border-gray-300 text-left py-2 px-4 rounded-tl-md">No
                                </th>
                                <th class="font-semibold border-r border-gray-300 text-left py-2 px-4">Nama pengunjung</th>
                                <th class="font-semibold border-r border-gray-300 text-left py-2 px-4 ">Tanggal kedatangan
                                </th>
                                <th class="font-semibold text-left py-2 px-4">Deskripsi</th>
                            </thead>
                            <tbody>
                                @foreach ($details as $detail)
                                    <tr class="border border-gray-100 even:bg-gray-50">
                                        <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                            <p>{{ $loop->iteration }}</p>
                                        </td>
                                        <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                            <p>{{ $detail->name }}</p>
                                        </td>
                                        <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                            <p>{{ $detail->date }}</p>
                                        </td>
                                        <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                            <p>{{ $detail->description ? $detail->description : '-' }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @elseif ($report->report_type === 'fines')
                        <table class="w-full rounded-md flex-1 max-h-full">
                            <thead class="bg-gray-200 rounded-md w-full sticky top-0 z-10">
                                <th class="font-semibold border-r border-gray-300 text-left py-2 px-4 rounded-tl-md">No
                                </th>
                                <th class="font-semibold border-r border-gray-300 text-left py-2 px-4">Peminjam</th>
                                <th class="font-semibold border-r border-gray-300 text-left py-2 px-4 ">Judul buku
                                </th>
                                <th class="font-semibold border-r border-gray-300 text-left py-2 px-4 ">Status buku
                                </th>
                                <th class="font-semibold border-r border-gray-300 text-left py-2 px-4 ">Status denda
                                </th>
                                <th class="font-semibold text-left py-2 px-4">Tanggal</th>
                                <th class="font-semibold text-left py-2 px-4">Deskripsi</th>
                            </thead>
                            <tbody>
                                @foreach ($details as $detail)
                                    <tr class="border border-gray-100 even:bg-gray-50">
                                        <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                            <p>{{ $loop->iteration }}</p>
                                        </td>
                                        <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                            <p>{{ $detail->loan->member->user->username }}</p>
                                        </td>
                                        <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                            <p>{{ $detail->loan->book->name }}</p>
                                        </td>
                                        <td class="px-4 py-3 text-left border-r border-gray-200 ">
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
                                        <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                            <p>{{ $detail->is_done === 1 ? 'Selesai' : 'Diproses' }}</p>
                                        </td>
                                        <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                            <p>{{ $detail->date }}</p>
                                        </td>
                                        <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                            <p>{{ $detail->description ? $detail->description : '-' }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
