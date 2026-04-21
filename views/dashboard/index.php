<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 border-l-4 border-l-blue-500">
        <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wide">Tickets Abiertos</h3>
        <p class="text-3xl font-bold text-gray-800 mt-2">
            <?php echo $kpis['tickets_abiertos']; ?>
        </p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 border-l-4 border-l-green-500">
        <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wide">Proyectos Activos</h3>
        <p class="text-3xl font-bold text-gray-800 mt-2">
            <?php echo $kpis['proyectos_activos']; ?>
        </p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 border-l-4 border-l-purple-500">
        <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wide">Trámites Pendientes</h3>
        <p class="text-3xl font-bold text-gray-800 mt-2">
            <?php echo $kpis['tramites_pendientes']; ?>
        </p>
    </div>

</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h3 class="text-lg font-semibold text-gray-800">Actividad Reciente</h3>
    </div>
    <div class="p-6 text-center text-gray-500 py-12">
        <p>Aún no hay actividad registrada en la base de datos.</p>
        <p class="text-sm mt-2">Pronto conectaremos esto con MySQL.</p>
    </div>
</div>