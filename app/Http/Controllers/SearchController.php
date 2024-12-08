<?php

namespace App\Http\Controllers;

use App\Models\Letters;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //
    public function index(Request $request) {
        $letters = [];

        if ($request->filled('search')) {
            $search = $request->search;

            $letters = Letters::where(function ($query) use ($search) {
                $query->where('no_unit', 'LIKE', "%{$search}%")
                      ->orWhere('jenis_berkas', 'LIKE', "%{$search}%") // Replace 'column1' with your actual column name
                      ->orWhere('no_berkas', 'LIKE', "%{$search}%") // Replace 'column2' with another column name
                      ->orWhere('nama_unit', 'LIKE', "%{$search}%"); // Add more conditions as needed
            })->get();
        }

        return view('search.index', compact('letters'));
    }
}
