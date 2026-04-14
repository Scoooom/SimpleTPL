<?php
namespace Site;
class HTMLTools {
    public static function tSort($table_id,$sort = 0,$order = 'desc',$paging = 0, $stateSave = 0, $searching = 0 ) {
        return <<<end
		<script type="text/javascript">
			$(document).ready(function() {
				$("#{$table_id}").DataTable({
				    "paging": {$paging},
				    "stateSave": {$stateSave},
					"searching": {$searching},
					
"order": [[ {$sort}, "{$order}" ]]
				});
			});
		</script>
end;
    }
}
