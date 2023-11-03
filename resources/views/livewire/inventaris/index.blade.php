<div class="content-wrapper">
    @include('livewire.inventaris.create')
    @include('livewire.inventaris.delete')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Inventaris</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">inventaris</li>
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
                            {{-- <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#asetModal">
                                Tambah aset
                            </button> --}}
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#inventarisModal">
                                        Tambah Inventaris {{ $tipe }}
                                    </button>
                                    @foreach ($kode_asets as $kode)
                                        <button type="button" class="btn btn-success"
                                            wire:click="changeTipe({{ $kode }})">
                                            {{ $kode->nama }}
                                        </button>
                                    @endforeach
                                    
                                </div>
                                {{-- import button with icon  --}}
                                <div>
                                    <button data-toggle="modal" data-target="#inventarisImport" class="btn btn-warning">
                                        <i class="fas fa-file-import"></i>
                                        Import
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="" class="table table-bordered table-hover mb-2">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nomor Inventaris</th>
                                        <th>Jenis Inventaris</th>
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
                                            $tanggal_perolehan = strftime("%d %B %Y", strtotime($item->tanggal_perolehan));
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
                                            <td>{{ $tanggal_perolehan }}</td>
                                            <td>{{ $item->keterangan }}</td>
                                            <td>
                                                <button type="button" wire:click="editinventaris({{ $item->id }})"
                                                    class="btn btn-sm btn-warning" data-toggle="modal"
                                                    data-target="#inventarisModal">Edit</button>
                                                <button class="btn btn-sm btn-danger"
                                                    wire:click="deleteinventaris({{ $item->id }})"
                                                    data-toggle="modal" data-target="#deleteinventarisModal">Hapus</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="text-center">Data tidak ditemukan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $asets->links('vendor.pagination.bootstrap-4') }}
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
            $('#inventarisModal').modal('hide');
            $('#deleteinventarisModal').modal('hide');
        });
    </script>
</div>
<!-- /.content-wrapper -->


