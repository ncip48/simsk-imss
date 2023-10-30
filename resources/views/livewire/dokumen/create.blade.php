{{-- Doc Modal --}}
<div wire:ignore.self class="modal fade" id="documentModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="documentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="documentModalLabel">
                    {{ $isView ? 'Lihat' : ($isEdit ? 'Edit' : 'Tambah') }} Dokumen</h5>
                <button type="button" wire:click="closeModal" class="close" data-dismiss="modal"
                    aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">

                {{-- Form starts --}}
                <form wire:submit.prevent="saveDocument">

                    {{-- Doc Name --}}
                    <div class="form-group mb-3">
                        <label for="title">Judul<span class="text-danger">*</span></label>
                        <input type="text" {{ $isView ? 'disabled' : '' }} class="form-control" placeholder="Judul"
                            wire:model="title" />
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <x-forms.filepond wire:model="file" allowFileTypeValidation allowFileSizeValidation
                        maxFileSize="4mb" labelIdle="Seret & lepas file disini atau <u><b>klik</b></u> untuk upload" />

                    {{-- Doc Sign --}}
                    <div class="form-group mb-3">
                        <label for="title">Signature <span class="text-danger">*</span></label>
                        <select class="form-control" {{ $isView ? 'disabled' : '' }} wire:model="signature_id">
                            <option value="">-- Pilih Tanda Tangan --</option>
                            @foreach ($signatures as $signature)
                                <option value="{{ $signature->id }}">{{ $signature->issuer }}</option>
                            @endforeach
                        </select>
                        @error('signature_id')
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
