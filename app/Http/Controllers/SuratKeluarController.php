<?php

namespace App\Http\Controllers;

use App\Models\Letters;
use Illuminate\Http\Request;

class SuratKeluarController extends Controller
{
    //
    public function index() {
        $title = 'hapus Data!';
        $text = "Kamu yakin untuk menghapus data ini?";
        confirmDelete($title, $text);
        $letters = Letters::where('type', 'surat_keluar')->get(); 
        return view('surat-keluar.index', compact('letters'));
    }
    public function add() {
        return view('surat-keluar.add');
    }
    public function store(Request $request) {
        $validateData = $request->validate([
            'jenis_berkas' => 'required',
            'no_berkas' => 'required',
            'nama_unit' => 'required',
            'no_unit' => 'required',
            'tanggal_keluar' => 'required',
        ]);
        
        try {
            $validateData['type'] ='surat_keluar';
            Letters::create($validateData);
            return redirect()->route('incoming.outmail.list')->with('toast_success', "Berhasil menyimpan data");
            
        } catch (\Throwable $th) {
            return back()->with('toast_error', $th->getMessage());
            
        }
    }
    public function detail($id) {

        $letter = Letters::where('id' , $id)->where('type', 'surat_keluar')->first(); 
        if(!$letter) {
            return back();
        }
        return view('surat-keluar.detail', compact('letter'));
    }
    public function edit(Request $request) {
        $validateData = $request->validate([
            'jenis_berkas' => 'required',
            'no_berkas' => 'required',
            'nama_unit' => 'required',
            'no_unit' => 'required',
            'tanggal_keluar' => 'required',
        ]);
        
        try {
            $validateData['type'] ='surat_keluar';
            $letter = Letters::find($request->id);
            $letter->update($validateData);
            return redirect()->route('incoming.outmail.list')->with('toast_success', "Berhasil mengubah data");
            
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('toast_error', $th->getMessage());
            
        }
    }
    public function delete($id){
        try {
            Letters::find($id)->delete();
            return back()->with('toast_success', "Berhasil menghapus data");
            
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('toast_error', $th->getMessage());
            
        }

    }
}
