<?php
require 'vendor/autoload.php';
include ('simple_html_dom.php');
use Goutte\Client;
$client=new Client();
$html=connexion_pagina($client,"https://jkanime.net/directorio/",2);

$d=extraer_titles($html);
$p=extraer_descrip($html);
var_dump($p);
var_dump($d);

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

