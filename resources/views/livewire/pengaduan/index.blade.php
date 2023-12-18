<div class="content-wrapper">
    {{-- @include('livewire.pengaduan.create')
    @include('livewire.pengaduan.delete') --}}
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pengaduan Kerusakan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">pengaduan</li>
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
                        {{-- <div class="card-header">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#pengaduanModal">
                                Tambah pengaduan
                            </button>
                        </div> --}}
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="" class="table table-bordered table-hover mb-2">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Barang</th>
                                        <th>Kerusakan</th>
                                        <th>Lokasi</th>
                                        <th>Tanggal Pelaporan</th>
                                        <th>Nama Pelapor</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center" colspan="7"><h2>Fitur masih dalam pengembangan</h2></td>
                                    </tr>
                                    {{-- @forelse ($asets as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama_barang }}</td>
                                            <td>{{ $item->kerusakan }}</td>
                                            <td>{{ $item->lokasi }}</td>
                                            <td>{{ $item->tanggal_pelaporan }}</td>
                                            <td>{{ $item->nama_pelapor }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-success">Approved</button>
                                                <button class="btn btn-sm btn-danger">Reject</button>
                                            </td>
                                        </tr>
                                        
                                    @empty
                                        
                                    @endforelse --}}


                                   {{-- <tr>
                                        <td>1</td>
                                        <td>123</td>
                                        <td>123</td>
                                        <td>123</td>
                                        <td>123</td>
                                        <td>123</td>
                                        <td> --}}
                                            {{-- <button type="button" wire:click="editpengaduan({{ $pengaduan->id_pengaduan }})"
                                                class="btn btn-sm btn-warning" data-toggle="modal"
                                                data-target="#pengaduanModal">Edit</button>
                                            <button class="btn btn-sm btn-danger"
                                                wire:click="deletepengaduan({{ $pengaduan->id_pengaduan }})"
                                                data-toggle="modal" data-target="#deletepengaduanModal">Hapus</button> --}}
                                                {{-- <button class="btn btn-sm btn-success">Approved</button>
                                                <button class="btn btn-sm btn-danger">Reject</button>
                                        </td>
                                   </tr> --}}
                                </tbody>
                            </table>
                            {{-- {{ $pengaduans->links('vendor.pagination.bootstrap-4') }} --}}
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
            $('#pengaduanModal').modal('hide');
            $('#deletepengaduanModal').modal('hide');
        });
    </script>
</div>
<!-- /.content-wrapper -->


