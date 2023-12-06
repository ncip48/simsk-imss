<div class="content-wrapper">
    {{-- @include('livewire.aset.create')
    @include('livewire.aset.delete')
    @include('liveWire.aset.import') --}}
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Histori Penghapusan Aset</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">history</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            {{-- <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <button type="button" class="btn btn-primary mb-2" data-toggle="modal"
                                        data-target="#asetModal">
                                        Tambah Aset {{ $tipe }}
                                    </button>
                                    @foreach ($kode_asets as $kode)
                                        <button type="button" class="btn btn-success mb-2"
                                            wire:click="changeTipe({{ $kode }})">
                                            {{ $kode->nama }}
                                        </button>
                                    @endforeach
                                </div>
                                import export button with icon 
                                <div>
                                    <button data-toggle="modal" data-target="#asetImport" class="btn btn-warning mb-2">
                                        <i class="fas fa-file-import"></i>
                                        Import
                                    </button>
                                    <button wire:click="export" class="btn btn-success mb-2">
                                        <i class="fas fa-file-export"></i>
                                        Export
                                    </button>
                                </div>
                            </div> --}}

                            <h5>Silahkan pilih jenis aset dan tahun</h5>
                            <div class="row">
                                <div class="form-group col-12 d-flex flex-row align-items-end">
                                    <div class="col-lg-3 col-md-4">
                                        <label for="tipe">Jenis Aset</label>
                                        <select wire:model="tipe" class="form-control" name="tipe" id="tipe">
                                            <option value="">Pilih Jenis Aset</option>
                                            <option value="">Aset</option>
                                            <option value="">Inventaris</option>
                                            {{-- @foreach ($kode_asets as $kode)
                                                <option value="{{ $kode->id }}">{{ $kode->nama }}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        <label for="tahun">Tahun</label>
                                        <select wire:model="tahun" class="form-control" name="tahun" id="tahun">
                                            <option value="">Pilih Tahun</option>
                                            <option value="">Pilih 2020</option>
                                            <option value="">Pilih 2021</option>
                                            <option value="">Pilih 2022</option>
                                            <option value="">Pilih 2023</option>
                                            {{-- @foreach ($tahuns as $tahun)
                                                <option value="{{ $tahun->tahun }}">{{ $tahun->tahun }}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        <button wire:click="filter" class="btn btn-primary">Tampilkan</button>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            hhhh
                            {{-- <table id="" class="table table-bordered table-hover mb-2">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nomor Aset</th>
                                        <th>Jenis Aset</th>
                                        <th>Merek</th>
                                        <th>No Seri</th>
                                        <th>Kondisi</th>
                                        <th>Lokasi/Unit Kerja</th>
                                        <th>Pengguna</th>
                                        <th>Tanggal Perolehan</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse ($asets as $item)
                                        @php

                                            setLocale(LC_TIME, 'id');
                                            setlocale(LC_TIME, 'id_ID.utf8');
                                            \Carbon\Carbon::setLocale('id');

                                            $tanggal_perolehan = \Carbon\Carbon::parse($item->tanggal_perolehan)->isoFormat('D MMMM Y');

                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nomor_aset }}</td>
                                            <td>{{ $item->jenis_aset }}</td>
                                            <td>{{ $item->merek }}</td>
                                            <td>{{ $item->no_seri }}</td>
                                            <td>{{ $item->kondisi }}</td>
                                            <td>{{ $item->lokasi }}</td>
                                            <td>{{ $item->pengguna }}</td>
                                            <td>{{$tanggal_perolehan}}</td>
                                            <td>{{ $item->keterangan }}</td>
                                            <td>
                                                <button type="button" wire:click="editAset({{ $item->id }})"
                                                    class="btn btn-sm btn-warning mb-2" data-toggle="modal"
                                                    data-target="#asetModal">Edit</button>
                                                <button class="btn btn-sm btn-danger mb-2"
                                                    wire:click="deleteAset({{ $item->id }})" data-toggle="modal"
                                                    data-target="#deleteAsetModal">Hapus</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="text-center">Tidak Ada Data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $asets->links('vendor.pagination.bootstrap-4') }} --}}
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <script>
        window.addEventListener('close-modal', event => {
            $('#asetModal').modal('hide');
            $('#deleteAsetModal').modal('hide');
        });
    </script>
</div>
<!-- /.content-wrapper -->
