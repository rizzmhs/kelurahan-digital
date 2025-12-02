<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use Illuminate\Http\Request;

class JenisSuratController extends Controller
{
    public function index()
    {
        $jenisSurat = JenisSurat::latest()->paginate(10);
        return view('admin.jenis-surat.index', compact('jenisSurat'));
    }

    public function create()
    {
        return view('admin.jenis-surat.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:10|unique:jenis_surat',
            'nama' => 'required|string|max:255|unique:jenis_surat',
            'deskripsi' => 'nullable|string|max:500',
            'estimasi_hari' => 'required|integer|min:1|max:30',
            'biaya' => 'required|integer|min:0',
            'persyaratan' => 'required|array|min:1',
            'persyaratan.*.field' => 'required|string',
            'persyaratan.*.label' => 'required|string',
            'persyaratan.*.type' => 'required|in:text,number,date,file',
            'persyaratan.*.required' => 'required|boolean',
        ]);

        $validated['template'] = 'default';
        $validated['persyaratan'] = json_encode($validated['persyaratan']);

        JenisSurat::create($validated);

        return redirect()->route('admin.jenis-surat.index')
            ->with('success', 'Jenis surat berhasil dibuat.');
    }

    public function show(JenisSurat $jenisSurat)
    {
        $jenisSurat->loadCount('surats');
        return view('admin.jenis-surat.show', compact('jenisSurat'));
    }

    public function edit(JenisSurat $jenisSurat)
    {
        return view('admin.jenis-surat.edit', compact('jenisSurat'));
    }

    public function update(Request $request, JenisSurat $jenisSurat)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:10|unique:jenis_surat,kode,' . $jenisSurat->id,
            'nama' => 'required|string|max:255|unique:jenis_surat,nama,' . $jenisSurat->id,
            'deskripsi' => 'nullable|string|max:500',
            'estimasi_hari' => 'required|integer|min:1|max:30',
            'biaya' => 'required|integer|min:0',
            'persyaratan' => 'required|array|min:1',
            'persyaratan.*.field' => 'required|string',
            'persyaratan.*.label' => 'required|string',
            'persyaratan.*.type' => 'required|in:text,number,date,file',
            'persyaratan.*.required' => 'required|boolean',
        ]);

        $validated['persyaratan'] = json_encode($validated['persyaratan']);

        $jenisSurat->update($validated);

        return redirect()->route('admin.jenis-surat.index')
            ->with('success', 'Jenis surat berhasil diperbarui.');
    }

    public function destroy(JenisSurat $jenisSurat)
    {
        // Check if jenis surat has surat
        if ($jenisSurat->surats()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus jenis surat yang memiliki data surat.');
        }

        $jenisSurat->delete();

        return redirect()->route('admin.jenis-surat.index')
            ->with('success', 'Jenis surat berhasil dihapus.');
    }

    public function updateStatus(Request $request, JenisSurat $jenisSurat)
    {
        $jenisSurat->update([
            'is_active' => !$jenisSurat->is_active
        ]);

        $status = $jenisSurat->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Jenis surat berhasil {$status}.");
    }

    public function editTemplate(JenisSurat $jenisSurat)
    {
        return view('admin.jenis-surat.edit-template', compact('jenisSurat'));
    }

    public function updateTemplate(Request $request, JenisSurat $jenisSurat)
    {
        $validated = $request->validate([
            'template' => 'required|string',
        ]);

        $jenisSurat->update(['template' => $validated['template']]);

        return back()->with('success', 'Template surat berhasil diperbarui.');
    }

    public function previewTemplate(JenisSurat $jenisSurat)
    {
        // Preview template dengan data dummy
        $dummyData = [
            'nama' => 'John Doe',
            'alamat' => 'Jl. Contoh No. 123',
            'tujuan' => 'Keperluan Administrasi',
        ];

        return view('surat.templates.' . $jenisSurat->template, [
            'surat' => (object) ['nomor_surat' => 'XXX/YYYY/ZZZZ'],
            'user' => (object) $dummyData,
            'jenisSurat' => $jenisSurat,
            'data' => $dummyData,
            'tanggal' => now()->format('d F Y'),
        ]);
    }
}