@extends('layout')

@section('title', 'Detail Undangan')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="fas fa-envelope"></i> Preview Undangan</h5>
                <span class="badge bg-{{ $undangan->status == 'sent' ? 'success' : 'warning' }} fs-6">
                    {{ $undangan->status == 'sent' ? 'Terkirim' : 'Draft' }}
                </span>
            </div>
            <div class="card-body">
                <!-- Template Undangan -->
                <div class="border p-4 bg-light" style="font-family: 'Times New Roman', serif;">
                    <div class="text-center mb-4">
                        <h4 class="fw-bold">UNIVERSITAS BRAWIJAYA</h4>
                        <h5 class="fw-bold">FAKULTAS ILMU KOMPUTER</h5>
                        <hr class="border-dark" style="border-width: 2px;">
                    </div>

                    <div class="mb-3">
                        <table class="table table-borderless">
                            <tr>
                                <td width="120">Nomor</td>
                                <td width="10">:</td>
                                <td>{{ $undangan->nomor_undangan }}</td>
                            </tr>
                            <tr>
                                <td>Hal</td>
                                <td>:</td>
                                <td><strong>Undangan Rapat</strong></td>
                            </tr>
                        </table>
                    </div>

                    <div class="mb-3">
                        <p>{{ $undangan->yth_kepada }}</p>
                        <p>di Tempat</p>
                    </div>

                    <div class="mb-3">
                        <p>Dengan hormat,</p>
                        <p>Sehubungan dengan kegiatan yang akan dilaksanakan, dengan ini kami mengundang Bapak/Ibu untuk menghadiri:</p>
                    </div>

                    <div class="mb-3">
                        <table class="table table-borderless">
                            <tr>
                                <td width="120">Hari/Tanggal</td>
                                <td width="10">:</td>
                                <td>{{ $undangan->tanggal_format }}</td>
                            </tr>
                            <tr>
                                <td>Waktu</td>
                                <td>:</td>
                                <td>{{ $undangan->waktu_format }} WIB</td>
                            </tr>
                            <tr>
                                <td>Tempat</td>
                                <td>:</td>
                                <td>{{ $undangan->tempat_lengkap }}</td>
                            </tr>
                            @if($undangan->link)
                            <tr>
                                <td>Link</td>
                                <td>:</td>
                                <td><a href="{{ $undangan->link }}" target="_blank">{{ $undangan->link }}</a></td>
                            </tr>
                            @endif
                            <tr>
                                <td>Agenda</td>
                                <td>:</td>
                                <td>{{ $undangan->agenda }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="mb-4">
                        <p>Demikian undangan ini kami sampaikan. Atas perhatian dan kehadirannya, kami ucapkan terima kasih.</p>
                    </div>

                    <div class="text-end">
                        <p class="mb-1">Malang, {{ now()->format('d F Y') }}</p>
                        <p class="mb-5">{{ $undangan->tertanda }}</p>
                        <p class="fw-bold">_____________________</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-users"></i> Daftar Undangan ({{ $undangan->dosens->count() }} orang)</h6>
            </div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                @foreach($undangan->dosens as $dosen)
                <div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                    <div>
                        <strong class="d-block">{{ $dosen->nama }}</strong>
                        <small class="text-muted">{{ $dosen->email }}</small>
                    </div>
                    <div>
                        @if($dosen->pivot->whatsapp_sent)
                            <span class="badge bg-success">
                                <i class="fas fa-check"></i> Terkirim
                            </span>
                            <small class="d-block text-muted">{{ $dosen->pivot->sent_at->format('d/m H:i') }}</small>
                        @else
                            <span class="badge bg-secondary">
                                <i class="fas fa-clock"></i> Belum
                            </span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        @if($undangan->status == 'draft')
        <div class="card mt-3">
            <div class="card-body text-center">
                <h6 class="card-title">Kirim Undangan</h6>
                <p class="card-text">Undangan akan dikirim ke WhatsApp semua penerima</p>
                <form action="{{ route('undangan.kirim-whatsapp', $undangan) }}" method="POST" 
                      onsubmit="return confirm('Yakin ingin mengirim undangan ke {{ $undangan->dosens->count() }} orang?')">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fab fa-whatsapp"></i> Kirim ke WhatsApp
                    </button>
                </form>
            </div>
        </div>
        @endif

        <div class="card mt-3">
            <div class="card-body text-center">
                <a href="{{ route('undangan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection