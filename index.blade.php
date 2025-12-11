@extends('layout')

@section('title', 'Daftar Undangan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-list"></i> Daftar Undangan</h2>
    <a href="{{ route('undangan.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Buat Undangan Baru
    </a>
</div>

@if($undangans->count() > 0)
    <div class="row">
        @foreach($undangans as $undangan)
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <strong>{{ $undangan->nomor_undangan }}</strong>
                    <span class="badge bg-{{ $undangan->status == 'sent' ? 'success' : 'warning' }}">
                        {{ $undangan->status == 'sent' ? 'Terkirim' : 'Draft' }}
                    </span>
                </div>
                <div class="card-body">
                    <h6 class="card-title">{{ $undangan->yth_kepada }}</h6>
                    <p class="card-text">
                        <small class="text-muted">
                            <i class="fas fa-calendar"></i> {{ $undangan->tanggal_format }} {{ $undangan->waktu_format }}<br>
                            <i class="fas fa-map-marker-alt"></i> {{ $undangan->tempat_lengkap }}<br>
                            <i class="fas fa-users"></i> {{ $undangan->dosens->count() }} orang diundang
                        </small>
                    </p>
                    <a href="{{ route('undangan.show', $undangan) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="text-center py-5">
        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
        <h4 class="text-muted">Belum ada undangan</h4>
        <p class="text-muted">Mulai dengan membuat undangan pertama Anda</p>
        <a href="{{ route('undangan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Buat Undangan
        </a>
    </div>
@endif
@endsection