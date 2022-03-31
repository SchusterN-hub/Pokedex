<?php
	include_once("conectaApi.php");
	$contaListagem;
	$contaCartao;
?>
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pokédex - Nicolas Schuster</title>
    <link rel="stylesheet" href="src/css/reset.css">
    <link rel="stylesheet" href="src/css/global.css">
    <link rel="stylesheet" href="src/css/cartao.css">
    <link rel="stylesheet" href="src/css/listagem.css">
    <link rel="stylesheet" href="src/css/responsivo.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;800&display=swap" rel="stylesheet">
  </head>
  <body>
    <main>
      <div class="pokedex">
        <div class="cartoes-pokemon">
			<?php
				foreach($pokemonsArray as $pokemonUrl){
					$url = $pokemonUrl	;
					$chPokemon = curl_init($url);
					curl_setopt($chPokemon, CURLOPT_SSL_VERIFYPEER, FALSE);
					curl_setopt($chPokemon, CURLOPT_RETURNTRANSFER, TRUE);	
					$resultado = json_decode(curl_exec($chPokemon));
					$imagemLink = $resultado->sprites->other->home->front_default;
					$nomePokemon = $resultado->name;
					$idPokemon = $resultado->id;
					$tiposPokemon = $resultado->types;
					$statusPokemon = $resultado->stats;
					$habilidadesPokemon = $resultado->abilities;
					$somaStatus = $statusPokemon[0]->base_stat + $statusPokemon[1]->base_stat + $statusPokemon[2]->base_stat + $statusPokemon[3]->base_stat + $statusPokemon[4]->base_stat + 	$statusPokemon[5]->base_stat;
						// echo "<pre>";
							// var_dump($statusPokemon);
						// echo "</pre>";
					$tipoPokemon = [];
						foreach($tiposPokemon as $tipo){
							array_push($tipoPokemon, $tipo->type->name);
						}
			?>
          <div class="cartao-pokemon <?= $tipoPokemon[0];?>-type <?php if($contaCartao == 0) {echo "aberto";}?>" id="cartao-<?= $nomePokemon; ?>">
            <div class="cartao-topo">
              <div class="detalhes">
                <h2 class="nome"><?= $nomePokemon; ?></h2>
                <span>#<?= $idPokemon; ?></span>
              </div>
			  <?php
				foreach($tipoPokemon as $tipo){
			  ?>
              <span class="tipo"><?= $tipo;?></span>
			  <?php
					}
			  ?>
              <div class="cartao-imagem">
                <img src="<?php echo $imagemLink ?>" alt="<?= $nomePokemon; ?>" />
              </div>
            </div>
            <div class="cartao-informacoes">
              <div class="status">
                <h3>Base status</h3>
                <ul>
					<?php foreach($statusPokemon as $status){ ?>
						<li><?php echo $status->stat->name; ?>: <?php echo $status->base_stat; ?></li>
					<?php } ?>
                  <li>Total: <?= $somaStatus;?>
				  </li>
                </ul>
              </div>
              <div class="habilidades">
                <h3>Abilities</h3>
                <ul>
					<?php foreach($habilidadesPokemon as $habilidade){ ?>
						<li><?php echo $habilidade->ability->name; ?></li>
					<?php } ?>
                </ul>
              </div>
            </div>
          </div>
		<?
			$contaCartao++;
			}
		?>
        </div>

        <nav class="listagem">
          <ul>
			<?php
				foreach($pokemonsArray as $pokemonUrl){
					$url = $pokemonUrl	;
					$chPokemon = curl_init($url);
					curl_setopt($chPokemon, CURLOPT_SSL_VERIFYPEER, FALSE);
					curl_setopt($chPokemon, CURLOPT_RETURNTRANSFER, TRUE);	
					$resultado = json_decode(curl_exec($chPokemon));
					$imagemLink = $resultado->sprites->other->home->front_default;
					// echo "<p>Nome: " . $resultado->name . "</p>";
					
					// echo "<pre>";
						// var_dump($resultado);
					// echo "</pre>";
				// }
				// exit
			?>
					<li class="pokemon  <?php if($contaListagem == 0) {echo "ativo";}?>" id="<?= $resultado->name?>">
					  <img src="<?php echo $imagemLink ?>" alt="imagem <?= $resultado->name?>" />
					  <span><?= $resultado->name?></span>
					</li>
			<?php
					$contaListagem++;
					}
			?>
          </ul>
        </nav>
      </div>
	  <div class="navegacaoDesk hideOnMobile">
		<?php
				if($_GET['pagina'] == null || $pagina <= 1){
					$linkPaginaAnterior = "#";
					$desativaAnterior = "style='pointer-events: none; opacity: 0.5;'";
				}else{
					$paginaAnterior = $pagina - 1;
					$linkPaginaAnterior = "?pagina=" . $paginaAnterior;
				}
		?>
		<a href="<?= $linkPaginaAnterior ?>" class="navegacaoDesk__esquerda" <?= $desativaAnterior ?>>
			<i class="fa-solid fa-chevron-left"></i>
		</a>
		<?php
				if($_GET['pagina'] == null){
					// echo "<script>alert('página null');</script>";
					$linkProximaPagina = "?pagina=2";
				}elseif(count($pokemonsArray) >= 10){
					$proximaPagina = $pagina + 1;
					$linkProximaPagina = "?pagina=" . $proximaPagina;
				}else{
					$linkProximaPagina = "#";
					$desativaProxima = "style='pointer-events: none; opacity: 0.5;'";
				}
		?>
		<a href="<?= $linkProximaPagina ?>" class="navegacaoDesk__direita" <?= $desativaProxima ?>>
			<i class="fa-solid fa-chevron-right"></i>
		</a>
      </div>
	  <div class="navegacaoMobile hideOnDesk">
	  	<a href="<?= $linkPaginaAnterior ?>" class="navegacaoMobile__esquerda" <?= $desativaAnterior ?>>
			<i class="fa-solid fa-chevron-left"></i>
		</a>
		<p>Páginas
		</p>
		<a href="<?= $linkProximaPagina ?>" class="navegacaoMobile__direita" <?= $desativaProxima ?>>
			<i class="fa-solid fa-chevron-right"></i>
		</a>
	  </div>
    </main>

    <script src="src/js/index.js"></script>
	<script src="https://kit.fontawesome.com/2b3b7fb7e3.js" crossorigin="anonymous"></script>
  </body>
</html>
