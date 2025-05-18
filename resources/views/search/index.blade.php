<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/2.0.1/css/dataTables.dataTables.min.css" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-100">
            {{-- @include('layouts.navigation') --}}
            @include('sweetalert::alert')

            <!-- Page Content -->
            <main>
                <div class="py-12">
                    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                        <div class="p-5 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                            <h1 class="mb-3 text-center fw-bold fs-3">Cari Berkas</h1>
                            <form action="" method="GET" class="">
                                <div class="mb-3 row justify-content-center">
                                    <div class="col-sm-3">
                                        <input type="text" name="search" class="rounded form-control form-control-sm" id="search" value="{{old('search', Request::get('search'))}}" placeholder="masukkan no unit">
                                        @error('search')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row justify-content-center">
                                    <div class="text-center col-sm-3">
                                        <button type="submit" class="text-white btn bg-secondary">Cari</button>
                                    </div>
                                </div>
                            </form>
                            @if (count($letters) > 0)
                                <div class="mt-5 row">
                                    <div class="col">
                                        <div class="table-responsive">

                                            <table class="table w-100 table-secondary table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Tipe Berkas</th>
                                                        <th>Jenis Berkas</th>
                                                        <th>No Berkas</th>
                                                        <th>Nama Unit</th>
                                                        <th>Bukti Berkas</th>
                                                        <th>Tanggal Masuk</th>
                                                        <th>Tanggal Keluar</th>
                                                    </tr>

                                                </thead>
                                                <tbody>
                                                    @foreach ($letters as $letter)
                                                    <tr>
                                                        @if ($letter->type == "surat_masuk")
                                                            <td>Berkas Masuk</td>
                                                        @else
                                                            <td>Berkas Keluar</td>
                                                        @endif
                                                        <td class="">{{$letter->jenis_berkas}}</td>
                                                        <td class="">{{$letter->no_berkas}}</td>
                                                        <td class="">{{$letter->nama_unit}}</td>
                                                        <td class="">
                                                            <button type="button" class="btn btn-sm btn-primary text-primary" data-bs-toggle="modal" data-bs-target="#previewModal{{$letter->id}}">
                                                                Preview
                                                            </button>
                                                        </td>
                                                        <td class="">{{empty($letter->tanggal_masuk) ? "-" : $letter->tanggal_masuk}}</td>
                                                        <td class="">{{empty($letter->tanggal_keluar) ? "-" : $letter->tanggal_keluar}}</td>
                                                    </tr>
                                                    <div class="modal fade" id="previewModal{{$letter->id}}" tabindex="-1" aria-labelledby="previewModalLabel{{$letter->id}}" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="previewModalLabel{{$letter->id}}">Preview PDF</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <iframe src="{{ asset('storage/' . $letter->file) }}" width="100%" height="600px"></iframe>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </main>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="//cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <script>
            new DataTable('#tableIncomingMail', {
                scrollX: true,
                lengthChange: false,
                columnDefs: [
                    { orderable: false, targets: 1 },
                    { orderable: false, targets: 2 },
                    { orderable: false, targets: 3 },
                    { orderable: false, targets: 6 },
                ],
                language: {
                    info: 'Halaman _PAGE_ dari _PAGES_',
                    infoEmpty: 'No records available',
                    infoFiltered: '(filtered from _MAX_ total records)',
                    lengthMenu: 'Display _MENU_ records per page',
                    zeroRecords: 'Nothing found - sorry'
                }
            });
        </script>

    </body>
</html>
