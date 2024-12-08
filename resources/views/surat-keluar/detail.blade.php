<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-800 leading-tight">
            {{ __('Dokumen Keluar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-5">
                <form action="{{route('edit.outmail.list')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{$letter->id}}">
                    <div class="row mb-3">
                        <label for="jenis_berkas" class="col-sm-2 col-form-label col-form-label-sm">Jenis Berkas</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control form-control-sm" value="{{old('jenis_berkas', $letter->jenis_berkas)}}" name="jenis_berkas" id="jenis_berkas" placeholder="masukkan jenis berkas">
                            @error('jenis_berkas')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="no_berkas" class="col-sm-2 col-form-label col-form-label-sm">No Berkas</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control form-control-sm" value="{{old('no_berkas', $letter->no_berkas)}}" name="no_berkas" id="no_berkas" placeholder="masukkan no berkas">
                            @error('no_berkas')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="nama_unit" class="col-sm-2 col-form-label col-form-label-sm">Nama Unit</label>
                        <div class="col-sm-10">
                            <input type="text" name="nama_unit" class="form-control form-control-sm" id="nama_unit" value="{{old('nama_unit', $letter->nama_unit)}}" placeholder="masukkan nama unit">
                            @error('nama_unit')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="no_unit" class="col-sm-2 col-form-label col-form-label-sm">No Unit</label>
                        <div class="col-sm-10">
                            <input type="text" name="no_unit" class="form-control form-control-sm" id="no_unit" value="{{old('no_unit', $letter->no_unit)}}" placeholder="masukkan no unit">
                            @error('no_unit')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="tanggal_keluar" class="col-sm-2 col-form-label col-form-label-sm">Tanggal Keluar</label>
                        <div class="col-sm-10">
                            <input type="date" name="tanggal_keluar" class="form-control form-control-sm" id="tanggal_keluar" value="{{old('tanggal_keluar', $letter->tanggal_keluar)}}" placeholder="masukkan tanggal keluar">
                            @error('tanggal_keluar')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3 mt-3 justify-content-end">
                            <button type="submit" class="btn bg-secondary text-white col-sm-2">Simpan</button>
                    </div>
                
                </div>
            </form>
        </div>
    </div>


</x-app-layout>
