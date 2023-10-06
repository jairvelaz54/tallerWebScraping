<?php
require 'vendor/autoload.php';
include ('simple_html_dom.php');
use Goutte\Client;
$client= new Client; 
$peticion=$client->request("GET","https://celaya.tecnm.mx/");
// PEDIR EL CONTENIDO
$contenido=$peticion->html();

// SOLO LA ESCTRUCTURA EN HTML
$html=str_get_html($contenido);
$title;
$title_element = $html->find('div.et_pb_blurb_content', 0);

if ($title_element) {
    echo $title = $title_element->plaintext;
    
}
