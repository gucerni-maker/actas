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

## Instalación Local

### Requisitos Previos
- Git
    sudo apt install git
    
- Docker y docker compose
    sudo apt install apt-transport-https ca-certificates curl software-properties-common -y
    
    curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg
    
    echo \
    "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.asc] https://download.docker.com/linux/ubuntu \
    $(. /etc/os-release && echo "$UBUNTU_CODENAME") stable" | \
    sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
    
    sudo apt update
    sudo apt install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin

    sudo usermod -aG docker ${USER}

### Pasos de Instalación

# Descargar e ingresar al directorio
   git clone https://github.com/gucerni-maker/actas.git
   cd gestion-actas

# Otorgar permisos
- chmod -R 775 storage bootstrap/cache

# Instalar dependencias
- docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs

# Configurar variables de entorno
- cp .env.example .env
- nano .env

# configurar archivo .env
  APP_PORT=8080
  DB_CONNECTION=mysql
  DB_HOST=mysql
  DB_PORT=3306
  DB_DATABASE=laravel
  DB_USERNAME=sail
  DB_PASSWORD=password
  
# Construir la imagen
- ./vendor/bin/sail up -d

# Generar clave de aplicación
- ./vendor/bin/sail artisan key:generate

# Ejecutar las migraciones
- ./vendor/bin/sail artisan migrate

# Ejecutar los seeds
- ./vendor/bin/sail artisan db:seed 

# Acceder a la aplicacion
- http://localhost:8080


