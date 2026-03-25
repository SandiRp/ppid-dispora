<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - PPID Dispora Jatim</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        tosca: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59'
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gradient-to-br from-tosca-50 to-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-tosca-600 p-8 text-center">
            <div
                class="w-16 h-16 bg-white rounded-2xl mx-auto flex items-center justify-center text-tosca-600 font-black text-2xl mb-4 shadow-lg">
                P
            </div>
            <h1 class="text-2xl font-bold text-white">Login Admin PPID</h1>
            <p class="text-tosca-100 text-sm mt-1">Dinas Kepemudaan dan Olahraga Prov. Jatim</p>
        </div>

        <div class="p-8">
            @if ($errors->any())
                <div
                    class="bg-red-50 text-red-600 p-4 rounded-xl text-sm mb-6 border border-red-200 text-center font-medium">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('authenticate') }}" method="POST" class="space-y-5">
                @csrf
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Email Address</label>
                    <input type="email" name="email" required value="{{ old('email') }}"
                        placeholder="admin@dispora.jatim.go.id"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Password</label>
                    <input type="password" name="password" required placeholder="••••••••"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all">
                </div>

                <button type="submit"
                    class="w-full py-3.5 bg-tosca-600 hover:bg-tosca-700 text-white font-bold rounded-xl shadow-lg shadow-tosca-500/30 transform hover:-translate-y-0.5 transition-all mt-4">
                    Masuk ke Dashboard
                </button>
            </form>

            <div class="mt-6 text-center text-sm text-gray-400">
                <a href="{{ route('dashboard') }}" class="hover:text-tosca-600 transition-colors">&larr; Kembali ke
                    Beranda Publik</a>
            </div>
        </div>
    </div>

</body>

</html>
