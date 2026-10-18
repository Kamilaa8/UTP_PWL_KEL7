@extends('layouts.app', ['title' => 'Dashboard Admin - PawPal'])

@section('content')
@php
    $maks = max(1, $perStatus['menunggu'], $perStatus['disetujui'], $perStatus['ditolak']);
    $grafik = [
        'menunggu' => ['label' => 'Menunggu', 'warna' => 'bg-amber-400'],
        'disetujui' => ['label' => 'Disetujui', 'warna' => 'bg-emerald-500'],
        'ditolak' => ['label' => 'Ditolak', 'warna' => 'bg-red-400'],
    ];
@endphp

<div class="mb-8 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Dashboard Admin</h1>
        <p class="text-sm text-gray-500">Ringkasan data hewan dan pengajuan adopsi.</p>
    </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.pets.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">Kelola Hewan</a>
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">Kelola Pengguna</a>
            <a href="{{ url('/admin/pengajuan') }}" class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition shadow-sm">Lihat Semua Pengajuan</a>
        </div>
</div>

{{-- Kartu ringkasan --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <p class="text-sm text-gray-500">Total Hewan</p>
        <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalHewan }}</p>
    </div>
    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <p class="text-sm text-gray-500">Hewan Tersedia</p>
        <p class="mt-2 text-3xl font-bold text-emerald-600">{{ $hewanTersedia }}</p>
    </div>
    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <p class="text-sm text-gray-500">Hewan Diadopsi</p>
        <p class="mt-2 text-3xl font-bold text-gray-700">{{ $hewanDiadopsi }}</p>
    </div>
    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <p class="text-sm text-gray-500">Total Pengajuan</p>
        <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalPengajuan }}</p>
        <p class="mt-1 text-xs text-amber-600 font-medium">{{ $perStatus['menunggu'] }} menunggu keputusan</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Grafik per status --}}
    <div class="bg-white border border-gray-200 rounded-xl p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Pengajuan per Status</h2>
        <div class="space-y-4">
            @foreach($grafik as $kunci => $info)
                @php $jumlah = $perStatus[$kunci]; @endphp
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">{{ $info['label'] }}</span>
                        <span class="font-semibold text-gray-900">{{ $jumlah }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-3">
                        <div class="{{ $info['warna'] }} h-3 rounded-full" style="width: {{ round($jumlah / $maks * 100) }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- 5 pengajuan terbaru --}}
    <div class="lg:col-span-2 bg-white border border-gray-200 rounded-xl p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">5 Pengajuan Terbaru</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b border-gray-100">
                        <th class="py-2 pr-4 font-medium">Pemohon</th>
                        <th class="py-2 pr-4 font-medium">Hewan</th>
                        <th class="py-2 pr-4 font-medium">Tanggal</th>
                        <th class="py-2 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuanTerbaru as $p)
                        <tr class="border-b border-gray-50">
                            <td class="py-3 pr-4 font-medium text-gray-800">{{ $p->user->name }}</td>
                            <td class="py-3 pr-4 text-gray-600">{{ $p->pet->name }}</td>
                            <td class="py-3 pr-4 text-gray-500">{{ $p->created_at->format('d M Y') }}</td>
                            <td class="py-3">
                                @if($p->status === 'disetujui')
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700">Disetujui</span>
                                @elseif($p->status === 'ditolak')
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">Ditolak</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-700">Menunggu</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="py-6 text-center text-gray-400">Belum ada pengajuan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection