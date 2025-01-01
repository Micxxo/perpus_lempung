<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function showVisitsPage(Request $request)
    {
        $visitSearch = $request->input('visit_search');
        $visitDate = $request->input('visit_date');

        $visits = Visit::query()
            ->when($visitSearch, function ($query) use ($visitSearch) {
                return $query->where('name', $visitSearch);
            })
            ->when($visitDate, function ($query) use ($visitDate) {
                return $query->whereDate('date', $visitDate);
            })
            ->paginate(15);

        return view('visits', compact('visitSearch', 'visitDate', 'visits'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'visiters_name' => 'required|string|max:255',
            'visit_date' => 'required|date',
        ]);

        try {
            $visit = new Visit();

            $visit->name = $request->visiters_name;
            $visit->date = $request->visit_date;
            $visit->description = $request->visit_desc;

            $visit->save();

            return redirect()->route('kunjungan')->with('success', 'Kunjungan berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('kunjungan')->with('error', 'Terjadi kesalahan saat memperbarui kunjungan: ' . $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        $visitId = $request->input('visit_id');

        $validatedData = $request->validate([
            'visiters_name' => 'required|string|max:255',
            'visit_date' => 'required|date',
        ]);

        try {
            $visit = Visit::findOrFail($visitId);
            $visit->name = $request->visiters_name;
            $visit->date = $request->visit_date;
            $visit->description = $request->visit_desc;

            $visit->save();


            return redirect()->route('kunjungan')->with('success', 'Kunjungan berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('kunjungan')->with('error', 'Terjadi kesalahan saat memperbarui kunjungan: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, $visitId)
    {
        try {
            $visit = Visit::findOrFail($visitId);
            $visit->delete();

            return redirect()->route('kunjungan')->with('success', 'Kunjungan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('kunjungan')->with('error', 'Terjadi kesalahan saat menghapus kunjungan: ' . $e->getMessage());
        }
    }
}
