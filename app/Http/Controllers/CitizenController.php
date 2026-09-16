<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCitizenRequest;
use App\Http\Requests\UpdateCitizenRequest;
use App\Models\Citizen;
use Illuminate\Http\Response;

class CitizenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. Summary Cards Data
        $stats = [
            ['title' => 'Total Penduduk', 'value' => Citizen::count()],
            ['title' => 'Penduduk Menikah', 'value' => Citizen::where('marital_status', 'married')->count()],
            ['title' => 'Pendapatan 0–3 Juta', 'value' => Citizen::where('income_range', '0_3jt')->count()],
            ['title' => 'Rata-rata Anak', 'value' => round(Citizen::avg('children_count') ?? 0, 1)],
        ];

        $recentCitizens = Citizen::latest()->take(5)->get();

        $financeSummary = [
            ['category' => 'Rp0–3 juta', 'count' => Citizen::where('income_range', '0_3jt')->count()],
            ['category' => 'Rp4–8 juta', 'count' => Citizen::where('income_range', '4_8jt')->count()],
            ['category' => 'Rp9–15 juta', 'count' => Citizen::where('income_range', '9_15jt')->count()],
            ['category' => 'Di atas Rp15 juta', 'count' => Citizen::where('income_range', 'above_15jt')->count()],
        ];

        return view('home.index', compact('stats', 'recentCitizens', 'financeSummary'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create()
    {
        return view('citizen.create');
    }

    public function store(StoreCitizenRequest $request)
    {
        Citizen::create($this->prepareCitizenData($request->validated()));

        return redirect()->route('citizens.index')->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    public function edit(Citizen $citizen)
    {
        return view('citizen.edit', compact('citizen'));
    }

    public function update(UpdateCitizenRequest $request, Citizen $citizen)
    {
        $citizen->update($this->prepareCitizenData($request->validated()));

        return redirect()->route('citizens.index')->with('success', 'Data penduduk berhasil diperbarui.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Citizen $citizen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Citizen $citizen)
    {
        $citizen->delete();

        return redirect()->route('citizens.index')->with('success', 'Data penduduk berhasil dihapus.');
    }

    public function exportExcel(): Response
    {
        $citizens = Citizen::latest()->get();

        return response()->view('citizen.export-table', compact('citizens'))
            ->header('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="data-penduduk.xlsc"');
    }

    public function exportPdf(): Response
    {
        $citizens = Citizen::latest()->get();

        return response()->view('citizen.export-pdf', compact('citizens'))
            ->header('Content-Type', 'text/html; charset=UTF-8');
    }

    /**
     * Keep the legacy category column synchronized with the selected income range.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function prepareCitizenData(array $data): array
    {
        $data['financial_status'] = match ($data['income_range']) {
            '0_3jt' => 'low_income',
            '4_8jt', '9_15jt' => 'middle_income',
            'above_15jt' => 'high_income',
        };
        $data['monthly_income'] = 0;

        $data['house_status'] = match ($data['house_status']) {
            'owned' => 'owned',
            'rented' => 'rented',
            'other' => 'other',
        };

        return $data;
    }
}
