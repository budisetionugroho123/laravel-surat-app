<?php

namespace App\Http\Controllers;

use App\Models\Letters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SuratKeluarController extends Controller
{
    //
    public function index()
    {
        $title = 'hapus Data!';
        $text = "Kamu yakin untuk menghapus data ini?";
        confirmDelete($title, $text);
        $letters = Letters::where('type', 'surat_keluar')->get();
        return view('surat-keluar.index', compact('letters'));
    }
    public function add()
    {
        return view('surat-keluar.add');
    }
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'jenis_berkas' => 'required',
            'no_berkas' => 'required',
            'nama_unit' => 'required',
            'no_unit' => 'required',
            'tanggal_keluar' => 'required',
            'file'=> 'required|file|mimes:pdf|max:2048',
        ]);

        try {
            $validateData['type'] = 'surat_keluar';
            $checkData = Letters::where("no_unit", $request->no_unit)->where("nama_unit", $request->nama_unit)->where("type", "surat_keluar")->where("no_berkas", $request->no_berkas)->first();
            if ($checkData) {
                return redirect()->route('incoming.mail.list')->with('toast_error', "Dokumen dengan no unit/nama unit/no berkas yang sama udah di input");
            }
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $folder = "surat_keluar/{$request->nama_unit}";
                $file->storeAs("public/{$folder}", $filename);

                $validateData['file'] = "surat_keluar"."/".$request->nama_unit."/". "{$filename}";
            }
            Letters::create($validateData);
            return redirect()->route('incoming.outmail.list')->with('toast_success', "Berhasil menyimpan data");
        } catch (\Throwable $th) {
            return back()->with('toast_error', $th->getMessage());
        }
    }
    public function detail($id)
    {

        $letter = Letters::where('id', $id)->where('type', 'surat_keluar')->first();
        if (!$letter) {
            return abort(404);
        }
        return view('surat-keluar.detail', compact('letter'));
    }
    public function edit(Request $request)
    {
        $validateData = $request->validate([
            'jenis_berkas' => 'required',
            'no_berkas' => 'required',
            'nama_unit' => 'required',
            'no_unit' => 'required',
            'tanggal_keluar' => 'required',
            'file' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        try {
            $letter = Letters::findOrFail($request->id);
            $validateData['type'] = 'surat_keluar';
            $checkData = Letters::where("no_unit", $request->no_unit)->where("type", "surat_keluar")->where("nama_unit", $request->nama_unit)->where("no_berkas", $request->no_berkas)->where("id", "!=" , $request->id)->first();
            if ($checkData) {
                return back()->with('toast_error', "Dokumen dengan no unit/nama unit/no berkas yang sama udah di input");
            }
            // Jika ada file baru
            if ($request->hasFile('file')) {
                // Hapus file lama jika ada
                if ($letter->file && Storage::disk('public')->exists($letter->file)) {
                    Storage::disk('public')->delete($letter->file);
                }

                // Upload file baru
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $folder = "surat_keluar/{$request->nama_unit}";
                $file->storeAs("public/{$folder}", $filename);

                // Simpan path file baru
                $validateData['file'] = "{$folder}/{$filename}";
            }

            $letter->update($validateData);
            return redirect()->route('incoming.outmail.list')->with('toast_success', "Berhasil mengubah data");
        } catch (\Throwable $th) {
            return back()->with('toast_error', $th->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            Letters::find($id)->delete();
            return back()->with('toast_success', "Berhasil menghapus data");
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('toast_error', $th->getMessage());
        }
    }
    public function downloadCsvSample()
    {
        $data = [
            ['jenis_berkas' => 'Surat', 'no_berkas' => '001', 'nama_unit' => 'Unit A', 'no_unit' => 'U001', 'tanggal_keluar' => '2025-05-17'],
            ['jenis_berkas' => 'Dokumen', 'no_berkas' => '002', 'nama_unit' => 'Unit B', 'no_unit' => 'U002', 'tanggal_keluar' => '2025-05-16'],
            ['jenis_berkas' => 'Laporan', 'no_berkas' => '003', 'nama_unit' => 'Unit C', 'no_unit' => 'U003', 'tanggal_keluar' => '2025-05-15'],
        ];

        // Header CSV
        $csvHeader = ['jenis Berkas', 'No Berkas', 'Nama Unit', 'No Unit', 'Tanggal Keluar'];

        // Buat callback untuk stream output CSV
        $callback = function () use ($data, $csvHeader) {
            $file = fopen('php://output', 'w');
            // Tulis header kolom
            fputcsv($file, $csvHeader);

            // Tulis data baris demi baris
            foreach ($data as $row) {
                fputcsv($file, [
                    $row['jenis_berkas'],
                    $row['no_berkas'],
                    $row['nama_unit'],
                    $row['no_unit'],
                    $row['tanggal_keluar']
                ]);
            }
            fclose($file);
        };

        $fileName = 'sample_csv_dokumen_keluar_' . date('Ymd_His') . '.csv';

        // Response stream dengan header untuk download
        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ]);
    }
    public function uploadCsv(Request $request)
    {
        $request->validate([
            'file_surat_keluar' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file_surat_keluar');
        $handle = fopen($file->getRealPath(), 'r');

        $rows = [];
        $maxColumns = 0;
        $errors = [];
        $rowNumber = 1;

        while (($row = fgetcsv($handle)) !== false) {
            $maxColumns = max($maxColumns, count($row));
            $rows[] = $row;
        }
        fclose($handle);

        if (empty($rows)) {
            return back()->with('error', 'File CSV kosong.');
        }

        // Gunakan baris pertama sebagai header, lalu tambahkan kolom ekstra jika perlu
        $header = $rows[0];
        for ($i = count($header); $i < $maxColumns; $i++) {
            $header[] = "Column_$i"; // Beri nama default ke kolom tambahan
        }
        $dataOutMails = [];
        foreach ($rows as $index => $row) {
            if ($index == 0) continue; // Lewati header

            $rowNumber++;
            while (count($row) < count($header)) {
                $row[] = null;
            }

            $data = array_combine($header, $row);
            // Validasi
            $validator = Validator::make($data, [
                'No Berkas' => 'required|string',
                'Nama Unit' => 'required|string',
                'No Unit' => 'required|string',
                'Tanggal Keluar' => 'required|string',
                'Jenis Berkas' => 'required',
            ]);
            $arrayJenisBerkas = ["Surat Pesanan", "Perjanjian Jual Beli Bangunan", "Form Dan Data Pengalihan Hak", "Adendum", "Invoice"];
            $validator->after(function ($validator) use ($request, $data, $arrayJenisBerkas) {
                if (!in_array($data["Jenis Berkas"], $arrayJenisBerkas)) {
                    $validator->errors()->add('JenisBerkasError', 'Jenis berkas yang kamu masukkan salah, harap pilih salah satu dari berikut ini : Surat Pesanan,Perjanjian Jual Beli Bangunan,Form Dan Data Pengalihan hak,Adendum,Invoice');
                }
                if ($data["No Berkas"] == "") {
                    $validator->errors()->add('NoBerkasError', 'No Berkas kosong');
                }
                if ($data["Nama Unit"] == "") {
                    $validator->errors()->add('NamaUnitError', 'Nama Berkas kosong');
                }
                if ($data["No Unit"] == "") {
                    $validator->errors()->add('NoUnitError', 'No Unit Kosong');
                }
                $tanggal = $data["Tanggal Keluar"] ?? null;
                if (!$tanggal || !\DateTime::createFromFormat('Y-m-d', $tanggal)) {
                    $validator->errors()->add(
                        'TanggalKeluarError',
                        'Format tanggal tidak sesuai, gunakan format YYYY-MM-DD (contoh: 2024-03-05).'
                    );
                } else {
                    // Cek valid atau tidak (misal 2024-02-30 itu tidak valid meskipun string-nya cocok)
                    $d = \DateTime::createFromFormat('Y-m-d', $tanggal);
                    if ($d->format('Y-m-d') !== $tanggal) {
                        $validator->errors()->add(
                            'TanggalKeluarError',
                            'Tanggal yang dimasukkan tidak valid.'
                        );
                    }
                }
            });
            if ($validator->fails()) {
                $errors[] = array_merge($data, ['error' => implode(', ', $validator->errors()->all())]);
                continue;
            }
            $dataOutMails[] = [
                "jenis_berkas" => $data["Jenis Berkas"],
                "nama_unit" => $data["Nama Unit"],
                "no_unit" => $data["No Unit"],
                "no_berkas" => $data["No Berkas"],
                "tanggal_keluar" => $data["Tanggal Keluar"],
            ];
        }
        DB::beginTransaction();

        try {
            foreach ($dataOutMails as $item) {
                $existingLetter = Letters::where('type', 'surat_keluar')
                    ->where('no_unit', $item['no_unit'])
                    ->first();

                if ($existingLetter) {
                    // Jika ditemukan, update data
                    $existingLetter->update([
                        'jenis_berkas' => $item['jenis_berkas'],
                        'nama_unit' => $item['nama_unit'],
                        'no_berkas' => $item['no_berkas'],
                        'tanggal_keluar' => $item['tanggal_keluar'],
                    ]);
                } else {
                    // Jika belum ada, insert baru
                    Letters::create([
                        'type' => 'surat_keluar',
                        'jenis_berkas' => $item['jenis_berkas'],
                        'nama_unit' => $item['nama_unit'],
                        'no_unit' => $item['no_unit'],
                        'no_berkas' => $item['no_berkas'],
                        'tanggal_keluar' => $item['tanggal_keluar'],
                    ]);
                }
            }

            DB::commit();

            if (!empty($errors)) {
                $csvPath = $this->generateErrorCsv($errors);
                Session::flash('error_csv', [
                    'file_path' => asset('storage/' . basename($csvPath)),
                    'message' => 'Ada beberapa kesalahan terhadap filenya'
                ]);
                return back();
            }

            return back()->with('toast_success', "Success Upload Dokumen Keluar");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('toast_error', $th->getMessage());
        }
    }

    private function generateErrorCsv($errors)
    {
        $fileName = 'errors_' . time() . '.csv';
        $filePath = storage_path("app/public/{$fileName}");

        $handle = fopen($filePath, 'w');
        fputcsv($handle, array_keys($errors[0]));

        foreach ($errors as $error) {
            fputcsv($handle, $error);
        }

        fclose($handle);

        return asset("storage/{$fileName}");
    }
}
