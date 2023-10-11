<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    @include('livewire.divisi.create')
    @include('livewire.divisi.delete')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Divisi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Divisi</li>
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
                                data-target="#divisiModal">
                                Tambah Divisi
                            </button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="" class="table table-bordered table-hover mb-2">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($departments as $divisi)
                                        <tr>
                                            <td>{{ $divisi->kode }}</td>
                                            <td>{{ $divisi->nama }}</td>
                                            <td>
                                                <button type="button" wire:click="editDivisi({{ $divisi->id_divisi }})"
                                                    class="btn btn-sm btn-warning" data-toggle="modal"
                                                    data-target="#divisiModal">Edit</button>
                                                <button class="btn btn-sm btn-danger"
                                                    wire:click="deleteDivisi({{ $divisi->id_divisi }})"
                                                    data-toggle="modal" data-target="#deleteDivisiModal">Hapus</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $departments->links('vendor.pagination.bootstrap-4') }}
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
            $('#divisiModal').modal('hide');
            $('#deleteDivisiModal').modal('hide');
        });
    </script>
</div>
<!-- /.content-wrapper -->
