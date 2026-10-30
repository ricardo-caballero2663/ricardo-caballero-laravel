# Laboratorio OpenSSL en PHP

Ricardo Caballero · Grupo 1S3122 · Desarrollo Web · Ing. Irina Fong

https://github.com/ricardo-caballero2663/ricardo-caballero-laravel

## Entregable

[Trabajo_04_Laboratorio_OpenSSL.pdf](Trabajo_04_Laboratorio_OpenSSL.pdf)

## Paso a paso

1. Instalar PHP 8.2 o superior. Comprobar con php -v y php -m que estén habilitadas openssl y sodium. En Windows, habilitar extension=openssl y extension=sodium en el php.ini correspondiente y reiniciar el servidor.

2. Abrir una terminal dentro de aplicacion. El archivo openssl.cnf incluido evita depender de una ruta fija como C:\OpenSSL-Win64. No se requiere MySQL.

3. Ejecutar php -S 127.0.0.1:18085 -t public. Abrir http://127.0.0.1:18085 en el navegador. El servidor de desarrollo se limita al equipo local.

4. En firma7, escribir un mensaje en ambos campos y pulsar Ejecutar firma7. Debe aparecer VÁLIDA. Cambiar el campo de verificación y repetir para obtener INVÁLIDA.

5. En firmaOtra, escribir el nombre del titular de prueba y ejecutar. Revisar la CSR, el certificado X.509 y las claves PEM generadas. Mantener la misma sesión del navegador.

6. Entrar a FirmaMensaje y ejecutar con textos iguales. Se usa la clave y el certificado creados en el paso anterior. Cambiar el mensaje que se verificará y comprobar que la firma sea rechazada.

7. En Encriptacion, ingresar texto y ejecutar. Comparar el descifrado con el original. Revisar IV, cifrado Base64 y el rechazo de alteración en la prueba adicional AES-256-GCM.

8. En Sodium, ingresar texto y ejecutar. Revisar nonce, cifrado, recuperación del mensaje y rechazo de una modificación de un byte.

9. Ejecutar php tests.php en la carpeta aplicacion. Deben aprobarse 11 pruebas. Si sodium no está cargado, usar php -d extension=sodium tests.php tras verificar que la extensión esté instalada.

10. Cerrar el servidor con Ctrl+C. Las claves de demostración no deben reutilizarse. En producción se requieren gestión de secretos, HTTPS, controles de acceso y almacenamiento seguro.

## Validación

11 pruebas correctas: firma válida e inválida, certificado y clave correspondientes, cifrado y descifrado, rechazo de alteraciones y mensaje vacío.

## Fuentes

- [Repositorio de la docente](https://github.com/Salomon2514/SeguridadOpenSSL)
- [PHP OpenSSL](https://www.php.net/manual/en/book.openssl.php)
- [Firma digital en PHP](https://www.php.net/manual/en/function.openssl-sign.php)
- [Cifrado en PHP](https://www.php.net/manual/en/function.openssl-encrypt.php)
- [PHP Sodium](https://www.php.net/manual/en/book.sodium.php)
- [Secretbox](https://doc.libsodium.org/secret-key_cryptography/secretbox)
- [Firmas Ed25519](https://doc.libsodium.org/public-key_cryptography/public-key_signatures)
- [Hashing de contraseñas](https://doc.libsodium.org/password_hashing)
