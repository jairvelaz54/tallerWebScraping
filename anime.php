<?php
require 'vendor/autoload.php';
include ('simple_html_dom.php');
use Goutte\Client;
$client=new Client();
$html=connexion_pagina($client,"https://jkanime.net/directorio/",2);
$content=connexion_pagina($client,"https://jkanime.net/directorio/",1);
$d=extraer_titles($html);
$p=extraer_descrip($html);
$i=extraer_image($html);
$i2=extraer_image_recorrido($content);
var_dump($p);
var_dump($d);
var_dump($i);
var_dump($i2);

function connexion_pagina(Client $client, $url, $op){
    $peticion=$client->request("GET",$url);
    if($op==1){
       return $contenido=$peticion->html(); 
    }else if($op==2){
          $contenido=$peticion->html(); 
          return $html=str_get_html($contenido);
    }
}


function extraer_titles($html){
    $resul = array();  // Initialize $resul as an empty array
$custom_item_elements = $html->find('h5.card-title');

foreach ($custom_item_elements as $custom_item_element) {
    $episode_element = $custom_item_element->find('a', 0);
    if ($episode_element) {
         $resul[] = $episode_element->plaintext;
    }
}
return $resul;
}

function extraer_descrip($html){
    $resultado=array();
    $descripcion=$html->find('p.card-text.synopsis');
    foreach($descripcion as $valor){
            $resultado[]=$valor->plaintext;
    }
    return $resultado;
}


function extraer_image($html){
    $imagenes=array();
    $imagen=$html->find('img.img-fluid.rounded-start');
    foreach($imagen as $valor){
        $imagenes[]=$valor->src;
    }
    return $imagenes;
}
function extraer_image_recorrido($content){
    $images;
    $img="https://cdn.jkdesu.com/assets/images/animes/image/";
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