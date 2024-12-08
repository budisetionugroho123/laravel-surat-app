<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-800">
            {{ __('Tambah User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-5 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <form action="{{route('user.management.post')}}" method="POST">
                    @csrf
                    <div class="mb-3 row">
                        <label for="name" class="col-sm-2 col-form-label col-form-label-sm">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control form-control-sm" value="{{old('name')}}" name="name" id="name" placeholder="masukkan nama">
                            @error('name')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label col-form-label-sm">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control form-control-sm" value="{{old('email')}}" name="email" id="email" placeholder="masukkan email">
                            @error('email')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="password" class="col-sm-2 col-form-label col-form-label-sm">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control form-control-sm" value="{{old('password')}}" name="password" id="password" placeholder="masukkan password">
                            @error('password')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="password_confirmation" class="col-sm-2 col-form-label col-form-label-sm">Password Konfirmasi</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control form-control-sm" name="password_confirmation" id="password_confirmation" placeholder="masukkan password konfirmasi">
                            @error('password_confirmation')
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
