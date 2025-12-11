@extends('layout')

@section('title', 'Buat Undangan Baru')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-plus"></i> Buat Undangan Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('undangan.store') }}" method="POST">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nomor Undangan</label>
                            <input type="text" name="nomor_undangan" class="form-control @error('nomor_undangan') is-invalid @enderror" 
                                   value="{{ old('nomor_undangan') }}" placeholder="Contoh: 001/UN10.F09/TU/2024">
                            @error('nomor_undangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Yth. Kepada</label>
                            <input type="text" name="yth_kepada" class="form-control @error('yth_kepada') is-invalid @enderror" 
                                   value="{{ old('yth_kepada') }}" placeholder="Contoh: Bapak/Ibu Dosen">
                            @error('yth_kepada')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" 
                                   value="{{ old('tanggal') }}">
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Waktu</label>
                            <input type="time" name="waktu" class="form-control @error('waktu') is-invalid @enderror" 
                                   value="{{ old('waktu') }}">
                            @error('waktu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tempat</label>
                        <select name="tempat" id="tempat" class="form-select @error('tempat') is-invalid @enderror">
                            <option value="">Pilih Tempat</option>
                            <option value="Ruang Rapat Dosen" {{ old('tempat') == 'Ruang Rapat Dosen' ? 'selected' : '' }}>Ruang Rapat Dosen</option>
                            <option value="Zoom/Meet" {{ old('tempat') == 'Zoom/Meet' ? 'selected' : '' }}>Zoom/Meet</option>
                            <option value="Ruang Kaprodi" {{ old('tempat') == 'Ruang Kaprodi' ? 'selected' : '' }}>Ruang Kaprodi</option>
                            <option value="Ruang Kadep" {{ old('tempat') == 'Ruang Kadep' ? 'selected' : '' }}>Ruang Kadep</option>
                            <option value="Ruang Dekan" {{ old('tempat') == 'Ruang Dekan' ? 'selected' : '' }}>Ruang Dekan</option>
                            <option value="custom" {{ old('tempat') == 'custom' ? 'selected' : '' }}>Lainnya (isi sendiri)</option>
                        </select>
                        @error('tempat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3" id="tempat-custom" style="display: none;">
                        <label class="form-label">Tempat Lainnya</label>
                        <input type="text" name="tempat_custom" class="form-control" 
                               value="{{ old('tempat_custom') }}" placeholder="Masukkan tempat">
                    </div>

                    <div class="mb-3" id="link-container" style="display: none;">
                        <label class="form-label">Link (untuk online)</label>
                        <input type="url" name="link" class="form-control" 
                               value="{{ old('link') }}" placeholder="https://zoom.us/j/...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Agenda</label>
                        <textarea name="agenda" class="form-control @error('agenda') is-invalid @enderror" 
                                  rows="4" placeholder="Masukkan agenda rapat">{{ old('agenda') }}</textarea>
                        @error('agenda')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tertanda</label>
                        <input type="text" name="tertanda" class="form-control @error('tertanda') is-invalid @enderror" 
                               value="{{ old('tertanda') }}" placeholder="Contoh: Dekan Fakultas Ilmu Komputer">
                        @error('tertanda')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Daftar Undangan</label>
                        <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                            @foreach($dosens as $dosen)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="dosen_ids[]" 
                                       value="{{ $dosen->id }}" id="dosen{{ $dosen->id }}"
                                       {{ in_array($dosen->id, old('dosen_ids', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="dosen{{ $dosen->id }}">
                                    <strong>{{ $dosen->nama }}</strong><br>
                                    <small class="text-muted">{{ $dosen->departemen }} - {{ $dosen->program_studi }}</small>
                                </label>
                            </div>
                            <hr class="my-2">
                            @endforeach
                        </div>
                        @error('dosen_ids')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Undangan
                        </button>
                        <a href="{{ route('undangan.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('tempat').addEventListener('change', function() {
    const tempatCustom = document.getElementById('tempat-custom');
    const linkContainer = document.getElementById('link-container');
    
    if (this.value === 'custom') {
        tempatCustom.style.display = 'block';
    } else {
        tempatCustom.style.display = 'none';
    }
    
    if (this.value === 'Zoom/Meet') {
        linkContainer.style.display = 'block';
    } else {
        linkContainer.style.display = 'none';
    }
});

// Trigger on page load
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('tempat').dispatchEvent(new Event('change'));
});
</script>
@endsection