<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    @include('livewire.user.create')
    @include('livewire.user.delete')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">User</li>
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
                            <div class="col-xl-6 col-md-6 col-6 text-end">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#userModal">
                                    Tambah User
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Divisi</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>NO HP</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->nama_divisi }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <span class="badge bg-{{ $user->role === 1 ? 'danger' : 'success' }}">
                                                    {{ $user->role === 1 ? 'Admin' : 'User' }}
                                                </span>
                                            </td>
                                            <td>{{ $user->no_hp }}</td>
                                            <td>
                                                <button type="button" wire:click="editUser({{ $user->id }})"
                                                    class="btn btn-sm btn-warning" data-toggle="modal"
                                                    data-target="#userModal">Edit</button>
                                                <button class="btn btn-sm btn-danger"
                                                    wire:click="deleteUser({{ $user->id }})" data-toggle="modal"
                                                    data-target="#deleteUserModal">Hapus</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
    <div class="modal fade" id="modal-defaults" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Default Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>One fine body…</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <script>
        window.addEventListener('close-modal', event => {
            $('#userModal').modal('hide');
            $('#deleteUserModal').modal('hide');
        });
    </script>
</div>
<!-- /.content-wrapper -->
