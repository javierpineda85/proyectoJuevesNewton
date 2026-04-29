<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Gestión de Usuarios</h2>
    <a href="/proyectos/gestor-pro/public/usuarios/crear" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
        + Nuevo Usuario
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-sm text-gray-500 uppercase tracking-wider">
                    <th class="p-4 font-medium">Nombre</th>
                    <th class="p-4 font-medium">Email</th>
                    <th class="p-4 font-medium">Rol</th>
                    <th class="p-4 font-medium text-center">Estado</th>
                    <th class="p-4 font-medium text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                
                <?php foreach($usuarios as $user): ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4 text-gray-800 font-medium">
                        <?php echo htmlspecialchars($user['nombre']); ?>
                    </td>
                    <td class="p-4 text-gray-600 text-sm">
                        <?php echo htmlspecialchars($user['email']); ?>
                    </td>
                    <td class="p-4">
                        <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-full text-xs font-semibold">
                            <?php echo htmlspecialchars($user['rol_nombre']); ?>
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <?php if($user['estado'] == 'activo'): ?>
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Activo</span>
                        <?php else: ?>
                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Inactivo</span>
                        <?php endif; ?>
                  </td>
                    <td class="p-4 text-right space-x-2">
                        <button class="text-blue-500 hover:text-blue-700 text-sm font-medium">Editar</button>
                    </td> 
                </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>