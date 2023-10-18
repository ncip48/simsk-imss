{{-- Surat Modal --}}
<div wire:ignore.self class="modal fade" id="suratModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="suratModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="divisiModalLabel">
                    {{ $isView ? 'Lihat' : ($isEdit ? 'Edit' : 'Tambah') }} Surat Keluar {{ $tipe }}</h5>
                <button type="button" wire:click="closeModal" class="close" data-dismiss="modal"
                    aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">

                {{-- Form starts --}}
                <form wire:submit.prevent="saveSurat">

                    {{-- Surat Type --}}
                    <input type="hidden" {{ $isView ? 'disabled' : '' }} class="form-control" placeholder="Type"
                        wire:model="type" />

                    <div class="form-group mb-3">
                        <label for="title">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" {{ $isView ? 'disabled' : '' }} class="form-control"
                            placeholder="No Surat" wire:model="created_at" wire:change="changeNomorSurat" />
                        @error('created_at')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

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
                        <x-forms.filepond wire:model="file" allowFileTypeValidation allowFileSizeValidation
                            maxFileSize="4mb" labelIdle="Seret & lepas file disini atau <u><b>klik</b></u> untuk upload"
                            acceptedFileTypes="['application/pdf']" />
                    @endif
                    {{-- <x-forms.filepond wire:model="image" /> --}}


                    {{-- Surat PIC --}}


                    <div class="text-end">
                        <button type="button" wire:click="closeModal" data-dismiss="modal"
                            class="btn btn-secondary">Tutup</button>

                        {{-- If not view then only show the submit button --}}
                        @if (!$isView)
                            <button type="submit" class="btn btn-success" wire:loading.attr="disabled">Simpan</button>
                        @endif
                    </div>

                </form>
                {{-- Form ends --}}

            </div>
        </div>
    </div>
</div>
{{-- Modal ends --}}
