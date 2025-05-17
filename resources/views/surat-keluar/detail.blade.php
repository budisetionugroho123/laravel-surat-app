<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-800">
            {{ __('Dokumen Keluar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-5 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <form action="{{route('edit.outmail.list')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{$letter->id}}">
                    <div class="mb-3 row">
                        <label for="jenis_berkas" class="col-sm-2 col-form-label col-form-label-sm">Jenis Berkas</label>
                        <div class="col-sm-10">
                            <select name="jenis_berkas" class="form-control" id="jenis_berkas">
                                <option value="">Pilih Jenis Berkas</option>
                                <option {{$letter->jenis_berkas == "Surat Pesanan"? "selected" : ""}} value="Surat Pesanan">Surat Pesanan</option>
                                <option {{$letter->jenis_berkas == "Perjanjian Jual Beli Bangunan"? "selected" : ""}} value="Perjanjian Jual Beli Bangunan">Perjanjian Jual Beli Bangunan</option>
                                <option {{$letter->jenis_berkas == "Form Dan Data Pengalihan Hak"? "selected" : ""}} value="Form Dan Data Pengalihan Hak">Form Dan Data Pengalihan Hak</option>
                                <option {{$letter->jenis_berkas == "Adendum"? "selected" : ""}} value="Adendum">Adendum</option>
                                <option {{$letter->jenis_berkas == "Invoice"? "selected" : ""}} value="Invoice">Invoice</option>
                            </select>
                            @error('jenis_berkas')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="no_berkas" class="col-sm-2 col-form-label col-form-label-sm">No Berkas</label>
                        <div class="col-sm-10">
                            <input type="text" class="rounded form-control form-control-sm" value="{{old('no_berkas', $letter->no_berkas)}}" name="no_berkas" id="no_berkas" placeholder="masukkan no berkas">
                            @error('no_berkas')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nama_unit" class="col-sm-2 col-form-label col-form-label-sm">Nama Unit</label>
                        <div class="col-sm-10">
                            <input type="text" name="nama_unit" class="rounded form-control form-control-sm" id="nama_unit" value="{{old('nama_unit', $letter->nama_unit)}}" placeholder="masukkan nama unit">
                            @error('nama_unit')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="no_unit" class="col-sm-2 col-form-label col-form-label-sm">No Unit</label>
                        <div class="col-sm-10">
                            <input type="text" name="no_unit" class="rounded form-control form-control-sm" id="no_unit" value="{{old('no_unit', $letter->no_unit)}}" placeholder="masukkan no unit">
                            @error('no_unit')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tanggal_keluar" class="col-sm-2 col-form-label col-form-label-sm">Tanggal Keluar</label>
                        <div class="col-sm-10">
                            <input type="date" name="tanggal_keluar" class="rounded form-control form-control-sm" id="tanggal_keluar" value="{{old('tanggal_keluar', $letter->tanggal_keluar)}}" placeholder="masukkan tanggal keluar">
                            @error('tanggal_keluar')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-3 mb-3 row justify-content-end">
                            <button type="submit" class="text-white btn bg-secondary col-sm-2">Simpan</button>
                    </div>

                </div>
            </form>
        </div>
    </div>


</x-app-layout>
