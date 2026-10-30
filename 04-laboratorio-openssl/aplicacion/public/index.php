<?php
declare(strict_types=1);
session_start(['cookie_httponly'=>true,'cookie_samesite'=>'Strict']);
require dirname(__DIR__).'/crypto.php';
header('Cache-Control: no-store');
function e(string $s): string {return htmlspecialchars($s,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');}
$modes=['firma7'=>'Firma RSA','firmaOtra'=>'Certificado X.509','FirmaMensaje'=>'Firma con certificado','Encriptacion'=>'Cifrado OpenSSL','Sodium'=>'Cifrado Sodium'];
$mode=$_GET['ejemplo']??'firma7'; if(!isset($modes[$mode])) {$mode='firma7';}
$_SESSION['csrf']??=bin2hex(random_bytes(32));
$text=$_POST['mensaje']??'Mensaje de prueba de Ricardo Caballero - grupo 1S3122';
$check=$_POST['verificar']??$text; $name=$_POST['nombre']??'Ricardo Caballero'; $result=[]; $error='';
if($_SERVER['REQUEST_METHOD']==='POST') try {
 if(!hash_equals($_SESSION['csrf'],$_POST['csrf']??'')) throw new RuntimeException('Recarga el formulario.');
 $result=executeLab($mode,$text,$check,$name);
} catch(Throwable $ex) {$error=$ex->getMessage();}
?><!doctype html><html lang="es"><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?=e($mode)?> | Laboratorio OpenSSL</title>
<style>body{margin:0;background:#edf2f8;color:#18304b;font:16px system-ui}header{background:#174b80;color:white;padding:28px 7%}h1{margin:6px 0;font-size:30px}header p{margin:6px 0}main{max-width:1100px;margin:24px auto;padding:0 20px}nav{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:22px}nav a{padding:10px 16px;background:white;color:#174b80;border-radius:6px;text-decoration:none}nav a.active{background:#174b80;color:white}section{background:white;padding:24px;margin-bottom:18px;border-radius:10px}label{display:block;font-weight:600;margin:12px 0 6px}textarea,input{box-sizing:border-box;width:100%;padding:10px;border:1px solid #adbdcf;border-radius:5px;font:15px system-ui}textarea{height:70px}button{background:#174b80;color:white;border:0;padding:12px 24px;border-radius:5px;margin-top:16px;font-weight:bold}pre{white-space:pre-wrap;overflow-wrap:anywhere;font:12px Consolas,monospace;background:#f1f5fa;padding:14px;border-radius:5px}h2{font-size:22px}h3{font-size:16px;margin-bottom:6px}.info{font-size:13px;color:#526780}.error{color:#a31e29;border:1px solid #a31e29}.result{border-left:5px solid #197650}</style>
<header><p>DESARROLLO WEB · UTP · 1S3122</p><h1>Seguridad de datos con PHP</h1><p>Ricardo Caballero · OpenSSL y Sodium</p></header><main><nav><?php foreach($modes as $id=>$label):?><a class="<?=$mode===$id?'active':''?>" href="?ejemplo=<?=$id?>"><?=e($id)?></a><?php endforeach?></nav>
<section><h2><?=e($mode.' · '.$modes[$mode])?></h2><p class="info">Entorno educativo local. Se usan mensajes y claves desechables de prueba. Los certificados son autofirmados y no acreditan una identidad externa.</p><form method="post"><input type="hidden" name="csrf" value="<?=e($_SESSION['csrf'])?>"><label for="mensaje">Mensaje original</label><textarea id="mensaje" name="mensaje" maxlength="4000" required><?=e($text)?></textarea><?php if(in_array($mode,['firma7','FirmaMensaje'])):?><label for="verificar">Mensaje que se verificará</label><textarea id="verificar" name="verificar" maxlength="4000" required><?=e($check)?></textarea><?php endif?><?php if($mode==='firmaOtra'):?><label for="nombre">Nombre del titular de prueba</label><input id="nombre" name="nombre" maxlength="64" required value="<?=e($name)?>"><?php endif?><button type="submit">Ejecutar <?=e($mode)?></button></form></section>
<?php if($error):?><section class="error"><?=e($error)?></section><?php endif?><?php if($result):?><section class="result"><h2>Resultados de la ejecución</h2><?php foreach($result as $label=>$value):?><h3><?=e($label)?></h3><pre><?=e((string)$value)?></pre><?php endforeach?></section><?php endif?><p class="info">PHP <?=PHP_VERSION?> · <?=e(OPENSSL_VERSION_TEXT)?> · Sodium <?=extension_loaded('sodium')?SODIUM_LIBRARY_VERSION:'no habilitado'?></p></main></html>
