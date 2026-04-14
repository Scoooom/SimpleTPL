<?php
$nav = <<<end
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="fal$
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="./">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./points.html">Point Rules</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./podium.html">Podium</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./alltime.html">All Time Stats</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./viewT.html">View Tournaments</a>
          </li>


end;

if (false) {
  $adminLinks = "";
  if (\Login\User::getCurrent()->user_level > 1) {
    $adminLinks .= '            <a class="dropdown-item" href="./manageU.html">Manage Users</a>';
    if (\Login\User::getCurrent()->user_level == 10) $adminLinks .= '           <a class="dropdown-item" href="./newuser.html">Create Admin</a>';
  }

  $nav .= <<<end

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Map Rotation Generator
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="./mapRotation.html">Generate Rotation</a>
          <a class="dropdown-item" href="./mapRotation.html?sub=true">Generate Rotation (w/ Submerged)</a>
          <a class="dropdown-item" href="./mapRotation.html?fun=true">Generate Rotation (w/ Fungle)</a>
        </div>
      </li>

             <li class="nav-item">
            <a class="nav-link" href="./manageT.html">Manage Tournaments</a>
          </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Player Management
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="./newplayer.html">Add Player</a>
          <a class="dropdown-item" href="./addWin.html">Record Win</a>

        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Account
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown2">

            <a class="dropdown-item" href="./changePass.html">Change Password</a>
            <a class="dropdown-item" href="./logout.html">Logout</a>
            {$adminLinks}
            </div>
          </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Mod Management
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="./createMod.html">Create ModPack</a>
          <a class="dropdown-item" href="./createRole.html">Create Role</a>
          <a class="dropdown-item" href="./viewModPacks.html">View ModPacks</a>
          <a class="dropdown-item" href="./managepoints.html">Manage Points</a>
        </div>
      </li>

end;

} else {
   $nav .= <<<end

        <form class="form-inline my-2 my-md-0">
          <input class="form-control" type="text" placeholder="Search">
        </form>
end;
}

$nav .= <<<end
        </ul>
      </div>
    </nav>
end;
$__output = $nav;


