<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Panel de Proyectos</h2>
        <p class="text-sm text-slate-500 mt-1">Gestiona y asigna las tareas de tu equipo.</p>
    </div>
    <a href="/proyectos/gestor-pro/public/proyectos/crear" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition shadow-sm flex items-center gap-2">
        <span>+ Nuevo Proyecto</span>
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
    
    <?php foreach($proyectos as $p): ?>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col hover:shadow-md transition">
        
        <div class="flex justify-between items-start mb-4">
            <?php 
                // Colores dinámicos según el estado
                $estadoClass = 'bg-gray-100 text-gray-700';
                $estadoTexto = 'Pendiente';
                if($p['estado'] == 'en_progreso') { $estadoClass = 'bg-blue-100 text-blue-700'; $estadoTexto = 'En Progreso'; }
                if($p['estado'] == 'pausado') { $estadoClass = 'bg-orange-100 text-orange-700'; $estadoTexto = 'Pausado'; }
                if($p['estado'] == 'completado') { $estadoClass = 'bg-green-100 text-green-700'; $estadoTexto = 'Completado'; }
            ?>
            <span class="px-3 py-1 rounded-full text-xs font-semibold <?php echo $estadoClass; ?>">
                <?php echo $estadoTexto; ?>
            </span>
            <span class="text-xs text-slate-400 font-medium bg-slate-50 px-2 py-1 rounded">
                Vence: <?php echo date('d M, Y', strtotime($p['fecha_limite'])); ?>
            </span>
        </div>

        <h3 class="text-lg font-bold text-gray-800 mb-2 leading-tight">
            <?php echo htmlspecialchars($p['titulo']); ?>
        </h3>
        <p class="text-sm text-gray-500 mb-6 flex-1 line-clamp-3">
            <?php echo htmlspecialchars($p['descripcion']); ?>
        </p>

        <div class="pt-4 border-t border-gray-100 flex items-center justify-between mt-auto">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xs">
                    <?php echo substr($p['empleado_asignado'] ?? 'S', 0, 1); ?>
                </div>
                <div>
                    <p class="text-xs text-slate-400">Asignado a</p>
                    <p class="text-sm font-medium text-gray-800">
                        <?php echo $p['empleado_asignado'] ?? '<span class="text-red-500 italic">Sin asignar</span>'; ?>
                    </p>
                </div>
            </div>
            
           <a href="/proyectos/gestor-pro/public/proyectos/editar?id=<?php echo $p['id']; ?>" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Editar &rarr;</a>
        </div>
    </div>
    
    <?php endforeach; ?>

</div>

<?php if(empty($proyectos)): ?>
<div class="text-center py-16 bg-white rounded-xl border border-dashed border-gray-300">
    <p class="text-gray-500 mb-2">No hay proyectos activos en este momento.</p>
    <p class="text-sm text-gray-400">Crea uno nuevo para empezar a asignar tareas.</p>
</div>
<?php endif; ?>