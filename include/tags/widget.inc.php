<?php 

	Class widget extends taglibrary {

		function injectStyle() {}

		
		
		function select($name, $data, $pars) {

			global $mysqli;

			$table = $pars['table'];
			$text = $pars['value'];
			$key = $pars['key'];
			
			$buffer ="";
			$result = $mysqli->query("
				SELECT 
					{$table}.{$text} AS {$table}_{$text},
					{$table}.{$key} AS {$table}_{$key}
				FROM 
					{$table}
			");
			while ($item = $result->fetch_assoc()) {
				$buffer .= "<option value=\"".$item["{$table}_{$key}"]."\">".$item["{$table}_{$text}"]."</option>\n";	
			}

			return $buffer;

		}


	}

?>