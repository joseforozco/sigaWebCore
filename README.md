# SIGA Web Core

Plantilla base para proyectos Laravel 12 + Filament v5 de SIGA Software.

Este repositorio **no es un proyecto de producción** — es el punto de partida
que se clona para crear nuevos proyectos mediante el script `crear.ps1`.

## Stack

- **Laravel 12 LTS**
- **Filament v5**
- **Spatie Permissions** (roles: administrador, auxiliar, contador, vendedor)
- **MySQL**

## Crear un nuevo proyecto

Desde PowerShell 7.5, ejecutar el script instalador:

```powershell
D:\www\scripts\crear.ps1
```

El script solicita:

| Campo | Descripción |
|---|---|
| Nombre del proyecto | Nombre de carpeta y base de datos |
| Base de datos | Nombre del schema MySQL |
| Título de la app | Aparece en el panel y correos |
| Footer empresa | Nombre en el pie de página |
| Footer URL | Enlace en el pie de página |

Luego clona este repositorio, genera el `.env`, ejecuta `migrate:fresh --seed`
y optimiza la app. Al finalizar, el proyecto queda accesible en
`https://siga.test/admin`.

## Credenciales por defecto

| Campo | Valor |
|---|---|
| Email | joseforozco@gmail.com |
| Password | Digital2019** |

## Plugins incluidos

| Plugin | Descripción |
|---|---|
| `tapp/filament-footer` | Footer personalizable |
| `nben/filament-record-nav` | Navegación entre registros |
| `torgodly/html2media` | Exportar a imagen/PDF |
| `swisnl/filament-backgrounds` | Fondos en pantalla de login |
| `awcodes/light-switch` | Modo claro/oscuro |
| `awcodes/filament-quick-create` | Creación rápida desde navbar |
| `pxlrbt/filament-excel` | Exportación Excel |
| `joaopaulolndev/filament-edit-profile` | Edición de perfil con 2FA y tokens |
| `joseforozco/filament-auto-logout` | Cierre de sesión automático por inactividad |

## Módulos base incluidos

- **Empresa** — datos de la empresa (único registro, requerido antes de operar)
- **Usuarios** — gestión con aprobación manual y notificaciones por correo
- **Clientes** — catálogo con crédito, ubicación y exportación Excel
- **Proveedores** — catálogo con ubicación y exportación Excel
- **Formas de pago** — catálogo
- **Impuestos** — catálogo
- **Unidades de medida** — catálogo
- **Auditoría** — trazabilidad a nivel de tabla y de documento

## Autenticación

- Login personalizado: bloquea usuarios inactivos con mensaje descriptivo
- Registro público: crea usuarios como `activo = false`, el administrador aprueba
- 2FA opcional: TOTP (app autenticadora) y por correo
- Auto-logout configurable vía variables de entorno:

```env
FILAMENT_AUTO_LOGOUT_ENABLED=true
FILAMENT_AUTO_LOGOUT_DURATION_IN_SECONDS=180
FILAMENT_AUTO_LOGOUT_WARN_BEFORE_IN_SECONDS=30
FILAMENT_AUTO_LOGOUT_SHOW_TIME_LEFT=true
```

## Variables de entorno relevantes

```env
APP_NAME="Nombre del proyecto"
APP_URL=https://siga.test
DB_DATABASE=nombre_db
FOOTER_COMPANY_NAME="SIGA Software"
FOOTER_COMPANY_URL="https://www.joseforozco.com"
```
