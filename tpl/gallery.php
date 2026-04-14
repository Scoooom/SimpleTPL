<?php
$__output .= <<<end
<table class="table  table-striped  table-dark dark" id="galleryMons">
  <thead>
    <tr>
      <th scope="col">Sprite</th>
      <th scope="col">Name</th>
      <th scope="col">Rating</th>
      <th scope="col">Creator</th>
	  <th scope="col">Glitch Of</th>
      <th scope="col">Primary Type</th>
	  <th scope="col">Secondary Type</th>
	  <th scope="col">View</th>
	  <th scope="col">Download</th>
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
			  <form action="/g:%%lname%%:%%id%%.html">
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
	  <td>%%rating%%</td>
      <td>%%userProf%%</td>
      <td>%%ogMon%%</td>
      <td><img src="/img/types/%%tOne%%.png" /></td>
      <td><img src="/img/types/%%tTwo%%.png" /></td>
	  <td><form action="/g:%%name%%:%%id%%.html"><input class="form-control" type="submit" value="View"  /></form></td>
	  <td><form action="/d:%%id%%.html"><input class="form-control" type="submit" value="Download"  /></form></td>
    </tr>
end;


$glitches = \Glitches\Glitch::LoadBy();

foreach($glitches as $glitch) {
	$mon2 = json_decode($glitch->json_data);
	$user = new \Users\Users($glitch->created_by);
	$typeOne = $mon2->primaryType;
	$typeTwo = $mon2->secondaryType;
	$ogMon = \Pokemon\Pokemon::getMon($mon2->speciesId);
	
	$tmp = str_replace(":%%name%%:",':'.urlencode(str_replace(" ","",$glitch->name)).':',$k);
	$tmp = str_replace("%%name%%",$glitch->name,$tmp);
	$tmp = str_replace("%%front%%","/front:".$glitch->id.".png",$tmp);
	$tmp = str_replace("%%rating%%",$glitch->getRating(),$tmp);

	$tmp = str_replace("%%tOne%%",$typeOne,$tmp);
	$tmp = str_replace("%%tTwo%%",$typeTwo,$tmp);
	$tmp = str_replace("%%ogMon%%",ucwords(str_replace("-",' ',$ogMon->name)),$tmp);
	$tmp = str_replace("%%name%%",$glitch->name,$tmp);
	$tmp = str_replace("%%id%%",$glitch->id,$tmp);
	$tmp = str_replace("%%userProf%%",$user->getLink(),$tmp);
	

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
      "order": [[ 2, "desc" ]]
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
