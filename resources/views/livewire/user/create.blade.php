{{-- User Modal --}}
<div wire:ignore.self class="modal fade" id="userModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="userModalLabel">
                    {{ $isView ? 'Lihat' : ($isEdit ? 'Edit' : 'Tambah') }} User</h5>
                <button type="button" wire:click="closeModal" class="close" data-dismiss="modal"
                    aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">

                {{-- Form starts --}}
                <form wire:submit.prevent="saveUser">

                    {{-- User Name --}}
                    <div class="form-group mb-3">
                        <label for="title">Nama <span class="text-danger">*</span></label>
                        <input type="text" {{ $isView ? 'disabled' : '' }} class="form-control" placeholder="Nama"
                            wire:model="name" />
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- User Divisi --}}
                    <div class="form-group mb-3">
                        <label for="title">Divisi <span class="text-danger">*</span></label>
                        <select class="form-control" {{ $isView ? 'disabled' : '' }} wire:model="id_divisi">
                            <option value="">-- Pilih Divisi --</option>
                            @foreach ($departments as $divisi)
                                <option value="{{ $divisi->id_divisi }}">{{ $divisi->nama }}</option>
                            @endforeach
                        </select>
                        @error('divisi')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- User Email --}}
                    <div class="form-group mb-3">
                        <label for="title">Email <span class="text-danger">*</span></label>
                        <input type="text" {{ $isView ? 'disabled' : '' }} class="form-control" placeholder="Email"
                            wire:model="email" />
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- User Password --}}
                    <div class="form-group mb-3">
                        <label for="title">Password <span class="text-danger">*</span></label>
                        <input type="password" {{ $isView ? 'disabled' : '' }} class="form-control"
                            placeholder="Password" wire:model="password" />
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- User Role --}}
                    <div class="form-group mb-3">
                        <label for="title">Role <span class="text-danger">*</span></label>
                        <select class="form-control" {{ $isView ? 'disabled' : '' }} wire:model="role">
                            <option value="">-- Pilih Role --</option>
                            <option value="1">Admin</option>
                            <option value="0">User</option>
                        </select>
                        @error('role')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- User No HP --}}
                    <div class="form-group mb-3">
                        <label for="title">Nomor Whatsapp<span class="text-danger">*</span></label>
                        <input type="text" {{ $isView ? 'disabled' : '' }} class="form-control" placeholder="No HP"
                            wire:model="no_hp" />
                        @error('no_hp')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>



                    <div class="text-end">
                        <button type="button" wire:click="closeModal" data-dismiss="modal"
                            class="btn btn-secondary">Tutup</button>

                        {{-- If not view then only show the submit button --}}
                        @if (!$isView)
                            <button type="submit" class="btn btn-success">Simpan</button>
                        @endif
                    </div>

                </form>
                {{-- Form ends --}}

            </div>
        </div>
    </div>
</div>
{{-- Modal ends --}}
