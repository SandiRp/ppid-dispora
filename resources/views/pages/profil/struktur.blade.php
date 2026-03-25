@extends('layouts.app')

@section('title', 'Struktur Organisasi - PPID Dispora Jatim')

@section('content')
    <div class="max-w-5xl mx-auto space-y-8">

        <div class="text-center pb-6 border-b border-gray-200">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Struktur Organisasi PPID</h1>
            <p class="text-gray-500">Bagan Susunan Keanggotaan Pejabat Pengelola Informasi dan Dokumentasi (PPID)</p>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-12">

            {{-- <div
                class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-2xl p-4 flex flex-col items-center justify-center min-h-[400px] relative overflow-hidden group"> --}}
            <img src="{{ asset('assets/images/soppid.jpeg') }}" alt="Bagan Struktur Organisasi PPID Dispora Jatim"
                class="max-w-full h-auto rounded-xl mx-auto shadow-md">


            {{-- </div> --}}

            <div class="mt-8 text-center max-w-3xl mx-auto">
                <p class="text-gray-600 leading-relaxed text-sm md:text-base">
                    Struktur organisasi PPID Dispora Jatim dibentuk untuk memastikan alur koordinasi, pelayanan, dan
                    pendokumentasian informasi publik berjalan secara terstruktur, efektif, dan efisien dari tingkat
                    pimpinan hingga ke petugas layanan informasi di garda terdepan.
                </p>
            </div>
        </div>
    </div>
@endsection
