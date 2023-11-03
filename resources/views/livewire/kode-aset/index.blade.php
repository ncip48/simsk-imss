<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    @include('livewire.kode-aset.create')
    @include('livewire.kode-aset.delete')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kode Aset Inventaris</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">kode-aset</li>
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
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#kode-asetModal">
                                Tambah Kode Aset
                            </button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="" class="table table-bordered table-hover mb-2">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($kode_asets as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->kode }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>
                                                <button type="button" wire:click="editKodeAset({{ $item->id }})"
                                                    class="btn btn-sm btn-warning" data-toggle="modal"
                                                    data-target="#kode-asetModal">Edit</button>
                                                <button class="btn btn-sm btn-danger"
                                                    wire:click="deleteKodeAset({{ $item->id }})"
                                                    data-toggle="modal" data-target="#deleteKodeAsetModal">Hapus</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak Ada Data</td>
                                        </tr>
                                        
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $kode_asets->links('vendor.pagination.bootstrap-4') }}
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
            $('#kode-asetModal').modal('hide');
            $('#deleteKodeAsetModal').modal('hide');
        });
    </script>
</div>
<!-- /.content-wrapper -->
