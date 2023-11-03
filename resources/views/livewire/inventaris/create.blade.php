{{-- Inventaris Modal --}}
<div wire:ignore.self class="modal fade" id="inventarisModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="inventarisModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="inventarisModalLabel">
                    {{ $isView ? 'Lihat' : ($isEdit ? 'Edit' : 'Tambah') }} Inventaris</h5>
                <button type="button" wire:click="closeModal" class="close" data-dismiss="modal"
                    aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">

                {{-- Form starts --}}
                <form wire:submit.prevent="saveAsset">

                    {{-- Aset Nama --}}
                    <div class="form-group mb-3">
                        <label for="title">Jenis Inventaris <span class="text-danger">*</span></label>
                        <input type="text" {{ $isView ? 'disabled' : '' }} class="form-control" placeholder="Nama"
                            wire:model="jenis_aset" />
                        @error('jenis_aset')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Aset tanggal tahun --}}
                    <div class="form-group mb-3">
                        <label for="title">Tanggal Perolehan <span class="text-danger">*</span></label>
                        <input type="date" {{ $isView ? 'disabled' : '' }} class="form-control" placeholder="Tanggal Perolehan"
                            wire:model="tanggal_perolehan" />
                        @error('tanggal_perolehan')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Aset Merek --}}
                    <div class="form-group mb-3">
                        <label for="title">Merek</label>
                        <input type="text" {{ $isView ? 'disabled' : '' }} class="form-control" placeholder="Merek"
                            wire:model="merek" />
                        @error('merek')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Aset No Seri --}}
                    <div class="form-group mb-3">
                        <label for="title">No Seri</label>
                        <input type="text" {{ $isView ? 'disabled' : '' }} class="form-control" placeholder="No Seri"
                            wire:model="no_seri" />
                        @error('no_seri')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Aset Kondisi --}}
                    <div class="form-group mb-3">
                        <label for="title">Kondisi <span class="text-danger">*</span></label>
                        <select {{ $isView ? 'disabled' : '' }} class="form-control" wire:model="kondisi">
                            <option value="">-- Pilih Kondisi --</option>
                            <option value="Baik" @if ($kondisi == 'Baik') selected @endif>Baik</option>
                            <option value="Rusak" @if ($kondisi == 'Rusak') selected @endif>Rusak</option>
                            <option value="Hilang" @if ($kondisi == 'Hilang') selected @endif>Hilang</option>
                        </select>
                        @error('kondisi')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Aset Lokasi --}}
                    <div class="form-group mb-3">
                        <label for="title">Lokasi/Unit Kerja <span class="text-danger">*</span></label>
                        <input type="text" {{ $isView ? 'disabled' : '' }} class="form-control" placeholder="Lokasi"
                            wire:model="lokasi" />
                        @error('lokasi')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Aset pengguna --}}
                    <div class="form-group mb-3">
                        <label for="title">Pengguna</label>
                        <input type="text" {{ $isView ? 'disabled' : '' }} class="form-control" placeholder="Pengguna"
                            wire:model="pengguna" />
                        @error('pengguna')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Aset Keterangan --}}
                    <div class="form-group mb-3">
                        <label for="title">Keterangan</label>
                        <textarea {{ $isView ? 'disabled' : '' }} class="form-control" wire:model="keterangan"
                            placeholder="Keterangan"></textarea>
                        @error('keterangan')
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
