<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Edit Profile</li>
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
                        <!-- /.card-header -->
                        <div class="card-body">
                            {{-- Form starts --}}
                            <form wire:submit.prevent="save">

                                {{-- User Name --}}
                                <div class="form-group mb-3">
                                    <label for="title">Nama <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Nama" wire:model="name" />
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- User Email --}}
                                <div class="form-group mb-3">
                                    <label for="title">Email <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Email" wire:model="email" />
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- User Password --}}
                                <div class="form-group mb-3">
                                    <label for="title">Password</label>
                                    <input type="password" class="form-control" placeholder="Password"
                                        wire:model="password" />
                                    <span class="text-info">Kosongkan jika tidak ingin mengubah password</span>
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- User No HP --}}
                                <div class="form-group mb-3">
                                    <label for="title">Nomor Whatsapp <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="No HP" wire:model="no_hp" />
                                    @error('no_hp')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                </div>
                            </form>
                            {{-- Form ends --}}
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
</div>
<!-- /.content-wrapper -->
