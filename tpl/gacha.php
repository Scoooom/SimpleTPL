<?php
$eHead = <<<end
    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.9.4/p5.js"></script>
    <script src="https://unpkg.com/pokeapi-js-wrapper/dist/index.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.9.4/addons/p5.sound.min.js"></script>
<!--    --
<link rel="stylesheet" type="text/css" href="style.css">  -->
<style type="text/css">
.container canvas#defaultCanvas0 {
    width: inherit !important;
}

.nav .preview-nav {
  display: none !important;
}
</style>
<!-- -->
    <meta charset="utf-8" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.2.0/crypto-js.min.js" integrity="sha512-a+SUDuwNzXDvz4XrIcXHuCf089/iJAoN4lmrXJg18XnduKK6YlDHNRalv4yd1N40OKI80tFidF+rqTFKGPoWFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
end;

define('extraHead',$eHead);
define('CustomTitle','Egg Gacha Calandar');
$__output = <<<end
<div id="gacha">
      <script>
        pokeapi_loaded = false
        if (typeof Pokedex == 'undefined') {
          console.error("PokeAPI didn't connect! Images are unavailable")
        } else {
          P = new Pokedex.Pokedex()
          pokeapi_loaded = true
        }
        special_key = "x0i2O7WRiANTqPmZ"
        egg_seed = 1073741824
      </script>
    <script src="/gacha/pokerogue_data/pokemonData.js"></script>
    <script src="/gacha/phaser-rand.js"></script>
    <script src="/gacha/sketch.js"></script>
</div>
end;
//$__output = '<iframe src="https://editor.p5js.org/scoooooom/full/-T-gCkSVU" title="Gacha Calandar" width="100%" style="height: calc(100vh - 30px);border:none;"></iframe>';

$__output .= '<br /><small>Credit to <a href="https://editor.p5js.org/RedstonewolfX/sketches/">redstonewolf</a> for the base code of the calandar</small>';

