<?php

class jsonAPI {
	var $status,$headers;
	
	function jsonAPI(){
		$this->headers		= array('Accept: application/json','Content-Type: application/json');
	}
	
	function exec_curl($auth,$url,$method='GET',$data=null) {
		$handle = curl_init();
		curl_setopt($handle, CURLOPT_URL, $url);
		curl_setopt($handle, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($handle, CURLOPT_HEADER, 0);
		curl_setopt($handle, CURLOPT_USERPWD, $auth);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

		switch($method){
		  case 'GET':
		    break;
		  case 'POST':
		    curl_setopt($handle, CURLOPT_POST, true);
		    curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
		    break;
		  case 'PUT':
		    curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'PUT');
		    curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
		    break;
		  case 'DELETE':
		    curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'DELETE');
		    break;
		}

		$response		= curl_exec($handle);
		$this->status	= curl_getinfo($handle, CURLINFO_HTTP_CODE);

		if($response===FALSE) {
			$result = "<strong>Code:</strong> ".curl_errno($handle)."<br/><strong>Message:</strong> ".curl_error($handle);
			curl_close($handle);
			return $result;
		}else {
			curl_close($handle);
			return $response;
		}
	}
	
	function jsonPre($json) {
		$result      = '';
		$pos         = 0;
		$strLen      = strlen($json);
		#$indentStr   = '  ';
		$indentStr   = "&nbsp;&nbsp;&nbsp;&nbsp;";
		$newLine     = "\n";
		$prevChar    = '';
		$outOfQuotes = true;

		for ($i=0; $i<=$strLen; $i++) {

			// Grab the next character in the string.
			$char = substr($json, $i, 1);

			// Are we inside a quoted string?
			if ($char == '"' && $prevChar != '\\') {
				$outOfQuotes = !$outOfQuotes;
			
			// If this character is the end of an element, 
			// output a new line and indent the next line.
			} else if(($char == '}' || $char == ']') && $outOfQuotes) {
				$result .= $newLine;
				$pos --;
				for ($j=0; $j<$pos; $j++) {
					$result .= $indentStr;
				}
			}
			
			// Add the character to the result string.
			$result .= $char;

			// If the last character was the beginning of an element, 
			// output a new line and indent the next line.
			if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
				$result .= $newLine;
				if ($char == '{' || $char == '[') {
					$pos ++;
				}
				
				for ($j = 0; $j < $pos; $j++) {
					$result .= $indentStr;
				}
			}
			
			$prevChar = $char;
		}

		return $result;
	}

}

?>
