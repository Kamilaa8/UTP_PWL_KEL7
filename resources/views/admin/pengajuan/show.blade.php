@extends('layouts.app', ['title' => 'Detail Pengajuan - PawPal'])

@section('content')
<div class="mb-6 flex items-center justify-between gap-3">
    <h1 class="text-2xl font-bold text-gray-900">Detail Pengajuan</h1>
    <a href="{{ route('admin.pengajuan.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">&larr; Kembali</a>
</div>

@if(session('success'))
    <div class="mb-4 px-4 py-3 text-sm text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-lg">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white border border-gray-200 rounded-xl p-6 space-y-5">
    <div class="flex items-center justify-between">
        <span class="text-sm text-gray-500">Status</span>
        @if($pengajuan->status === 'disetujui')
            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700">Disetujui</span>
        @elseif($pengajuan->status === 'ditolak')
            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">Ditolak</span>
        @else
            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-700">Menunggu</span>
        @endif
    </div>

    <div class="grid sm:grid-cols-2 gap-5">
        <div>
            <div class="text-xs text-gray-400 mb-1">Pemohon</div>
            <div class="font-medium text-gray-800">{{ $pengajuan->user->name }}</div>
            <div class="text-sm text-gray-500">{{ $pengajuan->user->email }}</div>
        </div>
        <div>
            <div class="text-xs text-gray-400 mb-1">Hewan</div>
            <div class="font-medium text-gray-800">{{ $pengajuan->pet->name }}</div>
        </div>
        <div>
            <div class="text-xs text-gray-400 mb-1">Tanggal pengajuan</div>
            <div class="text-gray-700">{{ $pengajuan->created_at->format('d M Y, H:i') }}</div>
        </div>
    </div>

    <div>
        <div class="text-xs text-gray-400 mb-1">Alasan adopsi</div>
        <p class="text-gray-700 whitespace-pre-line">{{ $pengajuan->alasan_adopsi }}</p>
    </div>

    @if($pengajuan->status === 'menunggu')
        <div class="flex gap-3 pt-4 border-t border-gray-100">
            <form method="POST" action="{{ route('admin.pengajuan.setujui', $pengajuan) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition">Setujui</button>
            </form>
            <form method="POST" action="{{ route('admin.pengajuan.tolak', $pengajuan) }}" onsubmit="return confirm('Yakin menolak pengajuan ini?')">
                @csrf
                @method('PATCH')
                <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition">Tolak</button>
            </form>
        </div>
    @endif
</div>
@endsection