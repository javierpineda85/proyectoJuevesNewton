<div class="mb-6">
    <a href="/proyectos/gestor-pro/public/proyectos" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1 mb-2">
        &larr; Cancelar y Volver
    </a>
    <h2 class="text-2xl font-bold text-gray-800">Editar Proyecto</h2>
    <p class="text-sm text-slate-500">Actualiza la información, el estado o el responsable del proyecto.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-4xl">
    
    <form action="/proyectos/gestor-pro/public/proyectos/editar?id=<?php echo $proyecto['id']; ?>" method="POST" enctype="multipart/form-data">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="space-y-6">
                <div>
                    <label for="titulo" class="block text-sm font-medium text-slate-700 mb-1">Título del Proyecto <span class="text-red-500">*</span></label>
                    <input type="text" id="titulo" name="titulo" required 
                           value="<?php echo htmlspecialchars($proyecto['titulo']); ?>"
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div>
                    <label for="descripcion" class="block text-sm font-medium text-slate-700 mb-1">Descripción</label>
                    <textarea id="descripcion" name="descripcion" rows="5" 
                              class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"><?php echo htmlspecialchars($proyecto['descripcion']); ?></textarea>
                </div>

                <div class="mt-4 border-t pt-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Archivos Adjuntos</label>
                    
                    <?php if(!empty($archivos)): ?>
                        <div class="space-y-2 mb-4">
                            <?php foreach($archivos as $archivo): ?>
                                <div class="flex items-center justify-between p-2 bg-slate-50 border rounded-lg text-sm">
                                    <span class="text-slate-600 truncate max-w-[200px]"><?php echo $archivo['nombre_original']; ?></span>
                                    <a href="/proyectos/gestor-pro/public/uploads/proyectos/<?php echo $archivo['ruta_archivo']; ?>" 
                                       target="_blank" class="text-blue-600 font-bold hover:underline">Descargar</a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                        <p class="text-xs text-blue-700 mb-2 font-semibold">Subir archivo nuevo:</p>
                        <input type="file" name="archivo" class="text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                    </div>
                </div>
            </div>

            <div class="space-y-6 md:border-l md:border-gray-100 md:pl-6">
                <div>
                    <label for="estado" class="block text-sm font-medium text-slate-700 mb-1">Estado del Proyecto</label>
                    <select id="estado" name="estado" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition bg-white">
                        <option value="pendiente" <?php echo ($proyecto['estado'] == 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                        <option value="en_progreso" <?php echo ($proyecto['estado'] == 'en_progreso') ? 'selected' : ''; ?>>En Progreso</option>
                        <option value="pausado" <?php echo ($proyecto['estado'] == 'pausado') ? 'selected' : ''; ?>>Pausado</option>
                        <option value="completado" <?php echo ($proyecto['estado'] == 'completado') ? 'selected' : ''; ?>>Completado</option>
                    </select>
                </div>

                <div>
                    <label for="fecha_limite" class="block text-sm font-medium text-slate-700 mb-1">Fecha Límite</label>
                    <input type="date" id="fecha_limite" name="fecha_limite" required 
                           value="<?php echo $proyecto['fecha_limite']; ?>"
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div>
                    <label for="asignado_a" class="block text-sm font-medium text-slate-700 mb-1">Asignado a Empleado</label>
                    <select id="asignado_a" name="asignado_a" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition bg-white">
                        <option value="">-- Dejar sin asignar --</option>
                        <?php foreach($usuarios as $user): ?>
                            <?php if($user['estado'] == 'activo'): ?>
                                <option value="<?php echo $user['id']; ?>" <?php echo ($proyecto['asignado_a'] == $user['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($user['nombre']); ?> (<?php echo htmlspecialchars($user['rol_nombre']); ?>)
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition shadow-sm">
                Guardar Cambios
            </button>
        </div>

    </form>
</div>