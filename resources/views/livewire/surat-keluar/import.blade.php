{{-- Surat Modal --}}
<div wire:ignore.self class="modal fade" id="suratImport" data-keyboard="false" tabindex="-1"
    aria-labelledby="suratImportLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="divisiModalLabel">
                    Import Surat Keluar
                </h5>
                <button type="button" wire:click="closeModal" class="close" data-dismiss="modal"
                    aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">

                {{-- Form starts --}}
                <form wire:submit.prevent="importSurat">



                    <x-forms.filepond wire:model="fileUpload" allowFileTypeValidation allowFileSizeValidation
                        maxFileSize="4mb" labelIdle="Seret & lepas file disini atau <u><b>klik</b></u> untuk upload"
                        acceptedFileTypes="['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel']" />

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
