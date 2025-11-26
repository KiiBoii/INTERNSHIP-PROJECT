@if ($paginator->hasPages())
    <nav aria-label="Page navigation">
        <ul class="pagination d-flex justify-content-center align-items-center mb-0" style="gap: 0.5rem; list-style: none; padding: 0;">

            {{-- Tombol Previous (Panah Kiri) --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link border-0 bg-transparent" style="color: #ccc; cursor: default;">
                        {{-- Icon Panah Kiri SVG --}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link border-0 bg-transparent text-dark" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
                    </a>
                </li>
            @endif

            {{-- Element Halaman --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator (...) --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; font-weight: bold; color: #9ca3af;">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            {{-- STATUS AKTIF (Lingkaran Besar Biru) --}}
                            <li class="page-item active" aria-current="page">
                                <span class="d-flex align-items-center justify-content-center shadow-sm" 
                                      style="
                                        width: 45px; 
                                        height: 45px; 
                                        border-radius: 50%; 
                                        background-color: #a5b4fc; /* Warna Biru Soft sesuai gambar */
                                        color: white; 
                                        font-weight: bold; 
                                        font-size: 1.2rem;
                                        border: none;
                                        box-shadow: 0 4px 6px rgba(165, 180, 252, 0.4);
                                        transition: all 0.3s ease;
                                      ">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            {{-- STATUS TIDAK AKTIF (Lingkaran Kecil Abu) --}}
                            <li class="page-item">
                                <a href="{{ $url }}" class="d-flex align-items-center justify-content-center" 
                                   style="
                                    width: 35px; 
                                    height: 35px; 
                                    border-radius: 50%; 
                                    background-color: #f3f4f6; /* Abu-abu terang */
                                    color: #4b5563; /* Abu-abu gelap teks */
                                    font-weight: 600;
                                    text-decoration: none;
                                    font-size: 0.9rem;
                                    transition: background-color 0.2s;
                                   "
                                   onmouseover="this.style.backgroundColor='#e5e7eb'"
                                   onmouseout="this.style.backgroundColor='#f3f4f6'">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Tombol Next (Panah Kanan) --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link border-0 bg-transparent" href="{{ $paginator->nextPageUrl() }}" rel="next" style="color: #6366f1;"> {{-- Panah kanan warna biru saat aktif --}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link border-0 bg-transparent" style="color: #ccc; cursor: default;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif