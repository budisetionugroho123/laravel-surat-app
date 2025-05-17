<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-800">
            {{ __('Dokumen Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-5 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <a href="{{route('add.mail.list')}}" class="text-white btn btn-sm bg-secondary"><i class="bi bi-plus"></i>Tambah Dokumen masuk</a>
                <a  data-bs-toggle="modal" data-bs-target="#uploadDocumentMasukModal" class="text-white btn btn-sm bg-success"><i class="bi bi-file-earmark-excel"></i>Upload Dokumen Masuk</a>

                <table id="tableIncomingMail" class="table w-100 table-secondary table-bordered " >
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Jenis Berkas</th>
                            <th class="text-center">No Berkas</th>
                            <th class="text-center">Nama Unit</th>
                            <th class="text-center">No Unit</th>
                            <th class="text-center">Tanggal Masuk</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count=1;
                        @endphp
                        @foreach ($letters as $letter)
                            <tr>
                                <td class="text-center">{{$count++}}</td>
                                <td class="text-center">{{$letter->jenis_berkas}}</td>
                                <td class="text-center">{{$letter->no_berkas}}</td>
                                <td class="text-center">{{$letter->nama_unit}}</td>
                                <td class="text-center">{{$letter->no_unit}}</td>
                                <td class="text-center">{{$letter->tanggal_masuk}}</td>
                                <td class="text-center">
                                    <a href="{{URL::signedRoute('detail.mail.list', $letter->id)}}" class="p-1 text-white rounded bi bi-eye bg-warning "></a>
                                    <a href="{{route('delete.mail.list', $letter->id)}}" data-confirm-delete="true" class="p-1 text-white rounded bi bi-trash bg-danger"></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="uploadDocumentMasukModal" tabindex="-1" aria-labelledby="uploadDocumentMasukModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{route("store.mail.upload")}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="uploadDocumentMasukModalLabel">Upload Dokumen Masuk</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <div class="col-sm-0">
                                <label for="file_surat_masuk">Dokumen Surat Masuk</label>
                                <input
                                type="file"
                                name="file_surat_masuk"
                                class="border rounded form-control form-control-sm border-primary focus-ring focus-ring-primary"
                                id="file_surat_masuk"
                                value="{{ old('file_surat_masuk') }}"
                                placeholder="masukkan tanggal keluar">
                                <small class="float-end"><a href="{{route("sample.csv.mail")}}" class="text-primary">Example file upload</a></small>
                                @error('file_surat_masuk')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        @if (session('error_csv'))
                            <div class="mt-2 alert alert-warning">
                                <p>{{ session('error_csv')['message'] }}</p>
                                <a href="{{ session('error_csv')['file_path'] }}" class="text-danger" target="_blank">
                                    Download file berisi kesalahan CSV
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-secondary white" data-bs-dismiss="modal">Tutup</a>
                        <button type="submit" class="btn btn-primary bg-primary">Upload</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
    @if ($errors->has('file_surat_masuk') || session('error_csv'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modal = new bootstrap.Modal(document.getElementById('uploadDocumentMasukModal'));
                modal.show();
            });
        </script>
    @endif

</x-app-layout>
