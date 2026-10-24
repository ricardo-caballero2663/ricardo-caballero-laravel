# Laboratorios de Laravel

**Ricardo Caballero · 1S3122 · Desarrollo Web**  
Universidad Tecnológica de Panamá  
Docente: Ing. Irina Fong

## Trabajos individuales

1. [Login y registro](01-login-registro/README.md) — [Informe PDF](01-login-registro/Trabajo_01_Login_Registro.pdf).
2. [Documentación del laboratorio](02-documentacion/README.md) — [Informe PDF](02-documentacion/Trabajo_02_Documentacion.pdf).
3. [CRUD de productos](03-crud-productos/README.md) — [Informe PDF](03-crud-productos/Trabajo_03_CRUD_Productos.pdf).

Cada trabajo contiene capturas reales, explicación paso a paso y respaldo SQL. Los proyectos ejecutables se encuentran en las carpetas `aplicacion/` de los trabajos 01 y 03. La documentación incluye una copia independiente del código del login en `codigo-login.zip`.

## Ejecutar

Consulta el README de cada trabajo. Requisitos: PHP 8.2 o superior, Composer, Node.js y MariaDB. Instala las dependencias con `composer install` y `npm ci`, configura `.env`, ejecuta las migraciones y compila con `npm run build`.

Los archivos `.env`, dependencias, sesiones y registros internos no se incluyen. Los datos de los respaldos son de demostración.

## Validación

- Login: 7 pruebas automáticas, 22 aserciones.
- CRUD: 12 pruebas automáticas, 45 aserciones.
- Flujos comprobados en navegador contra MariaDB.
- Respaldos restaurados en bases nuevas para comprobarlos.
