<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor Pro | Vex Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex h-screen font-sans">

    <aside class="w-64 bg-slate-900 text-white flex flex-col">
        <div class="p-6 border-b border-slate-700">
            <h1 class="text-2xl font-bold tracking-wider">GESTOR<span class="text-blue-500">PRO</span></h1>
            <p class="text-xs text-slate-400 mt-1">Panel Administrativo</p>
        </div>
        
        <nav class="flex-1 p-4 space-y-2">
            <a href="/gestor-pro/public/dashboard" class="block px-4 py-3 bg-blue-600 rounded-lg transition">
                📊 Dashboard
            </a>
            <a href="/proyectos/gestor-pro/public/usuarios" class="block px-4 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition">
                👥 Usuarios
            </a>
            <a href="#" class="block px-4 py-3 text-slate-300 hover:bg-slate-800 rounded-lg transition">
                🎫 Tickets
            </a>
            <a href="#" class="block px-4 py-3 text-slate-300 hover:bg-slate-800 rounded-lg transition">
                📁 Proyectos
            </a>
        </nav>
        
        <div class="p-4 border-t border-slate-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center font-bold">
                    NA
                </div>
                <div>
                    <p class="text-sm font-medium">Curso Programación</p>
                    <p class="text-xs text-slate-400">Super Admin</p>
                </div>
            </div>
        </div>
    </aside>

    <main class="flex-1 flex flex-col overflow-hidden">
        
        <header class="bg-white h-16 border-b flex items-center justify-between px-6 shadow-sm">
            <h2 class="text-xl font-semibold text-gray-800">Resumen del Sistema</h2>
            <button class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition">
                Cerrar Sesión
            </button>
        </header>

        <div class="flex-1 overflow-y-auto p-6">
            <?php echo $content; ?>
        </div>

    </main>

</body>
</html>