{{-- Delete User Modal --}}
<div wire:ignore.self class="modal fade" id="deleteSignatureModal" tabindex="-1"
    aria-labelledby="deleteSignatureModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="deleteSignatureModalLabel">Hapus Tanda Tangan</h5>
                <button type="button" wire:click="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            {{-- Form starts --}}
            <form wire:submit.prevent="destroySignature">
                <div class="modal-body py-4">
                    <h5 class="ps-3">Apakah Anda yakin ingin menghapus tanda tangan ini?</h5>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Ya! Hapus</button>
                    <button type="button" wire:click="closeModal" class="btn btn-secondary"
                        data-dismiss="modal">Batalkan</button>
                </div>
            </form>
            {{-- Form ends --}}

        </div>
    </div>
</div>
{{-- Delete Modal ends --}}
