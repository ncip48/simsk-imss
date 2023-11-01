<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    @include('livewire.dokumen.create')
    @include('livewire.dokumen.delete')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dokumen</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Dokumen</li>
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
                                data-target="#documentModal">
                                Tambah Dokumen
                            </button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="" class="table table-bordered table-hover mb-2">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Judul</th>
                                        <th>File</th>
                                        <th>Signatured</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($documents as $document)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $document->title }}</td>
                                            <td>
                                                <a href="{{ asset('storage/signed/' . $document->file_signed) }}"
                                                    class="">Lihat</a>
                                            </td>
                                            <td>
                                                @if ($document->file_signed)
                                                    <i class="fas fa-check"></i>
                                                @else
                                                    <i class="fas fa-times"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-success"
                                                    wire:click="verifyDocument({{ $document->id }})">Verifikasi</button>
                                                <button class="btn btn-sm btn-success"
                                                    wire:click="signDocument({{ $document->id }})">Sign
                                                    Document</button>
                                                <button class="btn btn-sm btn-danger"
                                                    wire:click="deleteDocument({{ $document->id }})" data-toggle="modal"
                                                    data-target="#deleteDocumentModal">Hapus</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $documents->links('vendor.pagination.bootstrap-4') }}
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
            $('#documentModal').modal('hide');
            $('#deleteDocumentModal').modal('hide');
        });
    </script>
</div>
<!-- /.content-wrapper -->
