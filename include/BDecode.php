<?php
class BDecode{

	function numberdecode($wholefile, $start){
		$ret[0] = 0;
		$offset = $start;

		// Funky handling of negative numbers and zero
		$negative = false;
		if ($wholefile[$offset] == '-'){
			$negative = true;
			$offset++;
		}
		if ($wholefile[$offset] == '0'){
			$offset++;
			if ($negative)
			return array(false);
			if ($wholefile[$offset] == ':' || $wholefile[$offset] == 'e'){
				$offset++;
				$ret[0] = 0;
				$ret[1] = $offset;
				return $ret;
			}
			return array(false);
		}
		while (true){
			if ($wholefile[$offset] >= '0' && $wholefile[$offset] <= '9'){
				$ret[0] *= 10;
				$ret[0] += ord($wholefile[$offset]) - ord("0");
				$offset++;
			}elseif ($wholefile[$offset] == 'e' || $wholefile[$offset] == ':'){
				$ret[1] = $offset+1;
				if ($negative){
					if ($ret[0] == 0)
					return array(false);
					$ret[0] =- $ret[0];
				}
				return $ret;
			}
			else
			return array(false);
		}
	}

	function decodeEntry($wholefile, $offset=0){
		if ($wholefile[$offset] == 'd')
		return $this->decodeDict($wholefile, $offset);
		if ($wholefile[$offset] == 'l')
		return $this->decodelist($wholefile, $offset);
		if ($wholefile[$offset] == "i"){
			$offset++;
			return $this->numberdecode($wholefile, $offset);
		}
		$info = $this->numberdecode($wholefile, $offset);
		if ($info[0] === false)
		return array(false);
		$ret[0] = substr($wholefile, $info[1], $info[0]);
		$ret[1] = $info[1]+strlen($ret[0]);
		return $ret;
	}

	function decodeList($wholefile, $start){
		$offset = $start+1;
		$i = 0;
		if ($wholefile[$start] != 'l')
		return array(false);
		$ret = array();
		while (true){
			if ($wholefile[$offset] == 'e')
			break;
			$value = $this->decodeEntry($wholefile, $offset);
			if ($value[0] === false)
			return array(false);
			$ret[$i] = $value[0];
			$offset = $value[1];
			$i ++;
		}
		$final[0] = $ret;
		$final[1] = $offset+1;
		return $final;
	}

	// Tries to construct an array
	function decodeDict($wholefile, $start=0){
		$offset = $start;
		if ($wholefile[$offset] == 'l')
		return $this->decodeList($wholefile, $start);
		if ($wholefile[$offset] != 'd')
		return false;
		$ret = array();
		$offset++;
		while (true){
			if ($wholefile[$offset] == 'e'){
				$offset++;
				break;
			}
			$left = $this->decodeEntry($wholefile, $offset);
			if (!$left[0])
			return false;
			$offset = $left[1];
			if ($wholefile[$offset] == 'd'){
				$value = $this->decodedict($wholefile, $offset);
				if (!$value[0])
				return false;
				$ret[addslashes($left[0])] = $value[0];
				$offset= $value[1];
				continue;
			}elseif ($wholefile[$offset] == 'l'){
				$value = $this->decodeList($wholefile, $offset);
				if(!$value[0] && is_bool($value[0]))
				return false;
				$ret[addslashes($left[0])] = $value[0];
				$offset = $value[1];
			}else{
				$value = $this->decodeEntry($wholefile, $offset);
				if ($value[0] === false)
				return false;
				$ret[addslashes($left[0])] = $value[0];
				$offset = $value[1];
			}
		}
		if (empty($ret))
		$final[0] = true;
		else
		$final[0] = $ret;
		$final[1] = $offset;
		return $final;
	}
}

function BDecode($wholefile){
	$decoder = new BDecode;
	$return = $decoder->decodeEntry($wholefile);
	return $return[0];
}
?>