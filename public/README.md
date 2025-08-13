
# ISOSPAM – Dashboard de Reportes (PHP + AdminLTE 3)

**Requisitos**
- PHP 7.4+ (recomendado 8.x)
- Extensión PDO_PGSQL habilitada
- PostgreSQL accesible (host/puerto/credenciales abajo)

**Conexión por defecto (ajusta si aplica):**
- Base de Datos: `ISOSPAM`
- Host: `localhost`
- Puerto: `5432`
- Usuario: `postgres`
- Clave: `postgres`
- Schema (opcional): `pesca` (si tu backup usa schema, se hace `SET search_path TO pesca` automáticamente si lo configuras).

**Instalación**
1. Copia este proyecto a tu hosting o servidor local (Apache/Nginx).
2. Ajusta `config/db.php` si tus credenciales o host difieren.
3. Apunta tu navegador a `index.php`.
4. Todos los archivos de reportes están en `reportes/`, puedes modificarlos o extenderlos.

**Tecnologías**
- AdminLTE 3 (CDN)
- Bootstrap 4 (incluido con AdminLTE 3)
- Chart.js (CDN) para gráficos
- Leaflet (CDN) + Leaflet.heat (CDN) para mapas

**Notas**
- Este es un esqueleto listo para conectar. Si tu esquema difiere en nombres de tablas/campos, ajusta los SELECT en cada reporte.
- Los reportes 1, 2, 3, 4, 5, 6, 22 y 35 vienen implementados como ejemplo.
- El resto (7–21, 23–34, 36–40) están como plantillas con SQL sugerido y TODOs.
