<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-800 leading-tight">
            {{ __('Dokumen Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-5">
                <a href="{{route('add.mail.list')}}" class="text-white btn btn-sm bg-secondary"><i class="bi bi-plus"></i>Tambah Dokumen masuk</a>
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
                                    <a href="{{route('detail.mail.list', $letter->id)}}" class="bi bi-eye bg-warning rounded text-white p-1 "></a>
                                    <a href="{{route('delete.mail.list', $letter->id)}}" data-confirm-delete="true" class="bi bi-trash bg-danger rounded text-white p-1"></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</x-app-layout>
