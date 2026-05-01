# Project Instructions (sigaBase)

Este archivo contiene las directrices fundamentales para el desarrollo en el proyecto **sigaBase**.

## Stack Tecnológico
- **PHP:** 8.4
- **Framework:** Laravel 13
- **Admin Panel:** Filament PHP v5.x (Estándares estrictos)
- **Base de Datos:** MySQL (InnoDB, utf8mb4)
- **Entorno:** Windows 11 + PowerShell 7.5.4 (Laragon)

## Reglas de Oro
1. **Entorno Estricto:** Prohibido usar comandos de Linux/Bash. Toda instrucción debe ser compatible con PowerShell 7.5.
2. **Filament v5 Standards:** 
   - Los Recursos DEBEN delegar en clases `Schema` e `Infolist` en la carpeta `Schemas/` y clases `Table` en `Tables/`.
   - El método `form()` debe recibir `Schema $schema` (no `Form $form`).
   - Iconos: Usar siempre el Enum `Heroicon::Outlined*` para la navegación.
3. **Seguridad y Tipos:**
   - Dinero: Usar siempre el tipo `decimal(15, 2)` en migraciones y `->currency()` en Filament. Prohibido `float`.
   - Null Safety: Uso obligatorio de `?->` para relaciones y propiedades nullables.
   - Enums: Usar siempre `->value` para comparaciones y queries. Evitar Enums como llaves de arrays asociativos.
4. **Arquitectura DDD:**
   - Lógica de negocio en `app/Services/`.
   - Transferencia de datos mediante `app/DataTransferObjects/`.
   - Registro de actividad crítica mediante `app/Observers/` y el Trait `RegistraAuditoria`.
5. **Base de Datos:**
   - Nombres en `snake_case`.
   - Claves primarias `BIGINT UNSIGNED AUTO_INCREMENT`.
   - Índices únicos obligatorios para campos identificadores externos.
   - Toda operación multi-tabla DEBE estar dentro de `DB::transaction()`.

## Auditoría y Validación
- Antes de cada implementación, consultar los checklists en `contexto/Auditoria.txt`, `contexto/Auditoria_Seguridad.txt` y `contexto/Auditoria_JS_Node.txt`.
- No tocar lo que ya funciona. Cada cambio debe ser un paso aislado y específico.
- Validar siempre la existencia de columnas en las migraciones reales antes de referenciarlas en el código.

## Comandos Útiles (PowerShell)
- `php artisan migrate --graceful`
- `php artisan filament:optimize` (Solo en producción)
- `php artisan about` (Verificar versiones)
