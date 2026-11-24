
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="PAUD Haqqul Yaqin - Pendidikan Anak Usia Dini dengan program Kelompok Bermain dan Taman Kanak-Kanak.">

    <title>@yield('title', 'PAUD Haqqul Yaqin')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-white font-sans text-slate-800 antialiased">

    @yield('content')

</body>

</html>
