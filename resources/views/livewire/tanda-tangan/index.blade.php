<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    @include('livewire.tanda-tangan.create')
    @include('livewire.tanda-tangan.delete')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Tanda Tangan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Manage Tanda Tangan</li>
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
                                data-target="#signatureModal">
                                Tambah Tanda Tangan
                            </button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="" class="table table-bordered table-hover mb-2">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Issuer (Nama TTD)</th>
                                        <th>QR</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($signatures as $signature)
                                        <tr>
                                            <td style="vertical-align: middle">{{ $loop->iteration }}</td>
                                            <td style="vertical-align: middle">{{ $signature->issuer }}</td>
                                            <td><img src="{{ $signature->qr }}" alt="" width="50px"></td>
                                            <td style="vertical-align: middle">
                                                <button class="btn btn-sm btn-danger"
                                                    wire:click="deleteSignature({{ $signature->id }})"
                                                    data-toggle="modal"
                                                    data-target="#deleteSignatureModal">Hapus</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $signatures->links('vendor.pagination.bootstrap-4') }}
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
            $('#signatureModal').modal('hide');
            $('#deleteSignatureModal').modal('hide');
        });
    </script>
</div>
<!-- /.content-wrapper -->
