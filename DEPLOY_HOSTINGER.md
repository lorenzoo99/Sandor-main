# Guía de Despliegue en Hostinger Single

Esta guía te ayudará a desplegar FarmaProf en tu hosting Hostinger Single.

## Requisitos Previos

- Plan Hostinger Single activado
- Dominio configurado
- PHP 8.2+ (verificar en hPanel)

---

## PASO 1: Configurar PHP en Hostinger

1. Ingresa a **hPanel** de Hostinger
2. Ve a **Avanzado → Configuración de PHP**
3. Selecciona **PHP 8.2** o superior
4. En **Extensiones PHP**, activa:
   - `pdo_mysql`
   - `mbstring`
   - `openssl`
   - `tokenizer`
   - `xml`
   - `ctype`
   - `json`
   - `bcmath`
   - `fileinfo`
5. Guarda los cambios

---

## PASO 2: Crear Base de Datos MySQL

1. En hPanel, ve a **Bases de datos → MySQL**
2. Crea una nueva base de datos:
   - **Nombre**: `sandor` (se agregará prefijo automático, ej: `u123456789_sandor`)
   - **Usuario**: crea un usuario con contraseña segura
3. **IMPORTANTE**: Anota estos datos:
   - Nombre de la base de datos completo
   - Usuario de la base de datos
   - Contraseña
   - Host (generalmente `localhost`)

---

## PASO 3: Importar la Base de Datos

1. Ve a **Bases de datos → phpMyAdmin**
2. Selecciona tu base de datos creada
3. Click en **Importar**
4. Selecciona el archivo `sandor.sql` del proyecto
5. Click en **Importar**

---

## PASO 4: Preparar Archivos para Subir

### Estructura de carpetas en Hostinger:

```
public_html/              ← Aquí va el contenido de /public
├── index.php            (modificado)
├── .htaccess
├── build/
│   └── assets/
├── robots.txt
└── favicon.ico

/home/u123456789/sandor/  ← Aquí va el resto del proyecto (fuera de public_html)
├── app/
├── bootstrap/
├── config/
├── database/
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env
└── artisan
```

---

## PASO 5: Modificar index.php

Antes de subir, edita el archivo `public/index.php` para que apunte a la nueva ubicación:

```php
<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determinar si la aplicación está en mantenimiento
if (file_exists($maintenance = __DIR__.'/../sandor/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Registrar el autoloader de Composer
require __DIR__.'/../sandor/vendor/autoload.php';

// Iniciar Laravel y manejar la solicitud
$app = require_once __DIR__.'/../sandor/bootstrap/app.php';

$app->handleRequest(Request::capture());
```

**Nota**: Reemplaza `sandor` con el nombre de la carpeta que creaste.

---

## PASO 6: Subir Archivos a Hostinger

### Opción A: Usando File Manager (Recomendado)

1. En hPanel, ve a **Archivos → Administrador de archivos**
2. Crea la carpeta `sandor` en `/home/u123456789/` (fuera de public_html)
3. Sube todo el proyecto EXCEPTO la carpeta `public` a esta carpeta
4. Sube el CONTENIDO de la carpeta `public` a `public_html`

### Opción B: Usando FTP

1. Conéctate con FileZilla u otro cliente FTP
2. Credenciales en hPanel → **Archivos → Cuentas FTP**
3. Sigue la misma estructura del Paso 5

### Archivos a subir a `/home/u123456789/sandor/`:
- `app/`
- `bootstrap/`
- `config/`
- `database/`
- `resources/`
- `routes/`
- `storage/`
- `vendor/`
- `artisan`
- `composer.json`
- `composer.lock`

### Archivos a subir a `public_html/`:
- Todo el contenido de la carpeta `public/`
- El `index.php` modificado

---

## PASO 7: Configurar el Archivo .env

1. Copia `.env.production.example` como `.env`
2. Edita con tus datos reales:

```env
APP_URL=https://tu-dominio.com

DB_HOST=localhost
DB_DATABASE=u123456789_sandor
DB_USERNAME=u123456789_admin
DB_PASSWORD=TuContraseñaSegura
```

3. Sube el archivo `.env` a `/home/u123456789/sandor/`

---

## PASO 8: Generar APP_KEY

Tienes dos opciones:

### Opción A: Generar localmente
1. En tu computadora, ejecuta:
   ```bash
   php artisan key:generate --show
   ```
2. Copia la clave generada (ej: `base64:xxxxxxxxxxxx`)
3. Pégala en el `.env` de Hostinger

### Opción B: Generar online
1. Visita: https://generate-random.org/laravel-key-generator
2. Copia la clave generada
3. Pégala en `APP_KEY=` del archivo `.env`

---

## PASO 9: Configurar Permisos

En el Administrador de archivos de Hostinger:

1. Click derecho en la carpeta `storage` → **Permisos**
2. Establece permisos **775** recursivamente
3. Repite para `bootstrap/cache`

O usa el terminal SSH (si está disponible):
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

---

## PASO 10: Configurar Caché y Optimización

Si tienes acceso SSH en Hostinger (o usando la terminal web):

```bash
cd ~/sandor
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Si NO tienes SSH, crea un archivo temporal para ejecutar estos comandos:

1. Crea `public_html/setup.php`:

```php
<?php
// ELIMINAR DESPUÉS DE USAR - Solo para configuración inicial

$basePath = dirname(__DIR__) . '/sandor';
chdir($basePath);

echo "<pre>";

// Ejecutar comandos de Artisan
echo "Cacheando configuración...\n";
echo shell_exec('php artisan config:cache 2>&1');

echo "\nCacheando rutas...\n";
echo shell_exec('php artisan route:cache 2>&1');

echo "\nCacheando vistas...\n";
echo shell_exec('php artisan view:cache 2>&1');

echo "\nOptimizando...\n";
echo shell_exec('php artisan optimize 2>&1');

echo "\n✅ Configuración completada!\n";
echo "⚠️ ELIMINA ESTE ARCHIVO AHORA por seguridad.";
echo "</pre>";
```

2. Visita `https://tu-dominio.com/setup.php`
3. **ELIMINA** el archivo `setup.php` inmediatamente después

---

## PASO 11: Configurar SSL

1. En hPanel, ve a **Seguridad → SSL**
2. Activa **SSL Gratuito** para tu dominio
3. Espera unos minutos a que se propague
4. Activa **Forzar HTTPS** para redirigir todo el tráfico

---

## PASO 12: Verificar la Instalación

1. Visita `https://tu-dominio.com`
2. Deberías ver la página de bienvenida
3. Intenta registrarte o iniciar sesión

---

## Solución de Problemas

### Error 500 (Internal Server Error)

1. Verifica que PHP 8.2+ está activo
2. Revisa los permisos de `storage` y `bootstrap/cache`
3. Verifica que el archivo `.env` existe y tiene APP_KEY
4. Revisa `storage/logs/laravel.log` para más detalles

### Página en blanco

1. Activa `APP_DEBUG=true` temporalmente en `.env`
2. Recarga la página para ver el error
3. Corrige el problema
4. Vuelve a poner `APP_DEBUG=false`

### Error de base de datos

1. Verifica credenciales en `.env`
2. Confirma que la base de datos existe
3. Verifica que el usuario tiene permisos completos

### Error 404 en rutas

1. Verifica que `.htaccess` está en `public_html`
2. Activa `mod_rewrite` en configuración PHP de Hostinger

### Assets no cargan (CSS/JS)

1. Verifica que la carpeta `build/` está en `public_html`
2. Revisa la consola del navegador para errores específicos

---

## Mantenimiento

### Actualizar la aplicación

1. Sube los nuevos archivos (excepto `.env` y `storage/`)
2. Ejecuta migraciones si hay cambios en BD:
   - Usa SSH: `php artisan migrate --force`
   - O crea un script temporal similar al del Paso 10

### Limpiar caché

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## Usuario por Defecto

Después de importar `sandor.sql`, usa estas credenciales para acceder:

**Email**: Revisa los registros en la tabla `usuario`
**Contraseña**: La que estaba configurada en el sistema original

Si necesitas crear un nuevo usuario administrador, puedes usar phpMyAdmin para insertar un registro en la tabla `usuario`.

---

## Soporte

Si tienes problemas con el hosting:
- Chat de soporte de Hostinger (24/7)
- Base de conocimientos: https://support.hostinger.com

---

¡Listo! Tu aplicación FarmaProf debería estar funcionando en Hostinger.
