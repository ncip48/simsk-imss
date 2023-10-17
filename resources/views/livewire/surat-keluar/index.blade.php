<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    @include('livewire.surat-keluar.create')
    @include('livewire.surat-keluar.delete')
    @include('livewire.surat-keluar.import')
    @include('livewire.surat-keluar.file')
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
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#suratModal">
                                        Tambah Surat Keluar {{ $tipe }}
                                    </button>
                                    <button type="button" class="btn btn-success" wire:click="changeTipe('d1')">
                                        D1
                                    </button>
                                    <button type="button" class="btn btn-success" wire:click="changeTipe('d2')">
                                        D2
                                    </button>
                                    <button type="button" class="btn btn-success" wire:click="changeTipe('d3')">
                                        D3
                                    </button>
                                </div>
                                {{-- import button with icon  --}}
                                <div>
                                    <button data-toggle="modal" data-target="#suratImport" class="btn btn-warning">
                                        <i class="fas fa-file-import"></i>
                                        Import
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="" class="table table-bordered table-hover mb-2">
                                <thead class="text-center">
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal Surat</th>
                                        <th>Nomor Surat</th>
                                        <th>Tujuan</th>
                                        <th>Uraian</th>
                                        <th>PIC</th>
                                        <th>Arsip Elektronik</th>
                                        @if (auth()->user()->role == 1)
                                            <th>File</th>
                                        @endif
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($letters as $surat)
                                        @php
                                            setlocale(LC_ALL, 'IND');
                                            //set locale for vps
                                            setlocale(LC_TIME, 'id_ID.utf8');
                                            \Carbon\Carbon::setLocale('id');

                                            $tanggal = \Carbon\Carbon::parse($surat->created_at)->isoFormat('D MMMM Y');
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $tanggal }}</td>
                                            <td class="text-center">{{ $surat->no_surat }}</td>
                                            <td>{{ $surat->tujuan }}</td>
                                            <td>{{ $surat->uraian }}</td>
                                            <td class="text-center">{{ $surat->kode_divisi }} -
                                                {{ $surat->nama_user }}
                                            </td>
                                            <td class="text-center">
                                                {{ $surat->status == 0 ? '' : ($surat->status == 1 ? 'Ada' : 'CANCEL') }}
                                            </td>
                                            @if (auth()->user()->role == 1)
                                                <td class="text-center">
                                                    @if ($surat->file)
                                                        <a href="#" data-toggle="modal" data-target="#fileModal"
                                                            wire:click="showFile({{ $surat }})">Lihat</a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            @endif
                                            <td class="text-center">
                                                @if (auth()->user()->id == $surat->id_user || auth()->user()->role == 1)
                                                    @if ($surat->status == 0)
                                                    @endif
                                                    <button type="button" wire:click="editSurat({{ $surat->id }})"
                                                        class="btn btn-sm btn-warning" data-toggle="modal"
                                                        data-target="#suratModal">Edit</button>
                                                    <button class="btn btn-sm btn-danger"
                                                        wire:click="deleteSurat({{ $surat->id }})"
                                                        data-toggle="modal"
                                                        data-target="#deleteSuratModal">Hapus</button>
                                                    @if ($surat->status == 0)
                                                        <button class="btn btn-sm btn-info"
                                                            wire:click="sendReminder({{ $surat->id }})">Reminder</button>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Tidak ada data</td>
                                        </tr>
                                    @endforelse
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
