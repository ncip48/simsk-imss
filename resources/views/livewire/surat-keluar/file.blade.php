{{-- Surat Modal --}}
<div wire:ignore.self class="modal fade" id="fileModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="fileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="divisiModalLabel">
                    Lihat File
                </h5>
                <button type="button" wire:click="closeModal" class="close" data-dismiss="modal"
                    aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <iframe src="{{ $fileShow }}#toolbar=0" width="100%" height="600px"></iframe>

                <div class="text-end">
                    <button type="button" wire:click="closeModal" data-dismiss="modal"
                        class="btn btn-secondary">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Modal ends --}}
