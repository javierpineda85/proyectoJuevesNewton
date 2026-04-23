// Archivo JavaScript para el chatbot del sistema de gestión profesional
// Este chatbot responde a preguntas comunes sobre el sistema, como cómo crear tickets, ver estados, horarios, usuarios y más. Utiliza palabras clave para identificar la intención del usuario y proporcionar respuestas relevantes.
const respuestas = {
    "ayuda": "¡Hola! Soy tu asistente virtual. Puedo ayudarte con: crear tickets, ver estados, horarios, usuarios y más. ¿Qué necesitas?",
    "estado": "Para ver el estado de tus trámites, ve a 'Tickets / Trámites' en el menú lateral izquierdo.",
    "horario": "Nuestro horario de atención es de Lunes a Viernes, de 9:00 a 18:00 horas.",
    "ticket": "Para crear un nuevo ticket, haz clic en el botón 'Nuevo Ticket' en la página de Tickets.",
    "crear": "Si quieres crear un ticket o proyecto, ve a las secciones correspondientes en el menú.",
    "usuario": "Para gestionar usuarios, solo administradores pueden acceder desde 'Gestión de Usuarios'.",
    "login": "Si tienes problemas para iniciar sesión, verifica tu email y contraseña. El superadmin es admin@gestor.com / admin123.",
    "proyecto": "Los proyectos se gestionan desde la sección correspondiente. Contacta a un administrador para más detalles.",
    "documento": "Para ver documentos de proyectos, ve a 'Mis Proyectos' en tu dashboard.",
    "hola": "¡Hola! ¿En qué puedo ayudarte hoy?",
    "gracias": "¡De nada! Estoy aquí para ayudarte.",
    "adios": "¡Hasta luego! Que tengas un buen día.",
    "problema": "Si tienes un problema, crea un ticket detallando la situación.",
    "soporte": "Para soporte técnico, crea un ticket o contacta al administrador.",
    "contacto": "Puedes contactar al soporte creando un ticket en el sistema.",
    "emergencia": "Para emergencias, contacta directamente al administrador del sistema."
};

function chatBot(mensajeUsuario) {
    const input = mensajeUsuario.toLowerCase().trim();
    let respuesta = "Lo siento, no entiendo eso. Intenta decir 'ayuda' para ver opciones disponibles.";

    // Palabras clave para buscar
    // Cada clave tiene varias formas de preguntar lo mismo, para mejorar la detección de la intención del usuario
    const palabrasClave = {
        "ayuda": ["ayuda", "help", "ayudame", "qué puedes hacer"],
        "estado": ["estado", "ver estado", "cómo ver", "mis tramites"],
        "horario": ["horario", "horarios", "atención", "cuándo"],
        "ticket": ["ticket", "crear ticket", "nuevo ticket", "trámite"],
        "crear": ["crear", "nuevo", "agregar"],
        "usuario": ["usuario", "usuarios", "cuenta", "perfil"],
        "login": ["login", "iniciar", "entrar", "contraseña"],
        "proyecto": ["proyecto", "proyectos", "documentos", "archivos"],
        "documento": ["documento", "docs", "archivos", "ver docs"],
        "hola": ["hola", "hi", "buenos días", "buenas tardes", "saludos"],
        "gracias": ["gracias", "thank you", "agradecido"],
        "adios": ["adios", "bye", "hasta luego", "chau"],
        "problema": ["problema", "error", "issue", "no funciona"],
        "soporte": ["soporte", "ayuda técnica", "support"],
        "contacto": ["contacto", "contactar", "comunicarse"],
        "emergencia": ["emergencia", "urgente", "emergency"]
    };

    // Buscar coincidencias
    for (let clave in palabrasClave) {
        for (let palabra of palabrasClave[clave]) {
            if (input.includes(palabra)) {
                respuesta = respuestas[clave];
                break;
            }
        }
        if (respuesta !== "Lo siento, no entiendo eso. Intenta decir 'ayuda' para ver opciones disponibles.") {
            break;
        }
    }

    // Respuestas especiales para frases completas
    if (input.includes("cómo crear") || input.includes("como crear")) {
        respuesta = "Para crear un ticket: 1) Ve a 'Tickets / Trámites', 2) Haz clic en 'Nuevo Ticket', 3) Llena el formulario.";
    } else if (input.includes("olvidé") || input.includes("olvide")) {
        respuesta = "Si olvidaste tu contraseña, contacta al administrador. El superadmin es admin@gestor.com.";
    } else if (input.includes("qué es") || input.includes("que es")) {
        respuesta = "Este es un sistema de gestión profesional para trámites, usuarios y proyectos.";
    }

    return respuesta;
}

// Ejemplo de uso:
// console.log(chatBot("¿Cómo veo mi estado?"));

// Cargar el JSON y buscar respuesta
async function buscarEnBot(mensajeUsuario) {
    const respuesta = await fetch('bot_conocimiento.json');
    const datos = await respuesta.json();
    
    const encontrado = datos.preguntas.find(p => 
        mensajeUsuario.toLowerCase().includes(p.clave)
    );

    return encontrado ? encontrado.respuesta : "No entiendo tu duda, ¿puedes intentar con otra palabra?";
}
const baseConocimiento = {
    "tramite": "Los trámites pueden estar en estado: Pendiente, En Proceso o Finalizado.",
    "archivo": "Puedes subir archivos PDF, JPG y PNG de hasta 5MB.",
    "roles": "Existen Superadmin, Administrativo, Profesionales y Clientes.",
    "contacto": "El soporte técnico atiende de 9 a 18hs."
};

function responderBot(pregunta) {
    let p = pregunta.toLowerCase();
    let r = "Lo siento, no tengo información sobre eso. Intenta con palabras como 'tramite' o 'archivo'.";

    for (let clave in baseConocimiento) {
        if (p.includes(clave)) {
            r = baseConocimiento[clave];
            break;
        }
    }
    return r;
}
function preguntarAlBot() {
    const input = document.getElementById('bot-input');
    const chat = document.getElementById('chat-window');
    
    if (input.value === "") return;

    // Mostrar mensaje del usuario
    chat.innerHTML += `<p class="text-end"><strong>Tú:</strong> ${input.value}</p>`;

    // Obtener respuesta (usando la lógica que definimos anteriormente)
    const respuesta = responderBot(input.value); 

    // Simular retraso de escritura
    setTimeout(() => {
        chat.innerHTML += `<p class="text-primary"><strong>Bot:</strong> ${respuesta}</p>`;
        chat.scrollTop = chat.scrollHeight; // Auto-scroll al final
    }, 600);

    input.value = "";
}