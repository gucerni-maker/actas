# Sistema de Gestión de Actas de Entrega

Sistema web desarrollado en Laravel para la gestión de actas de entrega de servidores y equipos informáticos. Ideal para empresas que requieren documentar formalmente la entrega y recepción de activos tecnológicos.

## AVISO
EL PRESENTE SISTEMA ESTA CON OPCIONES DESACTIVADAS Y/O ELIMINADAS, DEBIDO A QUE EL SISTEMA ES CAPAZ DE GENERAR Y ALMACENAR ARCHIVOS PDF, ASI COMO TAMBIÉN ES CAPAZ DE CREAR, EDITAR Y ELIMNAR USUARIOS Y/O DOCUMENTOS.
TODO ESTO CON LA FINALIDAD DE MANTENER LA INTEGRIDAD DEL SISTEMA Y EL SERVIDOR QUE LO MANTIENE.


## Características Principales

- Registro y gestión de encargados/programadores
- Gestión de servidores y equipos informáticos
- Creación de actas de entrega personalizadas
- Generación automática de documentos PDF
- Sistema de usuarios con roles (administrador y consultor)
- Panel de control con estadísticas
- Interfaz completamente responsiva
- Sistema de búsqueda avanzada
- Gestión de firmas digitales
- Seguimiento de actas sin firmar

## Tecnologías Utilizadas

- **Backend:** Laravel 10.x
- **Lenguaje:** PHP 8.x
- **Base de Datos:** MySQL
- **Frontend:** Bootstrap 5, jQuery
- **Generación de PDFs:** TCPDF
- **Autenticación:** Laravel Breeze
- **Gestión de Assets:** Vite

## Capturas de Pantalla

*(Aquí puedes añadir imágenes del sistema)*
- Dashboard principal
- Listado de servidores
- Formulario de actas
- Vista previa de PDF

## Instalación Local

### Requisitos Previos
- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Node.js y npm

### Pasos de Instalación

1. **Clonar el repositorio**
   ```bash
   git clone https://github.com/gucerni-maker/actas.git
   cd gestion-actas```

2. **Instalar dependencias PHP**
- composer install

3. **Configurar variables de entorno**
- cp .env.example .env
- edita .env con tu configuración de base de datos:
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=tu_nombre_de_base_de_datos
    DB_USERNAME=tu_usuario
    DB_PASSWORD=tu_contraseña

4. **Generar clave de aplicación**
- php artisan key:generate

5. **Crear la base de datos**
- Crea una base de datos en MySQL con el nombre especificado en .env

6. **Ejecutar migraciones y seeders**
- php artisan migrate --seed

7. **Instalar dependencias de frontend**
- npm install
- npm run build

8. **Crear enlace de almacenamiento**
- php artisan storage:link

9. **Iniciar el servidor**
- php artisan serve

### Personalización
- Añadir campos adicionales
- Puedes extender los modelos existentes o crear nuevos campos según tus necesidades.
- Los estilos personalizados se encuentran en resources/css/.
- Los templates de PDF están en resources/views/pdf/.

