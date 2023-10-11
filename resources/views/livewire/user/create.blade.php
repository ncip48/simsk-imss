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

                    {{-- User Email --}}
                    <div class="form-group mb-3">
                        <label for="title">Email <span class="text-danger">*</span></label>
                        <input type="text" {{ $isView ? 'disabled' : '' }} class="form-control" placeholder="Email"
                            wire:model="email" />
                        @error('email')
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
