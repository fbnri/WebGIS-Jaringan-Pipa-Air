<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pipe;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PipeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $types = $request->type;
        $statuses = $request->status;

        $pipes = Pipe::query()

            // SEARCH NAMA
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })

            // FILTER JENIS
            ->when($types, function ($query) use ($types) {
                $query->whereIn('pipe_type', $types);
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        // LIST JENIS
        $pipeTypes = Pipe::select('pipe_type')
            ->distinct()
            ->orderBy('pipe_type')
            ->pluck('pipe_type');

        $minPlanned = Pipe::min(DB::raw('YEAR(planned_at)'));
        $minInstalled = Pipe::min(DB::raw('YEAR(installed_at)'));

        $maxPlanned = Pipe::max(DB::raw('YEAR(planned_at)'));
        $maxInstalled = Pipe::max(DB::raw('YEAR(installed_at)'));

        $yearsCollection = array_filter([
            $minPlanned,
            $minInstalled,
            $maxPlanned,
            $maxInstalled
        ]);

        $minYear = min($yearsCollection) ?? date('Y');
        $maxYear = max($yearsCollection) ?? date('Y');
        $years = range($minYear, $maxYear);

        return view('admin.pipes.index', compact(
            'pipes',
            'pipeTypes',
            'years',
            'minYear',
            'maxYear'
        ));
    }

    public function publicMap(Request $request)
    {
        $year = $request->year;
        $pipes = Pipe::when($year, function ($query) use ($year) {
            $query->whereYear('planned_at', '<=', $year);
        })->get();

        $customers = Customer::all();

        $minPlanned = Pipe::min(DB::raw('YEAR(planned_at)'));
        $minInstalled = Pipe::min(DB::raw('YEAR(installed_at)'));

        $maxPlanned = Pipe::max(DB::raw('YEAR(planned_at)'));
        $maxInstalled = Pipe::max(DB::raw('YEAR(installed_at)'));

        $years = array_filter([
            $minPlanned,
            $minInstalled,
            $maxPlanned,
            $maxInstalled
        ]);

        $minYear = min($years) ?? date('Y');

        $dataMaxYear = max($years) ?? date('Y');
        $currentYear = date('Y');

        $maxYear = max($dataMaxYear, $currentYear);

        $totalPipa = $pipes->count();
        $totalTerpasang = $pipes->whereNotNull('installed_at')->count();
        $totalRencana = $pipes->whereNull('installed_at')->count();
        $totalPanjang = $pipes->sum('length');

        return view('user.map', compact(
            'pipes',
            'customers',
            'year',
            'totalPipa',
            'totalTerpasang',
            'totalRencana',
            'totalPanjang',
            'minYear',
            'maxYear'
        ));
    }

    public function publicPipes(Request $request)
    {
        $search = $request->search;
        $types = $request->type;

        $pipes = Pipe::query()

            // SEARCH
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })

            // FILTER TYPE
            ->when($types, function ($query) use ($types) {
                $query->whereIn('pipe_type', $types);
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        // LIST JENIS
        $pipeTypes = Pipe::select('pipe_type')
            ->distinct()
            ->orderBy('pipe_type')
            ->pluck('pipe_type');

        // YEAR RANGE
        $minPlanned = Pipe::min(DB::raw('YEAR(planned_at)'));
        $minInstalled = Pipe::min(DB::raw('YEAR(installed_at)'));

        $maxPlanned = Pipe::max(DB::raw('YEAR(planned_at)'));
        $maxInstalled = Pipe::max(DB::raw('YEAR(installed_at)'));

        $yearsCollection = array_filter([
            $minPlanned,
            $minInstalled,
            $maxPlanned,
            $maxInstalled
        ]);

        $minYear = min($yearsCollection) ?? date('Y');
        $maxYear = max($yearsCollection) ?? date('Y');
        $years = range($minYear, $maxYear);

        return view('user.pipes', compact(
            'pipes',
            'pipeTypes',
            'years',
            'minYear',
            'maxYear'
        ));
    }

    public function create()
    {
        //
    }

    public function adminMap(Request $request)
    {
        $year = $request->year;
        $pipes = Pipe::when($year, function ($query) use ($year) {
            $query->whereYear('planned_at', '<=', $year);
        })->get();

        $customers = Customer::all();

        $minPlanned = Pipe::min(DB::raw('YEAR(planned_at)'));
        $minInstalled = Pipe::min(DB::raw('YEAR(installed_at)'));

        $maxPlanned = Pipe::max(DB::raw('YEAR(planned_at)'));
        $maxInstalled = Pipe::max(DB::raw('YEAR(installed_at)'));

        $years = array_filter([
            $minPlanned,
            $minInstalled,
            $maxPlanned,
            $maxInstalled
        ]);

        $minYear = min($years) ?? date('Y');

        $dataMaxYear = max($years) ?? date('Y');
        $currentYear = date('Y');

        $maxYear = max($dataMaxYear, $currentYear);

        $total = $pipes->count();
        $totalTerpasang = $pipes->whereNotNull('installed_at')->count();
        $totalRencana = $pipes->whereNull('installed_at')->count();
        $totalLength = $pipes->sum('length');

        return view('admin.dashboard', compact(
            'pipes',
            'customers',
            'total',
            'totalTerpasang',
            'totalRencana',
            'totalLength',
            'year',
            'minYear',
            'maxYear'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'pipe_type' => 'required|string',
            'planned_at' => 'required|date',
            'installed_at' => 'nullable|date|after_or_equal:planned_at',
            'length' => 'required|numeric|min:0',
            'geometry' => 'required'
        ],[
            'name.required' => 'Nama pipa wajib diisi',
            'pipe_type.required' => 'Jenis pipa wajib diisi',
            'planned_at.required' => 'Tanggal rencana wajib diisi',
            'installed_at.after_or_equal' => 'Tanggal terpasang tidak boleh sebelum tanggal rencana',
            'length.required' => 'Panjang pipa wajib diisi',
            'length.numeric' => 'Panjang pipa harus berupa angka',
            'length.min' => 'Panjang pipa tidak boleh kurang dari 0',
            'geometry.required' => 'Geometry pipa belum tersedia'
        ]);

        $pipe = Pipe::create([
            'name' => $validated['name'],
            'pipe_type' => $validated['pipe_type'],
            'planned_at' => $validated['planned_at'],
            'installed_at' => $validated['installed_at'] ?? null,
            'length' => $validated['length'],
            'geometry' => json_encode($validated['geometry'])
        ]);

        return response()->json($pipe);
    }

    public function show(Pipe $pipe)
    {
        //
    }

    public function edit(Pipe $pipe)
    {
        //
    }

    public function update(Request $request, Pipe $pipe)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'pipe_type' => 'required|string',
            'planned_at' => 'required|date',
            'installed_at' => 'nullable|date|after_or_equal:planned_at',
            'length' => 'required|numeric|min:0'
        ],[
            'name.required' => 'Nama pipa wajib diisi',
            'pipe_type.required' => 'Jenis pipa wajib diisi',
            'planned_at.required' => 'Tanggal rencana wajib diisi',
            'installed_at.after_or_equal' => 'Tanggal terpasang tidak boleh sebelum tanggal rencana',
            'length.required' => 'Panjang pipa wajib diisi',
            'length.numeric' => 'Panjang pipa harus berupa angka',
            'length.min' => 'Panjang pipa tidak boleh kurang dari 0'
        ]);

        $pipe->name = $validated['name'];
        $pipe->pipe_type = $validated['pipe_type'];
        $pipe->planned_at = $validated['planned_at'];
        $pipe->installed_at = $validated['installed_at'];
        $pipe->length = $validated['length'];

        if ($request->has('geometry')) {
            $pipe->geometry = json_encode($request->geometry);
        }

        $pipe->save();

        return response()->json([
            'success' => true
        ]);
    }

    public function destroy(Pipe $pipe)
    {
        $pipe->delete();
        return response()->json(['success' => true]);
    }
}
