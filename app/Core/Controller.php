<?php
// app/Core/Controller.php
namespace app\Core;

class Controller {
    
    // Método para renderizar vistas
    protected function render($view, $data = [], $layout = 'app') {
        // Convierte el array ['nombre' => 'Nicolas'] en la variable $nombre
        extract($data); 
        
        // Iniciamos el "Output Buffering" (Almacena el HTML en memoria, no lo imprime todavía)
        ob_start();
        
        // Cargamos la vista específica (ej: dashboard/index.php)
        require VIEWS_PATH . '/' . $view . '.php';
        
        // Guardamos todo ese HTML en la variable $content y limpiamos la memoria
        $content = ob_get_clean();
        
        // Ahora cargamos el Layout maestro, inyectándole el $content en el medio
        require VIEWS_PATH . '/layouts/' . $layout . '.php';
    }
}