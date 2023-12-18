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
                            <h5 class="col-12">Silahkan pilih jenis aset dan tahun</h5>
                            <div class="row">
                                <div class="form-group col-12 d-flex flex-row align-items-end">
                                    <div class="col-lg-3 col-md-4">
                                        <label for="tipe">Jenis</label>
                                        <select wire:model="tipe" class="form-control" name="tipe" id="tipe">
                                            <option value="">Pilih Jenis</option>
                                            @foreach ($tipeOptions as $tipeOption)
                                                <option value="{{ $tipeOption->id }}">{{ $tipeOption->nama }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        <label for="tahun">Tahun Penghapusan</label>
                                        <select wire:model="tahun" class="form-control" name="tahun" id="tahun">
                                            <option value="">Pilih Tahun</option>
                                            @foreach ($tahuns as $tahun)
                                                <option value="{{ $tahun }}">{{ $tahun }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        <button wire:click="filter" class="btn btn-primary">Tampilkan</button>
                                        <button wire:click="export" class="btn btn-success">
                                            <i class="fas fa-file-export"></i>
                                            Export
                                        </button>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            {{-- @if ($history->count() > 0) --}}
                            <div class="table-responsive col-12">
                            <table id="history" class="table table-bordered table-hover mb-2">
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
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($history as $item)
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
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                            {{ $history->links('pagination::bootstrap-4') }}
                            {{-- @else
                                <div class="text-center">
                                    <h3>Tidak ada data</h3>
                                </div>
                            @endif --}}
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
        Livewire.on('filterData', function () {
            console.log('Filter telah diterapkan!');
            //isi table #history sesuai dengan data yang telah difilter
            $('#history').DataTable().ajax.reload();
        });
    </script>
</div>
<!-- /.content-wrapper -->


