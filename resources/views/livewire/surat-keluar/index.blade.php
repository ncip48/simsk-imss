<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    @include('livewire.surat-keluar.create')
    @include('livewire.surat-keluar.delete')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Surat Keluar {{ $tipe }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Surat Keluar {{ $tipe }}</li>
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
                                data-target="#suratModal">
                                Tambah Surat Keluar
                            </button>
                            <button type="button" class="btn btn-primary" wire:click="changeTipe('d1')">
                                D1
                            </button>
                            <button type="button" class="btn btn-primary" wire:click="changeTipe('d2')">
                                D2
                            </button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="" class="table table-bordered table-hover mb-2">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal Surat</th>
                                        <th>Nomor Surat</th>
                                        <th>Tujuan</th>
                                        <th>Uraian</th>
                                        <th>PIC</th>
                                        <th>Arsip Elektronik</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($letters as $surat)
                                        @php
                                            setlocale(LC_ALL, 'IND');
                                            //set locale for vps
                                            setlocale(LC_TIME, 'id_ID.utf8');
                                            \Carbon\Carbon::setLocale('id');

                                            $tanggal = \Carbon\Carbon::parse($surat->created_at)->isoFormat('D MMMM Y');
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $tanggal }}</td>
                                            <td>{{ $surat->no_surat }}</td>
                                            <td>{{ $surat->tujuan }}</td>
                                            <td>{{ $surat->uraian }}</td>
                                            <td>{{ $surat->kode_divisi }} - {{ $surat->nama_user }}</td>
                                            <td>{{ $surat->status == 0 ? '' : ($surat->status == 1 ? 'Ada' : 'CANCEL') }}
                                            </td>
                                            <td>
                                                <button type="button" wire:click="editSurat({{ $surat->id }})"
                                                    class="btn btn-sm btn-warning" data-toggle="modal"
                                                    data-target="#suratModal">Edit</button>
                                                <button class="btn btn-sm btn-danger"
                                                    wire:click="deleteSurat({{ $surat->id }})" data-toggle="modal"
                                                    data-target="#deleteSuratModal">Hapus</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $letters->links('vendor.pagination.bootstrap-4') }}
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
            console.log(event)
            $('#suratModal').modal('hide');
            $('#deleteSuratModal').modal('hide');
        });
    </script>
</div>
<!-- /.content-wrapper -->
