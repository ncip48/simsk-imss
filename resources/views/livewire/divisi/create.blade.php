{{-- Divisi Modal --}}
<div wire:ignore.self class="modal fade" id="divisiModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="divisiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="divisiModalLabel">
                    {{ $isView ? 'Lihat' : ($isEdit ? 'Edit' : 'Tambah') }} Divisi</h5>
                <button type="button" wire:click="closeModal" class="close" data-dismiss="modal"
                    aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">

                {{-- Form starts --}}
                <form wire:submit.prevent="saveDivisi">

                    {{-- Divisi Kode --}}
                    <div class="form-group mb-3">
                        <label for="title">Kode <span class="text-danger">*</span></label>
                        <input type="text" {{ $isView ? 'disabled' : '' }} class="form-control" placeholder="Kode"
                            wire:model="kode" />
                        @error('kode')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Divisi Nama --}}
                    <div class="form-group mb-3">
                        <label for="title">Nama <span class="text-danger">*</span></label>
                        <input type="text" {{ $isView ? 'disabled' : '' }} class="form-control" placeholder="Nama"
                            wire:model="nama" />
                        @error('nama')
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
