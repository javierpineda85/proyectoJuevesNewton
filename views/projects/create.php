<div class="mb-6">
    <a href="/proyectos/gestor-pro/public/proyectos" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1 mb-2">
        &larr; Volver a Proyectos
    </a>
    <h2 class="text-2xl font-bold text-gray-800">Crear Nuevo Proyecto</h2>
    <p class="text-sm text-slate-500">Completa los datos para inicializar el proyecto y asignar al responsable.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-4xl">
    
    <form action="/proyectos/gestor-pro/public/proyectos/crear" method="POST" enctype="multipart/form-data">

        <div class="mt-4">
            <label for="archivo" class="block text-sm font-medium text-slate-700 mb-1">Archivo Adjunto (Opcional)</label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-500 transition">
                <div class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-gray-600 justify-center">
                        <label for="archivo" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                            <span>Sube un archivo</span>
                            <input id="archivo" name="archivo" type="file" class="sr-only">
                        </label>
                    </div>
                    <p class="text-xs text-gray-500">PDF, PNG, JPG, ZIP hasta 5MB</p>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="space-y-6">
                <div>
                    <label for="titulo" class="block text-sm font-medium text-slate-700 mb-1">Título del Proyecto <span class="text-red-500">*</span></label>
                    <input type="text" id="titulo" name="titulo" required 
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                           placeholder="Ej. Rediseño Web E-commerce">
                </div>

                <div>
                    <label for="descripcion" class="block text-sm font-medium text-slate-700 mb-1">Descripción</label>
                    <textarea id="descripcion" name="descripcion" rows="5" 
                              class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                              placeholder="Detalla los objetivos y tareas principales..."></textarea>
                </div>
            </div>

            <div class="space-y-6 md:border-l md:border-gray-100 md:pl-6">
                
                <div>
                    <label for="estado" class="block text-sm font-medium text-slate-700 mb-1">Estado Inicial</label>
                    <select id="estado" name="estado" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition bg-white">
                        <option value="pendiente">Pendiente (A iniciar)</option>
                        <option value="en_progreso">En Progreso</option>
                        <option value="pausado">Pausado</option>
                    </select>
                </div>

                <div>
                    <label for="fecha_limite" class="block text-sm font-medium text-slate-700 mb-1">Fecha Límite (Deadline) <span class="text-red-500">*</span></label>
                    <input type="date" id="fecha_limite" name="fecha_limite" required 
                           min="<?php echo date('Y-m-d'); ?>"
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div>
                    <label for="asignado_a" class="block text-sm font-medium text-slate-700 mb-1">Asignar a Empleado</label>
                    <select id="asignado_a" name="asignado_a" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition bg-white">
                        <option value="">-- Dejar sin asignar por ahora --</option>
                        
                        <?php foreach($usuarios as $user): ?>
                            <?php if($user['estado'] == 'activo'): ?>
                                <option value="<?php echo $user['id']; ?>">
                                    <?php echo htmlspecialchars($user['nombre']); ?> (<?php echo htmlspecialchars($user['rol_nombre']); ?>)
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        
                    </select>
                </div>

            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-3">
            <a href="/proyectos/gestor-pro/public/proyectos" class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 transition">
                Cancelar
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition shadow-sm">
                Guardar Proyecto
            </button>
        </div>

    </form>
</div>