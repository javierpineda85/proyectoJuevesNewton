# proyectoJuevesNewton
Proyecto integrador del curso de programación web de la escuela Newton. En este proyecto deben incorporar HTML, CSS, JavaScript, POO, Base de datos y PHP
# 🏢 Gestor Pro

Gestor Pro es un sistema integral de gestión (CRM + Tickets + Trámites + Proyectos) desarrollado por **Vex Studio**. Está diseñado con una arquitectura modular y escalable (White-label) que permite ser comercializado e implementado en múltiples clientes de manera independiente.

## 🛠️ Stack Tecnológico

* **Backend:** PHP 8+ (Puro, sin frameworks comerciales)
* **Base de Datos:** MySQL (Conexión vía PDO)
* **Frontend:** HTML5, CSS3, JavaScript, TailwindCSS (vía CDN para prototipado)
* **Arquitectura:** Patrón MVC (Modelo-Vista-Controlador) con Front Controller.
* **Entorno de Desarrollo:** WAMPServer.

---

## 🏗️ Arquitectura del Sistema

Para garantizar la seguridad y escalabilidad a nivel de producto vendible, el sistema utiliza un patrón **Front Controller**. 

* **Punto de Entrada Único:** Todas las peticiones HTTP pasan obligatoriamente por `public/index.php`. 
* **Seguridad .htaccess:** La carpeta `public/` es la única expuesta al navegador. Los controladores, modelos y credenciales de base de datos (`app/`) están protegidos y son inaccesibles por URL directa.
* **Enrutador Propio (Router):** Mapea URLs amigables a métodos específicos de los Controladores.
* **Motor de Vistas:** Las vistas se inyectan dinámicamente dentro de un Layout maestro (`layouts/app.php`), evitando la duplicación de código en el Frontend.

### 📁 Estructura de Carpetas Principal

```text
gestor-pro/
│
├── app/                    # Lógica de negocio
│   ├── Controllers/        # Controladores (Reciben petición, llaman modelo, envían vista)
│   ├── Models/             # Modelos (Consultas a DB vía PDO)
│   ├── Core/               # Motor del sistema (Router, DB Singleton, Controller base)
│   └── Config/             # Variables de entorno y credenciales (config.php)
│
├── public/                 # Directorio expuesto al servidor web
│   ├── index.php           # Front Controller
│   └── .htaccess           # Reglas de reescritura de URL
│
├── views/                  # Interfaz de usuario (HTML + PHP ligero)
│   ├── layouts/            # Plantillas maestras (Sidebar, Header)
│   ├── auth/               # Vistas de autenticación
│   └── users/              # Vistas del módulo de usuarios
│
└── routes/
    └── web.php             # Definición de rutas del sistema
