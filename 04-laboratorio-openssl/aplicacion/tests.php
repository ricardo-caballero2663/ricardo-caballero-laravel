<?php
require __DIR__.'/crypto.php'; $_SESSION=[]; $n=0;
function test(bool $ok,string $name): void {global $n; if(!$ok) throw new RuntimeException('FALLO: '.$name); ++$n; echo "OK $n - $name\n";}
$msg='Ricardo Caballero - datos de prueba';
$r=executeLab('firma7',$msg,$msg,'Ricardo Caballero'); test(str_starts_with($r['Verificación'],'VÁLIDA'),'RSA: firma válida');
$r=executeLab('firma7',$msg,$msg.' alterado','Ricardo Caballero');test(str_starts_with($r['Verificación'],'INVÁLIDA'),'RSA: rechaza mensaje alterado');
$r=executeLab('firmaOtra',$msg,$msg,'Ricardo Caballero');test(str_contains($r['Certificado X.509 PEM'],'BEGIN CERTIFICATE'),'Genera certificado X.509');
test(openssl_x509_check_private_key($_SESSION['demo_cert'],$_SESSION['demo_private']),'Certificado corresponde a clave privada');
$r=executeLab('FirmaMensaje',$msg,$msg,'Ricardo Caballero');test(str_starts_with($r['Verificación'],'VÁLIDA'),'FirmaMensaje: certificado valida firma');
$r=executeLab('FirmaMensaje',$msg,'alterado','Ricardo Caballero');test(str_starts_with($r['Verificación'],'INVÁLIDA'),'FirmaMensaje: rechaza alteración');
$r=executeLab('Encriptacion',$msg,$msg,'Ricardo Caballero');test($r['Descifrado']===$msg,'AES-CBC: recupera texto');test(str_contains($r['Mejora AES-256-GCM'],'RECHAZADA'),'AES-GCM: rechaza alteración');
$r=executeLab('Sodium',$msg,$msg,'Ricardo Caballero');test($r['Descifrado']===$msg,'Sodium: recupera texto');test(str_contains($r['Alteración'],'RECHAZADA'),'Sodium: rechaza alteración');
try {executeLab('Sodium','','','Ricardo');test(false,'Vacío');}catch(InvalidArgumentException $e){test(true,'Rechaza mensaje vacío');}
echo "TOTAL: $n pruebas correctas\n";
