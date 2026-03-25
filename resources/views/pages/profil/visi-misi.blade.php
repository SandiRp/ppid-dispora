@extends('layouts.app')

@section('title', 'Visi & Misi PPID - Dispora Jatim')

@section('content')
    <div class="max-w-5xl mx-auto space-y-10">

        <div class="text-center pb-4">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Visi & Misi Pelayanan</h1>
            <p class="text-gray-500">Komitmen kami dalam memberikan layanan informasi publik yang prima.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">

            <div class="md:col-span-12">
                <div
                    class="bg-gradient-to-br from-tosca-500 to-tosca-700 rounded-3xl p-10 text-center shadow-lg shadow-tosca-500/30 relative overflow-hidden">
                    <svg class="absolute top-0 right-0 text-white/10 w-48 h-48 -mr-10 -mt-10 transform rotate-12"
                        fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 22h20L12 2zm0 3.8L18.2 19H5.8L12 5.8z" />
                    </svg>

                    <h2 class="text-2xl font-bold text-tosca-100 mb-4 tracking-wider uppercase">Visi</h2>
                    <p class="text-2xl md:text-3xl font-medium text-white leading-relaxed relative z-10 italic">
                        "Terwujudnya Pelayanan Informasi Publik yang Transparan, Akuntabel, dan Inovatif di Bidang
                        Kepemudaan dan Keolahragaan Jawa Timur."
                    </p>
                </div>
            </div>

            <div class="md:col-span-12">
                <div class="bg-white rounded-3xl p-8 md:p-10 shadow-sm border border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <span class="w-10 h-10 bg-tosca-100 text-tosca-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </span>
                        Misi
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex gap-4 p-4 rounded-2xl hover:bg-gray-50 transition-colors">
                            <div
                                class="flex-shrink-0 w-8 h-8 rounded-full bg-tosca-500 text-white flex items-center justify-center font-bold">
                                1</div>
                            <p class="text-gray-700">Meningkatkan kualitas tata kelola pelayanan informasi publik yang
                                cepat, mudah, dan terukur.</p>
                        </div>
                        <div class="flex gap-4 p-4 rounded-2xl hover:bg-gray-50 transition-colors">
                            <div
                                class="flex-shrink-0 w-8 h-8 rounded-full bg-tosca-500 text-white flex items-center justify-center font-bold">
                                2</div>
                            <p class="text-gray-700">Mengembangkan sistem informasi dan dokumentasi berbasis teknologi
                                digital yang inklusif.</p>
                        </div>
                        <div class="flex gap-4 p-4 rounded-2xl hover:bg-gray-50 transition-colors">
                            <div
                                class="flex-shrink-0 w-8 h-8 rounded-full bg-tosca-500 text-white flex items-center justify-center font-bold">
                                3</div>
                            <p class="text-gray-700">Meningkatkan kompetensi dan profesionalisme SDM pengelola layanan
                                informasi publik.</p>
                        </div>
                        <div class="flex gap-4 p-4 rounded-2xl hover:bg-gray-50 transition-colors">
                            <div
                                class="flex-shrink-0 w-8 h-8 rounded-full bg-tosca-500 text-white flex items-center justify-center font-bold">
                                4</div>
                            <p class="text-gray-700">Mendorong partisipasi aktif masyarakat melalui keterbukaan informasi
                                kepemudaan dan olahraga.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
