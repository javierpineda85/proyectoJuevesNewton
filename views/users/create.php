<div class="max-w-3xl mx-auto">
    <div class="mb-10">
        <a href="<?= url('usuarios') ?>" class="text-indigo-600 font-bold text-sm hover:underline flex items-center gap-2 mb-4">
            ← Back to Users
        </a>
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Create New User</h2>
        <p class="text-slate-500 mt-1">Register a new team member or client in the system.</p>
    </div>

    <form action="/usuarios/crear" method="POST" class="bg-white rounded-3xl shadow-xl border border-slate-200 p-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="flex flex-col gap-2">
                <label class="text-xs font-black uppercase tracking-widest text-slate-400">Full Name</label>
                <input type="text" name="nombre" required placeholder="John Doe" class="bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-xs font-black uppercase tracking-widest text-slate-400">Email Address</label>
                <input type="email" name="email" required placeholder="john@example.com" class="bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-xs font-black uppercase tracking-widest text-slate-400">Password</label>
                <input type="password" name="password" required placeholder="••••••••" class="bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-xs font-black uppercase tracking-widest text-slate-400">Phone Number</label>
                <input type="text" name="telefono" placeholder="+1 (555) 000-0000" class="bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-xs font-black uppercase tracking-widest text-slate-400">System Role</label>
                <select name="rol_id" required class="bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all appearance-none cursor-pointer">
                    <?php foreach($roles as $role): ?>
                        <option value="<?= $role['id'] ?>"><?= ucfirst($role['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-xs font-black uppercase tracking-widest text-slate-400">Account Status</label>
                <select name="estado" required class="bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all appearance-none cursor-pointer">
                    <option value="activo">Active</option>
                    <option value="inactivo">Inactive</option>
                </select>
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-10 py-4 rounded-2xl text-sm font-black uppercase tracking-widest transition-all shadow-lg hover:shadow-indigo-200 active:scale-95">
                Save User Account
            </button>
        </div>
    </form>
</div>
