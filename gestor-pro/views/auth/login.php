<div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-md">
    
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold tracking-wider text-slate-800">GESTOR<span class="text-blue-600">PRO</span></h1>
        <p class="text-sm text-slate-500 mt-2">Ingresa tus credenciales para acceder</p>
    </div>

    <?php if(isset($error)): ?>
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md text-sm">
            <p class="font-medium">Error de acceso</p>
            <p><?php echo $error; ?></p>
        </div>
    <?php endif; ?>

    <form action="/proyectos/gestor-pro/public/login" method="POST" class="space-y-6">
        
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Correo Electrónico</label>
            <input type="email" id="email" name="email" required 
                   class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                   placeholder="admin@vexstudio.com">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Contraseña</label>
            <input type="password" id="password" name="password" required 
                   class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                   placeholder="••••••••">
        </div>

        <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
            Iniciar Sesión
        </button>

    </form>

    <div class="mt-6 text-center">
        <a href="#" class="text-sm text-blue-600 hover:underline">¿Olvidaste tu contraseña?</a>
    </div>

</div>