<?php
$__output .= <<<end
<table class="table  table-striped  table-dark dark" id="galleryMons">
  <thead>
    <tr>
      <th scope="col">Sprite</th>
      <th scope="col">Name</th>
	  <th scope="col">Glitch Of</th>
      <th scope="col">Primary Type</th>
	  <th scope="col">Secondary Type</th>
	  <th scope="col">View</th>
    </tr>
  </thead>
  <tbody>
end;
/*
$k = <<<end
  <section>
    <div class="row center">
      <div class="">
        <div class="card ">
          <div class="card-body text-center">
            <img src="%%front%%" alt="avatar"
              class="rounded-circle img-fluid" style="width: 150px;">		  
			<h5 class="my-3">%%name%%</h5>
            <p class="text-muted mb-1">Created By: %%userProf%%</p>
            <p class="text-muted mb-4">Original Form: %%ogMon%%</p>			
            <div class="d-flex justify-content-center mb-2">
              <img src="/img/types/%%tOne%%.png" />
              <img src="/img/types/%%tTwo%%.png"/>
            </div>
            <div class="d-flex justify-content-center mb-2">
			  <form action="/g:%%name%%:%%id%%.html">
          <input class="form-control" type="submit" value="View"  />
            </div>
          </div>
        </div>
	</section>

end;
*/
$k = <<<end
    <tr>
      <th scope="row"><img src="%%front%%" alt="avatar"
              class="rounded-circle img-fluid" style="width: 64px;"></th>
      <td>%%name%%</td>
      <td>%%ogMon%%</td>
      <td><img src="/img/types/%%tOne%%.png" /></td>
      <td>%%typeTwo%%</td>
	  <td><form action="/smittyForm:%%name%%.html" method="get"><input class="form-control" type="submit" value="View"  /></form></td>
    </tr>
end;

define('GPATH','/home/void/pokevoid-main/./public/images/pokemon/glitch/');
$glitches = \Glitches\BuiltIn::SmittyFormLoad();
// die(code(print_r($glitches,1)));
foreach($glitches as $glitch) {
	$u = '<img src="/img/types/%%tTwo%%.png" />';
	$mon2 = $glitch;
	$typeOne = $mon2->type1;
	$typeTwo = $mon2->type2;
    $og = explode(",",$mon2->ogMon);
	$mons = "";
	foreach($og as $ogMonId) {
		$ogMon = \Pokemon\Pokemon::getMon($ogMonId);
        $mons .= ucwords(str_replace("-",' ',$ogMon->name)).", ";
	}
	$front = "/cFront:".$glitch->name.".png";//"data:image/png;base64,".base64_encode(file_get_contents(GPATH.strtolower($glitch->name).".png"));
	$mons = trim(trim($mons),",");
	$tmp = str_replace(":%%name%%:",':'.str_replace(" ","",$glitch->name).':',$k);
	$tmp = str_replace("%%name%%",$glitch->name,$tmp);
	$tmp = str_replace("%%front%%",$front,$tmp);

	$tmp = str_replace("%%tOne%%",$typeOne,$tmp);
	$u = str_replace("%%tTwo%%",$typeTwo,$u);
	if (!empty($mon2->type2)) 
    	$tmp = str_replace("%%typeTwo%%",$u,$tmp);
	else
		$tmp = str_replace("%%typeTwo%%","None",$tmp);
	$tmp = str_replace("%%ogMon%%",$mons,$tmp);
	$tmp = str_replace("%%name%%",$glitch->name,$tmp);
	$tmp = str_replace("%%id%%",$glitch->id,$tmp);
	

	$__output .= "\n".$tmp;
}


$__output .= <<<end

  </tbody>
</table>

<script type="text/javascript">
/* */
  $(document).ready(function() {
    $("#galleryMons").DataTable({
	  "paging": 1,
	  "stateSave": 0,
	  "searching": 1,
      "order": [[ 1, "asc" ]]
    });
  });
/* */
</script>  
<style type="text/css">
table.dataTable tbody tr {
    background-color: #343a40;
}
</style>
end;
