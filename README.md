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

## Seguridad con OpenSSL y Sodium

4. [Laboratorio ejecutable](04-laboratorio-openssl/README.md) — [PDF](04-laboratorio-openssl/Trabajo_04_Laboratorio_OpenSSL.pdf).
5. [Informe técnico](05-informe-openssl/README.md) — [PDF](05-informe-openssl/Trabajo_05_Informe_OpenSSL.pdf).

Requieren PHP con OpenSSL y Sodium, sin base de datos. La aplicación está en 04-laboratorio-openssl/aplicacion; el informe incluye una copia en codigo-openssl.zip. Ambos incluyen capturas reales, paso a paso y resultados de 11 pruebas.
