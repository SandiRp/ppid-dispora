@extends('layouts.app')

@section('title', 'Maklumat Layanan - PPID Dispora Jatim')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8">

        <div class="text-center pb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Maklumat Pelayanan</h1>
            <p class="text-gray-500">Janji dan komitmen kami kepada masyarakat.</p>
        </div>

        <div class="relative bg-white rounded-3xl shadow-lg shadow-tosca-500/10 p-1 md:p-3 overflow-hidden">

            <div class="border-4 border-double border-tosca-200 rounded-2xl p-8 md:p-14 relative z-10 bg-white">

                <div class="absolute top-8 left-8 text-tosca-100">
                    <svg class="w-16 h-16 transform -scale-x-100" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                    </svg>
                </div>

                <div class="text-center relative z-20 mt-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a4/Logo_Provinsi_Jawa_Timur_%28East_Java_Province_Logo%29.svg/200px-Logo_Provinsi_Jawa_Timur_%28East_Java_Province_Logo%29.svg.png"
                        alt="Logo Jatim" class="w-20 mx-auto mb-8 opacity-90">

                    <h2
                        class="text-2xl font-black text-gray-800 uppercase tracking-widest mb-8 border-b-2 border-tosca-500 inline-block pb-2">
                        Maklumat Pelayanan
                    </h2>

                    <p class="text-xl md:text-2xl text-gray-700 leading-relaxed font-serif italic mb-12">
                        "Dengan Ini, Kami Pimpinan dan Seluruh Jajaran Dinas Kepemudaan dan Olahraga Provinsi Jawa Timur
                        Menyatakan Sanggup Menyelenggarakan Pelayanan Informasi Publik Sesuai Standar Pelayanan Yang Telah
                        Ditetapkan, Serta Siap Menerima Sanksi Sesuai Peraturan Perundang-Undangan Apabila Pelayanan Yang
                        Diberikan Tidak Sesuai Standar."
                    </p>

                    <div class="flex justify-end mt-12">
                        <div class="text-center">
                            <p class="text-gray-600 mb-24">Surabaya, <span class="font-medium">Jawa Timur</span></p>
                            <div class="border-b border-gray-400 w-48 mx-auto mb-2"></div>
                            <p class="font-bold text-gray-800">Kepala Dinas Kepemudaan dan Olahraga</p>
                            <p class="text-sm text-gray-500">Selaku Atasan PPID</p>
                        </div>
                    </div>
                </div>

                <div class="absolute bottom-8 right-8 text-tosca-100">
                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                    </svg>
                </div>
            </div>

            <div
                class="absolute top-0 right-0 w-64 h-64 bg-tosca-50 rounded-full mix-blend-multiply filter blur-3xl opacity-50 pointer-events-none">
            </div>
        </div>
    </div>
@endsection
