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

        return redirect()->route('admin.jenis_surat.index')
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

        return redirect()->route('admin.jenis_surat.index')
            ->with('success', 'Jenis surat berhasil diperbarui.');
    }

    public function destroy(JenisSurat $jenisSurat)
    {
        // Check if jenis surat has surat
        if ($jenisSurat->surats()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus jenis surat yang memiliki data surat.');
        }

        $jenisSurat->delete();

        return redirect()->route('admin.jenis_surat.index')
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
        $availableTemplates = ['default', 'sktm', 'domisili', 'usaha'];
        return view('admin.jenis-surat.edit-template', compact('jenisSurat', 'availableTemplates'));
    }

    public function updateTemplate(Request $request, JenisSurat $jenisSurat)
    {
        $availableTemplates = ['default', 'sktm', 'domisili', 'usaha'];
        
        $validated = $request->validate([
            'template' => 'required|string|in:' . implode(',', $availableTemplates),
        ]);

        $jenisSurat->update(['template' => $validated['template']]);

        return back()->with('success', 'Template surat berhasil diperbarui.');
    }

    public function previewTemplate(JenisSurat $jenisSurat)
    {
        // Data dummy untuk preview
        $dummyData = $this->getDummyData($jenisSurat);

        // Cari template di beberapa lokasi yang mungkin
        $viewPaths = $this->getTemplateViewPaths($jenisSurat->template);
        
        foreach ($viewPaths as $viewPath) {
            if (view()->exists($viewPath)) {
                return view($viewPath, [
                    'surat' => (object) [
                        'nomor_surat' => 'XXX/YYYY/ZZZZ',
                        'tanggal_surat' => now()->format('d-m-Y'),
                        'perihal' => 'Surat ' . $jenisSurat->nama,
                        'kode_surat' => $jenisSurat->kode,
                    ],
                    'user' => (object) $dummyData,
                    'jenisSurat' => $jenisSurat,
                    'data' => $dummyData,
                    'tanggal' => now()->format('d F Y'),
                    'today' => now()->format('Y-m-d'),
                ]);
            }
        }

        // Jika template tidak ditemukan di mana pun, tampilkan fallback
        return $this->showTemplateFallback($jenisSurat);
    }

    /**
     * Get dummy data for template preview
     */
    private function getDummyData(JenisSurat $jenisSurat): array
    {
        $defaultData = [
            'nama' => 'John Doe',
            'alamat' => 'Jl. Contoh No. 123, Kelurahan Digital',
            'tujuan' => 'Keperluan Administrasi',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'agama' => 'Islam',
            'pekerjaan' => 'Karyawan Swasta',
            'nik' => '1234567890123456',
            'kk' => '9876543210987654',
            'no_telepon' => '081234567890',
            'nama_usaha' => 'Toko Sembako Jaya',
            'alamat_usaha' => 'Jl. Usaha No. 45',
            'jenis_usaha' => 'Perdagangan',
            'tahun_berdiri' => '2015',
        ];

        // Decode persyaratan untuk menambahkan data dummy yang sesuai
        $persyaratan = json_decode($jenisSurat->persyaratan, true) ?? [];
        foreach ($persyaratan as $item) {
            if (!isset($defaultData[$item['field']])) {
                // Generate dummy value based on field name
                $dummyValue = $this->generateDummyValue($item['field'], $item['label'], $item['type']);
                $defaultData[$item['field']] = $dummyValue;
            }
        }

        return $defaultData;
    }

    /**
     * Generate dummy value based on field information
     */
    private function generateDummyValue(string $field, string $label, string $type): string
    {
        switch ($type) {
            case 'number':
                return rand(1000, 9999);
            case 'date':
                return now()->subYears(rand(1, 30))->format('Y-m-d');
            case 'file':
                return 'dummy_file.pdf';
            default:
                // Coba tebak berdasarkan nama field atau label
                $lowerField = strtolower($field);
                $lowerLabel = strtolower($label);
                
                if (str_contains($lowerField, 'email') || str_contains($lowerLabel, 'email')) {
                    return 'contoh@email.com';
                } elseif (str_contains($lowerField, 'phone') || str_contains($lowerField, 'telp') || 
                         str_contains($lowerLabel, 'telepon')) {
                    return '0812' . rand(1000000, 9999999);
                } elseif (str_contains($lowerField, 'nama') || str_contains($lowerLabel, 'nama')) {
                    return 'Contoh ' . $label;
                } else {
                    return 'Data Contoh ' . $label;
                }
        }
    }

    /**
     * Get possible view paths for template
     */
    private function getTemplateViewPaths(string $templateName): array
    {
        // Periksa di lokasi surat.templates terlebih dahulu (tempat template baru saya buat)
        return [
            'surat.templates.' . $templateName,
            'admin.jenis-surat.templates.' . $templateName,
            'templates.' . $templateName,
            'admin.templates.' . $templateName,
        ];
    }

    /**
     * Show fallback page when template is not found
     */
    private function showTemplateFallback(JenisSurat $jenisSurat)
    {
        $dummyData = $this->getDummyData($jenisSurat);
        
        // Get all template files yang tersedia di resources/views/surat/templates/
        $templatePath = resource_path('views/surat/templates');
        $availableTemplates = [];
        if (is_dir($templatePath)) {
            $files = glob($templatePath . '/*.blade.php');
            $availableTemplates = array_map(function($file) {
                return basename($file, '.blade.php');
            }, $files);
        }
        
        // Try to render a generic preview dengan data dummy
        return view('admin.jenis-surat.template-preview', [
            'jenisSurat' => $jenisSurat,
            'dummyData' => $dummyData,
            'templateName' => $jenisSurat->template,
            'availableTemplates' => $availableTemplates ?: ['default', 'sktm', 'domisili', 'usaha'],
            'viewPaths' => $this->getTemplateViewPaths($jenisSurat->template),
            'surat' => (object) [
                'nomor_surat' => 'XXX/YYYY/ZZZZ',
                'tanggal_surat' => now()->format('d-m-Y'),
                'perihal' => 'Surat ' . $jenisSurat->nama,
                'kode_surat' => $jenisSurat->kode,
            ],
            'user' => (object) $dummyData,
            'data' => $dummyData,
            'tanggal' => now()->format('d F Y'),
        ]);
    }
}