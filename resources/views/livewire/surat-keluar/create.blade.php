{{-- Surat Modal --}}
<div wire:ignore.self class="modal fade" id="suratModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="suratModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="divisiModalLabel">
                    {{ $isView ? 'Lihat' : ($isEdit ? 'Edit' : 'Tambah') }} Surat Keluar {{ $tipe }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">

                {{-- Form starts --}}
                <form wire:submit.prevent="saveSurat">

                    {{-- Surat Type --}}
                    <input type="hidden" {{ $isView ? 'disabled' : '' }} class="form-control" placeholder="Type"
                        wire:model="type" />

                    @if ($isEdit)
                        {{-- Surat No --}}
                        <div class="form-group mb-3">
                            <label for="title">No Surat <span class="text-danger">*</span></label>
                            <input type="text" {{ $isView ? 'disabled' : '' }} class="form-control"
                                placeholder="No Surat" wire:model="no_surat" readonly disabled />
                            @error('no_surat')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif

                    {{-- Surat Tujuan --}}
                    <div class="form-group mb-3">
                        <label for="title">Tujuan <span class="text-danger">*</span></label>
                        <input type="text" {{ $isView ? 'disabled' : '' }} class="form-control" placeholder="Tujuan"
                            wire:model="tujuan" />
                        @error('tujuan')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Surat Uraian --}}
                    <div class="form-group mb-3">
                        <label for="title">Uraian <span class="text-danger">*</span></label>
                        <input type="text" {{ $isView ? 'disabled' : '' }} class="form-control" placeholder="Uraian"
                            wire:model="uraian" />
                        @error('uraian')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    @if ($isEdit)
                        {{-- Surat File --}}
                        <div class="form-group mb-3">
                            <label for="title">File <span class="text-danger">*</span></label>
                            <input type="file" {{ $isView ? 'disabled' : '' }} class="form-control"
                                placeholder="File" wire:model="file" />
                            @error('file')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif

                    {{-- Surat PIC --}}


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
