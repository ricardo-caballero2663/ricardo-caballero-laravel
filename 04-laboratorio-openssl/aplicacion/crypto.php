<?php
declare(strict_types=1);
// Recreación educativa de los ejemplos de Ing. Irina Fong: Salomon2514/SeguridadOpenSSL.
function cfg(): array { return ['config'=>__DIR__.'/openssl.cnf','private_key_bits'=>2048,'private_key_type'=>OPENSSL_KEYTYPE_RSA,'digest_alg'=>'sha256']; }
function required(mixed $v): mixed { if ($v===false) throw new RuntimeException(openssl_error_string() ?: 'Operación criptográfica fallida'); return $v; }
function keys(): array {
 $k=required(openssl_pkey_new(cfg())); required(openssl_pkey_export($k,$pem,null,cfg()));
 return [$k,$pem,required(openssl_pkey_get_details($k))['key']];
}
function signResult(string $text, string $check, string $private, string $public): array {
 $key=required(openssl_pkey_get_private($private)); required(openssl_sign($text,$sig,$key,OPENSSL_ALGO_SHA256));
 $v=openssl_verify($check,$sig,$public,OPENSSL_ALGO_SHA256);
 if ($v===-1 || $v===false) throw new RuntimeException('Error al verificar');
 return ['Firma Base64'=>base64_encode($sig),'Verificación'=>$v===1?'VÁLIDA: el mensaje coincide':'INVÁLIDA: el mensaje fue alterado'];
}
function executeLab(string $mode,string $text,string $check,string $name): array {
 if (trim($text)==='' || strlen($text)>4000) throw new InvalidArgumentException('Escribe un mensaje de 1 a 4000 bytes.');
 if (strlen($check)>4000 || strlen($name)>64 || trim($name)==='') throw new InvalidArgumentException('Revisa la longitud de los datos.');
 if ($mode==='firma7') {
  [$key,$private,$public]=keys();
  return signResult($text,$check,$private,$public)+['Clave pública PEM'=>$public,'Clave privada de demostración PEM'=>$private];
 }
 if ($mode==='firmaOtra') {
  [$key,$private,$public]=keys();
  $dn=['countryName'=>'PA','organizationName'=>'Laboratorio UTP','commonName'=>$name];
  $csr=required(openssl_csr_new($dn,$key,cfg())); required(openssl_csr_export($csr,$csrPem));
  $cert=required(openssl_csr_sign($csr,null,$key,365,cfg(),random_int(1,2147483647)));
  required(openssl_x509_export($cert,$certPem));
  $_SESSION['demo_private']=$private; $_SESSION['demo_cert']=$certPem;
  return ['Resultado'=>'Certificado autofirmado generado. Ya puedes usar FirmaMensaje.','Titular'=>$name,'CSR PEM'=>$csrPem,'Certificado X.509 PEM'=>$certPem,'Clave pública PEM'=>$public,'Clave privada de demostración PEM'=>$private];
 }
 if ($mode==='FirmaMensaje') {
  if (!isset($_SESSION['demo_private'],$_SESSION['demo_cert'])) throw new RuntimeException('Primero ejecuta firmaOtra en esta sesión.');
  return signResult($text,$check,$_SESSION['demo_private'],$_SESSION['demo_cert'])+['Certificado utilizado'=>$_SESSION['demo_cert']];
 }
 if ($mode==='Encriptacion') {
  $key=random_bytes(16); $iv=random_bytes(openssl_cipher_iv_length('aes-128-cbc'));
  $cipher=required(openssl_encrypt($text,'aes-128-cbc',$key,OPENSSL_RAW_DATA,$iv));
  $plain=required(openssl_decrypt($cipher,'aes-128-cbc',$key,OPENSSL_RAW_DATA,$iv));
  $gkey=random_bytes(32); $giv=random_bytes(12); $tag='';
  $g=required(openssl_encrypt($text,'aes-256-gcm',$gkey,OPENSSL_RAW_DATA,$giv,$tag));
  $altered=$g; $altered[0]=chr(ord($altered[0])^1);
  $reject=openssl_decrypt($altered,'aes-256-gcm',$gkey,OPENSSL_RAW_DATA,$giv,$tag)===false;
  return ['Algoritmo base'=>'AES-128-CBC (reproducción educativa; no autentica por sí solo)','Clave de prueba Base64'=>base64_encode($key),'IV Base64'=>base64_encode($iv),'Cifrado Base64'=>base64_encode($cipher),'Descifrado'=>$plain,'Coincidencia'=>$plain===$text?'CORRECTA':'ERROR','Mejora AES-256-GCM'=>'Cifrado autenticado: '.($reject?'alteración RECHAZADA':'ERROR'),'Etiqueta GCM Base64'=>base64_encode($tag)];
 }
 if ($mode==='Sodium') {
  $key=sodium_crypto_secretbox_keygen(); $nonce=random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
  $cipher=sodium_crypto_secretbox($text,$nonce,$key); $plain=sodium_crypto_secretbox_open($cipher,$nonce,$key);
  $bad=$cipher; $bad[0]=chr(ord($bad[0])^1); $reject=sodium_crypto_secretbox_open($bad,$nonce,$key)===false;
  $result=['Algoritmo'=>'XSalsa20-Poly1305','Clave de prueba Base64'=>base64_encode($key),'Nonce Base64'=>base64_encode($nonce),'Cifrado Base64'=>base64_encode($cipher),'Descifrado'=>$plain,'Alteración'=>$reject?'RECHAZADA: autenticación fallida':'ERROR'];
  sodium_memzero($key); return $result;
 }
 throw new InvalidArgumentException('Ejemplo no reconocido');
}
