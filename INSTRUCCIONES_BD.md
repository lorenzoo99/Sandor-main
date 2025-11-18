# 📋 Instrucciones para Configurar la Base de Datos

## ✅ Configuración completada en `.env`

El archivo `.env` ya está configurado con:
- **Base de datos:** MySQL
- **Nombre de BD:** `sandor`
- **Usuario:** `root`
- **Contraseña:** (vacía)
- **Host:** `127.0.0.1`
- **Puerto:** `3306`

---

## 🚀 Pasos para inicializar la base de datos

### 1. Crear la base de datos en MySQL

Abre tu cliente MySQL (phpMyAdmin, MySQL Workbench, o terminal) y ejecuta:

```sql
CREATE DATABASE sandor CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. Importar las tablas

Ejecuta el archivo `Create Sandor.sql` que contiene toda la estructura:

**Opción A - Desde terminal:**
```bash
mysql -u root -p sandor < "Create Sandor.sql"
```

**Opción B - Desde phpMyAdmin:**
1. Selecciona la base de datos `sandor`
2. Ve a la pestaña "Importar"
3. Selecciona el archivo `Create Sandor.sql`
4. Haz clic en "Continuar"

### 3. Instalar dependencias de Laravel (si no lo has hecho)

```bash
composer install
npm install
```

### 4. Verificar conexión

Puedes probar la conexión ejecutando:

```bash
php artisan migrate:status
```

---

## 📝 Notas importantes

- Si tu usuario MySQL tiene contraseña, edita la línea `DB_PASSWORD=` en el `.env`
- Si usas un puerto diferente a 3306, cambia `DB_PORT=3306`
- El `.env` está en `.gitignore` por seguridad (no se sube a GitHub)

---

## ⚠️ Si tienes problemas de conexión

**Error: "Access denied for user 'root'@'localhost'"**
- Verifica que tu usuario MySQL sea correcto
- Agrega tu contraseña en `DB_PASSWORD=`

**Error: "Unknown database 'sandor'"**
- Asegúrate de haber creado la base de datos con el paso 1

**Error: "Connection refused"**
- Verifica que MySQL esté corriendo
- Comprueba el puerto con: `netstat -an | grep 3306`

---

## 📞 Soporte

Si necesitas ayuda, revisa los logs de Laravel en `storage/logs/laravel.log`
