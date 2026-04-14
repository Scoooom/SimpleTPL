<?php
$__output = <<<end
<section class="vh-100" style="background-color: #508bfc;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">
		  {$ERR}
            <h3 class="mb-5">Sign in</h3>


			        <form class="form-inline my-2 my-md-0" method="post" action="login.html">

		<input type="hidden" name="loginkey" value="1" /><input type="hidden" name="returnURL" value="{$_SERVER['REQUEST_URI']}" />

            <input data-mdb-button-init data-mdb-ripple-init class="btn btn-lg btn-block btn-primary" style="background-color: #dd4b39;"
              type="submit" value="Sign in with Discord" /></form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
end;

