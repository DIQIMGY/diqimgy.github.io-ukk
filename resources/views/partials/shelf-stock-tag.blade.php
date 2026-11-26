@php $stokVal = (int) ($stok ?? 0); @endphp
<span class="shelf-stock-tag {{ $stokVal > 0 ? 'ok' : 'out' }}">{{ $stokVal > 0 ? $stokVal.' STOK' : 'HABIS' }}</span>
