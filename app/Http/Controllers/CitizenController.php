<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCitizenRequest;
use App\Http\Requests\UpdateCitizenRequest;
use App\Models\Citizen;
use Illuminate\Http\Response;

class CitizenController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $summary = Citizen::query()
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN marital_status = "married" THEN 1 ELSE 0 END) as married,
                SUM(CASE WHEN income_range = "0_3jt" THEN 1 ELSE 0 END) as low_income,
                ROUND(AVG(children_count), 1) as average_children
            ')
            ->first();

        $stats = [
            [
                'title' => 'Total Penduduk',
                'value' => $summary->total,
            ],
            [
                'title' => 'Penduduk Menikah',
                'value' => $summary->married,
            ],
            [
                'title' => 'Pendapatan 0–3 Juta',
                'value' => $summary->low_income,
            ],
            [
                'title' => 'Rata-rata Anak',
                'value' => $summary->average_children ?? 0,
            ],
        ];

        $recentCitizens = Citizen::query()
            ->latest()
            ->limit(5)
            ->get([
                'id',
                'nik',
                'name',
                'wife_name',
                'house_number',
                'marital_status',
                'children_count',
                'status',
                'income_range',
                'house_status',
                'created_at',
            ]);

        $financeCounts = Citizen::query()
            ->selectRaw('income_range, COUNT(*) as count')
            ->groupBy('income_range')
            ->pluck('count', 'income_range');

        $financeSummary = [
            [
                'category' => 'Rp0–3 juta',
                'count' => $financeCounts['0_3jt'] ?? 0,
            ],
            [
                'category' => 'Rp4–8 juta',
                'count' => $financeCounts['4_8jt'] ?? 0,
            ],
            [
                'category' => 'Rp9–15 juta',
                'count' => $financeCounts['9_15jt'] ?? 0,
            ],
            [
                'category' => 'Di atas Rp15 juta',
                'count' => $financeCounts['above_15jt'] ?? 0,
            ],
        ];

        return view('home.index', compact(
            'stats',
            'recentCitizens',
            'financeSummary'
        ));
    }

    /**
     * Show the form for creating a new citizen.
     */
    public function create()
    {
        return view('citizen.create');
    }

    /**
     * Store a newly created citizen.
     */
    public function store(StoreCitizenRequest $request)
    {
        Citizen::create(
            $this->prepareCitizenData($request->validated())
        );

        return redirect()
            ->route('citizens.index')
            ->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    /**
     * Show the form for editing a citizen.
     */
    public function edit(Citizen $citizen)
    {
        return view('citizen.edit', compact('citizen'));
    }

    /**
     * Update a citizen.
     */
    public function update(
        UpdateCitizenRequest $request,
        Citizen $citizen
    ) {
        $citizen->update(
            $this->prepareCitizenData($request->validated())
        );

        return redirect()
            ->route('citizens.index')
            ->with('success', 'Data penduduk berhasil diperbarui.');
    }

    /**
     * Display a specific citizen.
     */
    public function show(Citizen $citizen)
    {
        //
    }

    /**
     * Remove a citizen.
     */
    public function destroy(Citizen $citizen)
    {
        $citizen->delete();

        return redirect()
            ->route('citizens.index')
            ->with('success', 'Data penduduk berhasil dihapus.');
    }

    /**
     * Export citizens to Excel-compatible format.
     */
    public function exportExcel(): Response
    {
        $citizens = Citizen::query()
            ->latest()
            ->get();

        return response()
            ->view('citizen.export-table', compact('citizens'))
            ->header(
                'Content-Type',
                'application/vnd.ms-excel; charset=UTF-8'
            )
            ->header(
                'Content-Disposition',
                'attachment; filename="data-penduduk.xls"'
            );
    }

    /**
     * Export citizens to PDF-compatible HTML.
     */
    public function exportPdf(): Response
    {
        $citizens = Citizen::query()
            ->latest()
            ->get();

        return response()
            ->view('citizen.export-pdf', compact('citizens'))
            ->header(
                'Content-Type',
                'text/html; charset=UTF-8'
            );
    }

    /**
     * Prepare citizen data before storing or updating.
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