<?php

// Solo super admin y administrativo pueden crear/eliminar usuarios
$can_control = in_array($_SESSION['role'] ?? '', ['super_admin', 'administrativo']);

// Etiquetas visuales para cada valor de la columna 'rol'
$roleLabels = [
    'super_admin' => 'Super Admin',
    'administrativo' => 'Administrativo',
    'profesional' => 'Profesional',
    'cliente' => 'Cliente',
    'prospecto' => 'Prospecto',
];

// Colores de badge por rol (de más oscuro/premium a más neutro)
$roleColors = [
    'super_admin' => 'bg-indigo-950 text-indigo-200',
    'administrativo' => 'bg-blue-100 text-blue-700',
    'profesional' => 'bg-green-100 text-green-700',
    'cliente' => 'bg-yellow-100 text-yellow-700',
    'prospecto' => 'bg-gray-100 text-gray-600',
];
?>

<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Gestión de Usuarios</h2>
        <p class="text-sm text-gray-400 mt-0.5">Equipo, clientes y prospectos del sistema.</p>
    </div>

    <?php if ($can_control): ?>
        <!-- Solo super_admin y administrativo pueden agregar usuarios -->
        <a href="/mvcusuarios/app/views/create.php"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
            + Nuevo Usuario
        </a>
    <?php endif; ?>
</div>

<!-- Filtros rápidos -->
<div class="flex gap-3 mb-4 flex-wrap">
    <input
        type="text"
        id="buscar"
        placeholder="Buscar por nombre, email o teléfono..."
        oninput="filtrar()"
        class="border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-300 min-w-[220px]"
    >
    <!-- Los valores del select coinciden exactamente con la columna `rol` de la DB -->
    <select id="filterRole" onchange="filtrar()"
            class="border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
        <option value="">Todos los roles</option>
        <option value="super_admin">Super Admin</option>
        <option value="administrativo">Administrativo</option>
        <option value="profesional">Profesional</option>
        <option value="cliente">Cliente</option>
        <option value="prospecto">Prospecto</option>
    </select>
    <select id="filterStatus" onchange="filtrar()"
            class="border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
        <option value="">Todos los estados</option>
        <option value="activo">Activo</option>
        <option value="inactivo">Inactivo</option>
    </select>
</div>

<!-- Contador de resultados -->
<p id="contador" class="text-xs text-gray-400 mb-3"></p>

<!-- Tabla principal -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs text-gray-500 uppercase tracking-wider">
                    <th class="p-4 font-medium">ID</th>
                    <th class="p-4 font-medium">Nombre</th>
                    <th class="p-4 font-medium">Email</th>
                    <th class="p-4 font-medium">Teléfono</th>
                    <th class="p-4 font-medium">Rol</th>
                    <th class="p-4 font-medium text-center">Estado</th>
                    <th class="p-4 font-medium text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100" id="cuerpo">

                <?php if (empty($usuarios)): ?>
                    <tr>
                        <td colspan="7" class="p-8 text-center text-gray-400 text-sm">
                            No hay usuarios registrados todavía.
                        </td>
                    </tr>

                <?php else: ?>
                    <?php foreach ($usuarios as $user):
                        $label_role = $tag_role[$user['rol']] ?? $user['rol'];
                        $color_role = $color_role[$user['rol']] ?? 'bg-slate-100 text-slate-600';
                        $telephone  = !empty($user['telefono']) ? htmlspecialchars($user['telefono']) : '—';
                    ?>
                    
                    <tr class="hover:bg-gray-50 transition"
                        data-nombre="<?= strtolower(htmlspecialchars($user['nombre'])) ?>"
                        data-email="<?= strtolower(htmlspecialchars($user['email'])) ?>"
                        data-telephone="<?= strtolower($telephone) ?>"
                        data-role="<?= htmlspecialchars($user['rol']) ?>"
                        data-status="<?= htmlspecialchars($user['estado']) ?>"
                    >
                        <!-- id de la DB: útil para referencia rápida -->
                        <td class="p-4 text-gray-400 text-xs font-semibold">ID<?= $user['id'] ?></td>

                        <td class="p-4 text-gray-800 font-medium">
                            <?= htmlspecialchars($user['nombre']) ?>
                        </td>

                        <td class="p-4 text-gray-500 text-sm">
                            <?= htmlspecialchars($user['email']) ?>
                        </td>

                        <!-- Teléfono: columna real de la tabla `usuarios` -->
                        <td class="p-4 text-gray-500 text-sm"><?= $telephone ?></td>

                        <!-- Rol -->
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $color_rol ?>">
                                <?= $label_role ?>
                            </span>
                        </td>

                        <!-- Estado -->
                        <td class="p-4 text-center">
                            <?php if ($user['estado'] === 'activo'): ?>
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Activo</span>
                            <?php else: ?>
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Inactivo</span>
                            <?php endif; ?>
                        </td>

                        <!-- Acciones -->
                        <td class="p-4 text-right space-x-2">
                            <!-- Editar: disponible para todos los roles con acceso -->
                            <a href="mvcusuarios/app/views/edit.php?id=<?= $user['id'] ?>"
                               class="text-blue-500 hover:text-blue-700 text-sm font-medium">
                                Editar
                            </a>

                            <?php if ($can_control): ?>
                                <!--
                                    La DB tiene ON DELETE CASCADE configurado:
                                    al borrar un usuario se eliminan automáticamente sus
                                    proyectos, tickets y mensajes relacionados.
                                -->
                                <form action="mvcusuarios/app/views/delete.php"
                                      method="POST"
                                      style="display:inline"
                                      onsubmit="return confirm('¿Desea eliminar a <?= htmlspecialchars($user['nombre']) ?>? Esta acción no se puede deshacer.')">
                                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                    <button type="submit"
                                            class="text-red-400 hover:text-red-600 text-sm font-medium bg-transparent border-none cursor-pointer p-0">
                                        Eliminar
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>

            </tbody>
        </table>
    </div>
</div>

<script>
    /* Funciones de filtrado por usuario */
    function filtrar() {
        const find = document.getElementById('find').value.toLowerCase().trim();
        const role    = document.getElementById('filterRole').value;
        const status = document.getElementById('filterStatus').value;

        const filas = document.querySelectorAll('#cuerpo tr[data-nombre]');
        let visibles = 0;

        filas.forEach(fila => {
            const coincideTexto  = fila.dataset.nombre.includes(find)
                                || fila.dataset.email.includes(find)
                                || fila.dataset.telephone.includes(find);
            const coincideRole    = !role    || fila.dataset.role    === role;
            const coincideStatus = !status || fila.dataset.status === status;

            const mostrar = coincideTexto && coincideRole && coincideStatus;
            fila.style.display = mostrar ? '' : 'none';
            if (mostrar) visibles++;
        });

        const total = filas.length;
        document.getElementById('contador').textContent = visibles === total
            ? `${total} usuario${total !== 1 ? 's' : ''}`
            : `Mostrando ${visibles} de ${total} usuario${total !== 1 ? 's' : ''}`;
    }

    document.addEventListener('DOMContentLoaded', filtrar);
</script>


