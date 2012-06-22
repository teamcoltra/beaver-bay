<?php
Class BEncode{

	public static function &decode( &$raw, &$offset=0 )
    {   
        if ( $offset >= strlen( $raw ) )
        {
            return new BEncode_Error( "Decoder exceeded max length." ) ;
        }
        
        $char = $raw[$offset];
        switch ( $char )
        {
            case 'i':
                $int = new BEncode_Int();
                $int->decode( $raw, $offset );
                return $int;
                
            case 'd':
                $dict = new BEncode_Dictionary();

                if ( $check = $dict->decode( $raw, $offset ) )
                {
                    return $check;
                }
                return $dict;
                
            case 'l':
                $list = new BEncode_List();
                $list->decode( $raw, $offset );
                return $list;
                
            case 'e':
                return new BEncode_End();
                
            case '0':
            case is_numeric( $char ):
                $str = new BEncode_String();
                $str->decode( $raw, $offset );
                return $str;

            default:
                return new BEncode_Error( "Decoder encountered unknown char '$char' at offset $offset." );
        }
    }

	function makeSorted($array){
		$i = 0;
		if (empty($array))
		return $array;
		foreach($array as $key => $value)
		$keys[$i++] = stripslashes($key);
		sort($keys);
		for ($i=0 ; isset($keys[$i]); $i++)
		$return[addslashes($keys[$i])] = $array[addslashes($keys[$i])];
		return $return;
	}


	function encodeEntry($entry, &$fd, $unstrip = false){
		if (is_bool($entry)){
			$fd .= "de";
			return;
		}
		if (is_int($entry) || is_float($entry)){
			$fd .= "i".$entry."e";
			return;
		}
		if ($unstrip)
		$myentry = stripslashes($entry);
		else
		$myentry = $entry;
		$length = strlen($myentry);
		$fd .= $length.":".$myentry;
		return;
	}

	// Encodes lists
	function encodeList($array, &$fd){
		$fd .= "l";
		if (empty($array)){
			$fd .= "e";
			return;
		}
		for ($i = 0; isset($array[$i]); $i++)
		$this->decideEncode($array[$i], $fd);
		$fd .= "e";
	}

	function decideEncode($unknown, &$fd){
		if (is_array($unknown)){
			if (isset($unknown[0]) || empty($unknown))
			return $this->encodeList($unknown, $fd);
			else
			return $this->encodeDict($unknown, $fd);
		}
		$this->encodeEntry($unknown, $fd);
	}

	function encodeDict($array, &$fd){
		$fd .= "d";
		if (is_bool($array)){
			$fd .= "e";
			return;
		}
		$newarray = $this->makeSorted($array);
		foreach($newarray as $left => $right){
			$this->encodeEntry($left, $fd, true);
			$this->decideEncode($right, $fd);
		}
		$fd .= "e";
		return;
	}
}

function BEncode($array){
	$string = "";
	$encoder = new BEncode;
	$encoder->decideEncode($array, $string);
	return $string;
}


?>