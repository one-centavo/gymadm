# GYMADM

Sistema de automatización administrativa de gimnasios, enfada en la gestión de miembros y membresías.

## Stack Tecnológico

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white) ![Livewire](https://img.shields.io/badge/livewire-%23FB70A9.svg?style=for-the-badge&logo=livewire&logoColor=white) ![TailwindCSS](https://img.shields.io/badge/tailwindcss-%2338B2AC.svg?style=for-the-badge&logo=tailwind-css&logoColor=white) ![Docker](https://img.shields.io/badge/docker-%232496ED.svg?style=for-the-badge&logo=docker&logoColor=white) ![Nginx](https://img.shields.io/badge/nginx-%23009639.svg?style=for-the-badge&logo=nginx&logoColor=white) ![MySQL](https://img.shields.io/badge/mysql-%234479A1.svg?style=for-the-badge&logo=mysql&logoColor=white) ![Mailpit](https://img.shields.io/badge/Mailpit-00599C?style=for-the-badge&logo=gmail&logoColor=white)

## Instalación

### Desarrollo Local

1. **Clonar el repositorio**
    ```bash
    git clone [https://github.com/one-centavo/gymadm.git](https://github.com/one-centavo/gymadm.git)
    cd gymadm
    ```

2. **Configurar variables de entorno**
   > [!IMPORTANT]
   > Asegúrate de revisar los puertos en el archivo `.env` o `docker-compose.yml`. Si el puerto 80 o 3306 están ocupados por servicios como XAMPP, cámbialos antes de continuar.
    ```bash
    cp .env.example .env
    ```

3. **Levantar los contenedores (Orquestación con Docker Compose)**
    ```bash
    docker compose up -d
    ```

4. **Instalar dependencias y preparar el entorno**
    ```bash
    docker compose exec app composer install
    docker compose exec app pnpm install
    docker compose exec app pnpm build
    docker compose exec app php artisan key:generate
    docker compose exec app php artisan storage:link
    ```

5. **Ejecutar migraciones y seeders (Base de Datos MySQL 8.0)**
    ```bash
    docker compose exec app php artisan migrate --seed
    ```

## Acceso al Sistema

* **Aplicación:** [http://localhost:8080](http://localhost:8080) (O el puerto configurado en el .env).
* **Servidor de Correos (Mailpit):** [http://localhost:8025](http://localhost:8025).

## Tareas Programadas (Automatización)

Para probar el sistema de notificaciones y verificación de vencimientos de forma manual:
```bash
docker compose exec app php artisan schedule:run
