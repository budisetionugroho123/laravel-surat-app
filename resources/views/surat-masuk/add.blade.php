<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-800">
            {{ __('Dokumen Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-5 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <form action="{{route('store.mail.list')}}" method="POST">
                    @csrf
                    <div class="mb-3 row">
                        <label for="jenis_berkas" class="col-sm-2 col-form-label col-form-label-sm">Jenis Berkas</label>
                        <div class="col-sm-10">
                            <select name="jenis_berkas" class="form-control" id="jenis_berkas">
                                <option value="">Pilih Jenis Berkas</option>
                                <option value="Surat Pesanan">Surat Pesanan</option>
                                <option value="Perjanjian Jual Beli Bangunan">Perjanjian Jual Beli Bangunan</option>
                                <option value="Form Dan Data Pengalihan Hak">Form Dan Data Pengalihan Hak</option>
                                <option value="Adendum">Adendum</option>
                                <option value="Invoice">Invoice</option>
                            </select>
                            {{-- <input type="text" class="form-control form-control-sm" value="{{old('jenis_berkas')}}" name="jenis_berkas" id="jenis_berkas" placeholder="masukkan jenis berkas"> --}}
                            @error('jenis_berkas')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="no_berkas" class="col-sm-2 col-form-label col-form-label-sm">No Berkas</label>
                        <div class="col-sm-10">
                            <input type="text" class="rounded form-control form-control-sm" value="{{old('no_berkas')}}" name="no_berkas" id="no_berkas" placeholder="masukkan no berkas">
                            @error('no_berkas')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nama_unit" class="col-sm-2 col-form-label col-form-label-sm">Nama Unit</label>
                        <div class="col-sm-10">
                            <input type="text" name="nama_unit" class="rounded form-control form-control-sm" id="nama_unit" value="{{old('nama_unit')}}" placeholder="masukkan nama unit">
                            @error('nama_unit')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="no_unit" class="col-sm-2 col-form-label col-form-label-sm">No Unit</label>
                        <div class="col-sm-10">
                            <input type="text" name="no_unit" class="rounded form-control form-control-sm" id="no_unit" value="{{old('no_unit')}}" placeholder="masukkan no unit">
                            @error('no_unit')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tanggal_masuk" class="col-sm-2 col-form-label col-form-label-sm">Tanggal Masuk</label>
                        <div class="col-sm-10">
                            <input type="date" name="tanggal_masuk" class="rounded form-control form-control-sm" id="tanggal_masuk" value="{{old('tanggal_masuk')}}" placeholder="masukkan tanggal keluar">
                            @error('tanggal_masuk')
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
