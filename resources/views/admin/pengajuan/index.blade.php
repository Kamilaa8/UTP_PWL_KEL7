@extends('layouts.app', ['title' => 'Daftar Pengajuan - PawPal'])

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Daftar Pengajuan Adopsi</h1>
        <p class="text-sm text-gray-500">Total: {{ $pengajuan->total() }} pengajuan</p>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">&larr; Dashboard</a>
</div>

{{-- Pencarian dan filter --}}
<form method="GET" action="{{ route('admin.pengajuan.index') }}" class="mb-6 bg-white border border-gray-200 rounded-xl p-4 flex flex-wrap gap-3">
    <input type="text" name="cari" value="{{ $cari }}" placeholder="Cari nama pemohon atau nama hewan..."
           class="flex-1 min-w-[220px] px-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
    <select name="status" class="px-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
        <option value="">Semua status</option>
        <option value="menunggu" @selected($status === 'menunggu')>Menunggu</option>
        <option value="disetujui" @selected($status === 'disetujui')>Disetujui</option>
        <option value="ditolak" @selected($status === 'ditolak')>Ditolak</option>
    </select>
    <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition">Cari</button>
    @if($status || $cari)
        <a href="{{ route('admin.pengajuan.index') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900">Reset</a>
    @endif
</form>

{{-- Tabel --}}
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr class="text-left text-gray-500">
                    <th class="py-3 px-4 font-medium">Pemohon</th>
                    <th class="py-3 px-4 font-medium">Hewan</th>
                    <th class="py-3 px-4 font-medium">Alasan</th>
                    <th class="py-3 px-4 font-medium">Tanggal</th>
                    <th class="py-3 px-4 font-medium">Status</th>
                    <th class="py-3 px-4 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengajuan as $p)
                    <tr class="border-t border-gray-100">
                        <td class="py-3 px-4">
                            <div class="font-medium text-gray-800">{{ $p->user->name }}</div>
                            <div class="text-xs text-gray-400">{{ $p->user->email }}</div>
                        </td>
                        <td class="py-3 px-4 text-gray-700">{{ $p->pet->name }}</td>
                        <td class="py-3 px-4 text-gray-500">{{ \Illuminate\Support\Str::limit($p->alasan_adopsi, 50) }}</td>
                        <td class="py-3 px-4 text-gray-500 whitespace-nowrap">{{ $p->created_at->format('d M Y') }}</td>
                        <td class="py-3 px-4">
                            @if($p->status === 'disetujui')
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700">Disetujui</span>
                            @elseif($p->status === 'ditolak')
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">Ditolak</span>
                            @else
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-700">Menunggu</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-right">
                            <a href="{{ url('/admin/pengajuan/' . $p->id) }}" class="px-3 py-1.5 text-xs font-medium text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-lg transition">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="py-10 text-center text-gray-400">Tidak ada pengajuan yang cocok.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $pengajuan->links() }}
</div>
@endsection