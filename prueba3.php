<?php
require 'vendor/autoload.php';
include ('simple_html_dom.php');
use Goutte\Client;
$client=new Client();

function connexion_pagina(Client $client, $url, $op){
    $peticion=$client->request("GET",$url);
    if($op==1){
       return $contenido=$peticion->html(); 
    }else if($op==2){
          $contenido=$peticion->html(); 
          return $html=str_get_html($contenido);
    }
}

//funciona para agarrar cualquier enlace que se necesite, de cualquier pagina, solo se debe de inidicar la url 
function recupera_links(Client $client,$url){
    $content=connexion_pagina($client,$url,1);
    $images;
    $img="https://mp3teca.app/mp3/";
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

function recuperar_canciones(Client $client, $url){
    $content=connexion_pagina($client,$url,1);
    $images;
    $img="https://mp3teca.app/-/mp3/128/";//va a regresar la cancion 
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
//var_dump muestra todo el arreglo, sin hacer for 
//var_dump (recupera_links ($client,"https://mp3teca.app/?s=yandel"));
$prueba=recupera_links ($client,"https://mp3teca.app/?s=rosalia+candy");


//connexion_pagina($client,$prueba[7],1); //es 0 porque es la posicion que queremos tomar 
//echo count ($prueba);    SE MANDA IMPRIMIR EL ARREGLO DE ELEMENTOS 

$salvacion=recuperar_canciones($client,$prueba[0]);
echo '<audio  src="'.$salvacion[0].'"  controls autoplay></audio>';