<?php
	$pagina = $_GET['pagina'];
	if($pagina >= 2){
		$paginaLink = $pagina - 1;
		$paginaLink .= 0;
		$url = "https://pokeapi.co/api/v2/pokemon?limit=10&offset=" . $paginaLink;
	}else{
		$url = "https://pokeapi.co/api/v2/pokemon?limit=10";
	}
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);	
	$resultado = json_decode(curl_exec($ch));
	
	$pokemonsArray = [];
	foreach($resultado->results as $pokemon){
		array_push($pokemonsArray, $pokemon->url);
	}
?>