<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Report;
use App\Models\ReportDetail;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function showReportPage(Request $request)
    {
        $reportSearch = $request->input('report_search');
        $reportType = $request->input('report_type');

        $reports = Report::query()
            ->with(['reporter'])
            ->when($reportSearch, function ($query, $reportSearch) {
                return $query->where(function ($subQuery) use ($reportSearch) {
                    $subQuery->where('title', 'like', '%' . $reportSearch . '%');
                });
            })
            ->when($reportType, function ($query, $reportType) {
                return $query->where('report_type', $reportType);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('reports.index', compact(['reports', 'reportSearch', 'reportType']));
    }

    public function showDetailPage(Request $request, $id)
    {
        $report = Report::with(['details', 'reporter'])->findOrFail($id);

        $details = $report->details->map(function ($detail) {
            switch ($detail->data_type) {
                case 'visits':
                    return Visit::find($detail->data_id);
                case 'members':
                    return Member::find($detail->data_id);
                case 'loans':
                    return Loan::with(['member.user', 'book'])->find($detail->data_id);
                case 'fines':
                    return Fine::with(['loan'])->find($detail->data_id);
                default:
                    return null;
            }
        })->filter();

        return view('reports.detail', compact(['report', 'details']));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'report_type' =>  'required|string|in:visits,fines,loans,',
            'title' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $data = json_decode($request->input('data'), true);

        try {
            $report = new Report();
            $report->report_type = $request->report_type;
            $report->title = $request->title;
            $report->reporter_id = $user->id;
            $report->save();

            if (!isset($data['data']) || !is_array($data['data'])) {
                dd('Data is not properly structured', $data);
            }

            if (!$report->id || !$request->report_type) {
                dd('Invalid report data:', $report, $request);
            }

            foreach ($data['data'] as $item) {
                if (!isset($item['id'])) {
                    return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat laporan: Data terkait tidak ditemukan');
                }

                $reportDetail = new ReportDetail();
                $reportDetail->report_id = $report->id;
                $reportDetail->data_id = $item['id'];
                $reportDetail->data_type = $request->report_type;

                try {
                    $reportDetail->save();
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Error saving report detail', $e->getMessage());
                }
            }

            return redirect()->back()->with('success', 'Laporan berhasil dibuat.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat laporan: ' . $e->getMessage());
        }
    }

    public function generateReportPDF(Request $request, $id)
    {
        $report = Report::with(['details', 'reporter'])->findOrFail($id);

        $details = $report->details->map(function ($detail) {
            switch ($detail->data_type) {
                case 'visits':
                    return Visit::find($detail->data_id);
                case 'members':
                    return Member::find($detail->data_id);
                case 'loans':
                    return Loan::with(['member.user', 'book'])->find($detail->data_id);
                case 'fines':
                    return Fine::with(['loan'])->find($detail->data_id);
                default:
                    return null;
            }
        })->filter();

        $data = [
            'report' => $report,
            'details' => $details
        ];

        $pdf = Pdf::loadView('reportPDF', $data);

        return $pdf->download('laporan.pdf');
    }
}
