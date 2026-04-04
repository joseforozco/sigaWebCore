# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Reglas del Proyecto

1. Leer `contexto/Contexto.txt` al inicio de cada sesión antes de cualquier acción.
2. Las migraciones se **generan** pero **nunca se ejecutan** — la ejecución es manual.
3. Las migraciones `0001_01_01_*` (core) no se tocan salvo justificación explícita.
4. No hacer commits, push ni operaciones git automáticas — el repositorio es de gestión manual.
5. Planificar antes de codificar y esperar aprobación del usuario.

## Comandos

```bash
# Servidor de desarrollo (o usar Valet/Herd en https://testinv.test)
php artisan serve

# Compilar assets frontend
npm run dev
npm run build

# Generar migración (solo generación, no ejecutar)
php artisan make:migration nombre_migracion

# Crear recurso Filament
php artisan make:filament-resource NombreModelo

# Limpiar caché de configuración/rutas
php artisan optimize:clear

# Ejecutar tests
php artisan test
php artisan test --filter=NombreTest
```

## Arquitectura

### Stack
- **Laravel 12 LTS** + **Filament v5** + **Spatie Permissions**
- Panel admin en `/admin` (configurado en `AdminPanelProvider`)
- Base de datos: `testinv` — URL: `https://testinv.test`

### Estructura DDD (dentro de `app/`)
- `Services/` — lógica de negocio
- `Repositories/` — acceso a datos
- `DataTransferObjects/` — DTOs
- `Observers/` — observers de modelos
- `Enums/` — enumeraciones

### Filament v5 — Diferencias clave vs v3
- `Schema` en lugar de `Form`: `Filament\Schemas\Schema`, `Filament\Schemas\Components\Section`
- `recordActions` (no `actions`) en tablas para acciones por fila
- `toolbarActions` (no `headerActions`) en tablas para acciones globales
- `Get`/`Set` desde `Filament\Schemas\Components\Utilities\Get|Set`

### Estructura de Resources
Dos patrones coexisten:
1. **Inline** (Cliente, Proveedor, User): form, infolist y table definidos directamente en el Resource
2. **Separado** (Empresas, FormaPagos, Impuestos, UnidadMedidas): form en `Schemas/NombreForm.php`, table en `Tables/NombreTable.php`, invocados desde el Resource

Preferir el patrón separado para recursos con formularios complejos.

### Permisos y Roles
- Roles: `administrador`, `auxiliar`, `contador`, `vendedor`
- Acceso al panel requiere `$user->activo` + tener alguno de esos roles (`canAccessPanel`)
- SuperAdmin: email `joseforozco@gmail.com` o `id === 1` — acceso total, no eliminable
- Permisos granulares via Spatie: `{modulo}.ver`, `{modulo}.crear`, `{modulo}.editar`, `{modulo}.eliminar`

### Flujo de Registro de Usuarios
- Registro público crea usuarios con `activo = false`
- El administrador aprueba manualmente activando y asignando rol
- El middleware `VerificarEmpresaConfigurada` redirige a crear empresa si no existe ninguna

### Empresa
- Registro único — `Empresa::actual()` retorna el primer registro
- `Empresa::usaSeriales()` controla si el módulo de seriales está activo
- Logo y brand se toman dinámicamente desde el modelo `Empresa`

### Auditoría (dos sistemas)
- `Auditoria` + tabla `auditorias`: registro a nivel de tabla (CRUD genérico)
- `AuditoriaDocumento` + tabla `auditoria_documentos`: registro por campo con valor anterior/nuevo
- Trait `RegistraAuditoria`: usar en Resources/Services que requieran trazabilidad de documentos

### Autenticación
- 2FA opcional: TOTP (`AppAuthentication`) y correo (`EmailAuthentication`)
- Login personalizado: bloquea usuarios inactivos con mensaje descriptivo
- Auto-logout configurado vía `AutoLogoutPlugin`

### Plugins Filament instalados
`filament-footer`, `filament-record-nav`, `html2media`, `filament-backgrounds`, `light-switch`, `filament-quick-create`, `filament-excel`, `filament-edit-profile`, `filament-auto-logout`

### Grupos de Navegación (orden definido en AdminPanelProvider)
`Administración` → `Configuración` → `Inventario` → `Compras` → `Ventas` → `Operaciones` → `Bancos`
