<?php
$showGacha = 1;
 $k = <<<end
        <form class="form-inline my-2 my-md-0" method="post" action="downloadAll.html">
          <input class="form-control" type="submit" value="Download All" placeholder="Download All" />
        </form>
<p>&nbsp;</p>
end;

$smittyForms = "";

	$smittyForms = "\n".'          <a class="dropdown-item" href="/gallerySmitty.html">SMITTY Pokemon</a><a class="dropdown-item" href="/gallerySmittyForm.html">SMITTY Forms</a>';


$nav = <<<end
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="/">Home</a>
          </li>
		  
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Pokemon Forms
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="./gallery.html">Mod Glitch Forms`</a>
          <a class="dropdown-item" href="./galleryCore.html">Core Glitches</a>{$smittyForms}
        </div>
      </li>
	  <li class="nav-item">
		<a class="nav-link" href="/gacha.html">Gacha Calandar</a>
	  </li>
	  <li class="nav-item">
		<a class="nav-link" href="/faq.html">FAQs</a>
	  </li>
	  <li class="nav-item">
		<a class="nav-link" href="https://pvoffine.scooom.xyz/">Offline</a>
	  </li>

end;


if (\Discord2\User::isLoggedIn()) {
	$user = \Users\Users::getUser();

	$name = $user->username;	
	$img = "<a href='/u:".$name.".html'><img width='32px' height='32px' style='display: block' class='image-round' src='".$user->getAvatarURL()."' /></a>";
			logMsg("Don't output todo links");

/*
		  <li class="nav-item">
            <a class="nav-link" href="/myGlitches.html">Your Glitches</a>
          </li>
		  <li class="nav-item">
            <a class="nav-link" href="/myFaves.html">Your Liked Glitches</a>
          </li>
*/

	$nav .= <<<end
	
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Account
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/profile.html">Profile</a>
          <a class="dropdown-item" href="./create.html">Upload Glitch</a>
		  <a class="dropdown-item" href="./login.html?logoutkey=1">Logout</a>
		  

</div>
        
      </li>

	  
	</ul>
{$k}
 
        <form class="form-inline my-2 my-md-0" method="post" action="login.html">

	<input type="hidden" name="logoutkey" value="1" /><input type="hidden" name="returnURL" value="/index.html" />
          <input class="form-control" type="submit" value="Logout {$name}" placeholder="Logout" /> <div class="image-wrapper">{$img}</div> 
end;

} else {
		logMsg("Don't output login button");

	
$nav .= <<<end
	</ul>
{$k}
        <form class="form-inline my-2 my-md-0" method="post" action="login.html">

		<input type="hidden" name="loginkey" value="1" /><input type="hidden" name="returnURL" value="{$_SERVER['REQUEST_URI']}" />
          <input class="form-control" type="submit" value="Login" placeholder="Login" />
end;

}
$nav .= <<<end
	
        </form>
        </ul>
      </div>
    </nav>
end;
$__output = $nav;
