{{-- Delete Divisi Modal --}}
<div wire:ignore.self class="modal fade" id="deleteAsetModal" tabindex="-1" aria-labelledby="deleteAsetModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="deleteAsetModalLabel">Hapus Aset</h5>
                <button type="button" wire:click="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            {{-- Form starts --}}
            <form wire:submit.prevent="destroyAset">
                <div class="modal-body py-4">
                    <h5 class="ps-3">Apakah Anda yakin ingin menghapus aset ini?</h5>
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