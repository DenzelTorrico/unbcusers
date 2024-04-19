<!-- resources/views/auth/login.blade.php -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @vite('resources/css/app.css')

</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="text-center">
                <!-- Logo -->
            </div>
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">

                <h2 class="mb-4 text-lg font-semibold text-gray-800">Iniciar sesión</h2>

                <!-- Formulario de inicio de sesión -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-600">Correo electrónico</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus class="w-full px-4 py-2 text-gray-700 bg-gray-200 rounded-lg focus:outline-none focus:bg-white">
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-600">Contraseña</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password" class="w-full px-4 py-2 text-gray-700 bg-gray-200 rounded-lg focus:outline-none focus:bg-white">
                    </div>

                    
                    <!-- Botón de inicio de sesión  -->
                    <div class="flex items-center justify-between">
                        <button type="submit" class="w-full py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:bg-indigo-700">
                            Iniciar sesión
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>