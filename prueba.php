<?php
require 'vendor/autoload.php';
include ('simple_html_dom.php');
use Goutte\Client;
$client=new Client();

$data=recupera_links($client, "https://listado.mercadolibre.com.mx/xiaomi#D[A:xiaomi]");
foreach ($data as $valor) {
    descargar_imagen($valor,nombre($valor));

}


function nombre($url){
    $cortar=explode("https://http2.mlstatic.com/D_NQ_NP_",$url);
    return $cortar[1];
}
function connexion_pagina(Client $client, $url, $op){
    $peticion=$client->request("GET",$url);
    if($op==1){
       return $contenido=$peticion->html(); 
    }else if($op==2){
          $contenido=$peticion->html(); 
          return $html=str_get_html($contenido);
    }
}

function recupera_links(Client $client,$url){
    $content=connexion_pagina($client,$url,1);
    $images;
    $img="https://http2.mlstatic.com/D_NQ_NP_";
while(strpos($content, $img)){
    $possible_url = substr($content, strpos($content, $img));
    $pos_final = strpos($possible_url, '"');
    $pos2_final = strpos($possible_url, "'");
    if($pos2_final > 0 && $pos2_final < $pos_final){
        $pos_final = $pos2_final;
    }
    $possible_url = substr($possible_url, 0, $pos_final);
    
    $content = substr($content, strpos($content, $img) + 1);
     $images[]= $possible_url;
}
return $images;

}

function descargar_imagen($url, $nombre){
  
// Ruta local donde deseas guardar la imagen descargada
$ruta_local = 'prueba/'.$nombre;

// Crear un contexto de flujo (stream context) con verificación de SSL deshabilitada
$context = stream_context_create([
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
]);

// Descargar la imagen desde la URL con verificación de SSL deshabilitada
$contenido_imagen = file_get_contents($url, false, $context);

if ($contenido_imagen !== false) {
    // Guardar el contenido de la imagen en un archivo local
    if (file_put_contents($ruta_local, $contenido_imagen) !== false) {
        echo 'La imagen se ha descargado correctamente.';
    } else {
        echo 'No se pudo guardar la imagen en el archivo local.';
    }
} else {
    echo 'No se pudo obtener el contenido de la imagen desde la URL.';
}

}