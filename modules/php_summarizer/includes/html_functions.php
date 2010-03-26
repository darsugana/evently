<?php

/**
 * @author 
 * @copyright 2008
 */

// 'Stolen' from PHP.net site from http://www.php.net/ord function
function ordUTF8($c, $index = 0, &$bytes = null){
	$len = strlen($c);
	$bytes = 0;
	if ($index >= $len) return false;
	$h = ord($c{$index});
	if ($h <= 0x7F) {
		$bytes = 1; return $h;
	}
	if ($h < 0xC2) return false;
	if ($h <= 0xDF && $index < $len - 1) {
	    $bytes = 2;
		return ($h & 0x1F) <<  6 | (ord($c{$index + 1}) & 0x3F);
	}
	if ($h <= 0xEF && $index < $len - 2) {
		$bytes = 3;
		return ($h & 0x0F) << 12 | (ord($c{$index + 1}) & 0x3F) << 6 | (ord($c{$index + 2}) & 0x3F);
	}
	if ($h <= 0xF4 && $index < $len - 3) {
		$bytes = 4;
		return ($h & 0x0F) << 18 | (ord($c{$index + 1}) & 0x3F) << 12 | (ord($c{$index + 2}) & 0x3F) << 6 | (ord($c{$index + 3}) & 0x3F);
	}
	return false;
}
// -----------------------------------------------------------
/* If you use this function a link-back is welcome. */
// This function will convert some UNICODE characters to their ASCII similars
function normalizeHtml($html){
	$translationTable = array();
	//--
	$translationTable[0x00E1] = "a"; $translationTable[0x00C1] = "A"; $translationTable[0x0102] = "A";
	$translationTable[0x0103] = "a"; $translationTable[0x00E2] = "a"; $translationTable[0x00C2] = "A";
	$translationTable[0x00E0] = "a"; $translationTable[0x00C0] = "A"; $translationTable[0x0100] = "A";
	$translationTable[0x0101] = "a"; $translationTable[0x0104] = "A"; $translationTable[0x0105] = "a";
	$translationTable[0x00E5] = "a"; $translationTable[0x00C5] = "A"; $translationTable[0x212B] = "a";
	$translationTable[0x00E3] = "a"; $translationTable[0x00C3] = "A"; $translationTable[0x00E4] = "a";
	$translationTable[0x00C4] = "A"; $translationTable[0x0106] = "C"; $translationTable[0x0107] = "c";
	$translationTable[0x010C] = "C"; $translationTable[0x010D] = "c"; $translationTable[0x00E7] = "c";
	$translationTable[0x00C7] = "C"; $translationTable[0x0108] = "C"; $translationTable[0x0109] = "c";
	$translationTable[0x010A] = "C"; $translationTable[0x010B] = "c"; $translationTable[0xE07D] = "C";
	$translationTable[0x010E] = "D"; $translationTable[0x010F] = "d"; $translationTable[0xE08E] = "d";
	$translationTable[0x0110] = "D"; $translationTable[0x0111] = "d"; $translationTable[0x00D0] = "E";
	$translationTable[0x00F0] = "e"; $translationTable[0x00C9] = "E"; $translationTable[0x00E9] = "e";
	$translationTable[0x0114] = "E"; $translationTable[0x0115] = "e"; $translationTable[0x011A] = "E";
	$translationTable[0x011B] = "e"; $translationTable[0x00CA] = "E"; $translationTable[0x0116] = "E";
	$translationTable[0x0117] = "e"; $translationTable[0x00C8] = "E"; $translationTable[0x00E8] = "e";
	$translationTable[0x0112] = "E"; $translationTable[0x0113] = "e"; $translationTable[0x0118] = "E";
	$translationTable[0x0119] = "e"; $translationTable[0x00CB] = "E"; $translationTable[0x00EB] = "e";
	$translationTable[0x01F5] = "g"; $translationTable[0x01F4] = "G"; $translationTable[0x011E] = "G";
	$translationTable[0x011F] = "g"; $translationTable[0x0122] = "G"; $translationTable[0x0123] = "g";
	$translationTable[0x011C] = "G"; $translationTable[0x011D] = "g"; $translationTable[0x0120] = "G";
	$translationTable[0x0121] = "g"; $translationTable[0xE0DB] = "g"; $translationTable[0x0124] = "H";
	$translationTable[0x0125] = "h"; $translationTable[0x0126] = "H"; $translationTable[0x0127] = "h";
	$translationTable[0x00CD] = "I"; $translationTable[0x00ED] = "i"; $translationTable[0x012C] = "I";
	$translationTable[0x012D] = "i"; $translationTable[0x00CE] = "I"; $translationTable[0x00EE] = "i";
	$translationTable[0x0130] = "I"; $translationTable[0x00CC] = "I"; $translationTable[0x00EC] = "i";
	$translationTable[0x012A] = "I"; $translationTable[0x012B] = "i"; $translationTable[0x0131] = "i";
	$translationTable[0x012E] = "I"; $translationTable[0x012F] = "i"; $translationTable[0x0128] = "I";
	$translationTable[0x0129] = "i"; $translationTable[0x00CF] = "I"; $translationTable[0x00EF] = "i";
	$translationTable[0x0134] = "J"; $translationTable[0x0135] = "j"; $translationTable[0x0136] = "K";
	$translationTable[0x0137] = "k"; $translationTable[0x0139] = "L"; $translationTable[0x013A] = "l";
	$translationTable[0x013D] = "L"; $translationTable[0x013E] = "l"; $translationTable[0x013B] = "L";
	$translationTable[0x013C] = "l"; $translationTable[0xE118] = "l"; $translationTable[0x0141] = "L";
	$translationTable[0x0142] = "l"; $translationTable[0x0143] = "N"; $translationTable[0x0144] = "n";
	$translationTable[0x0147] = "N"; $translationTable[0x0148] = "n"; $translationTable[0x0145] = "N";
	$translationTable[0x0146] = "n"; $translationTable[0x00D1] = "N"; $translationTable[0x00F1] = "n";
	$translationTable[0x014A] = "E"; $translationTable[0x014B] = "e"; $translationTable[0x00D3] = "O";
	$translationTable[0x00F3] = "o"; $translationTable[0x014F] = "o"; $translationTable[0x014E] = "O";
	$translationTable[0x00D4] = "O"; $translationTable[0x00F4] = "o"; $translationTable[0x00D2] = "O";
	$translationTable[0x00F2] = "o"; $translationTable[0xE157] = "O"; $translationTable[0xE158] = "o";
	$translationTable[0x014C] = "O"; $translationTable[0x014D] = "o"; $translationTable[0x00D8] = "O";
	$translationTable[0x00F8] = "o"; $translationTable[0x00D5] = "O"; $translationTable[0x00F5] = "o";
	$translationTable[0x00D6] = "O"; $translationTable[0x00F6] = "o"; $translationTable[0x00DE] = "T";
	$translationTable[0x00FE] = "t"; $translationTable[0x0154] = "R"; $translationTable[0x0155] = "r";
	$translationTable[0x0158] = "R"; $translationTable[0x0159] = "r"; $translationTable[0x0156] = "R";
	$translationTable[0x0157] = "r"; $translationTable[0xE954] = "R"; $translationTable[0x015A] = "S";
	$translationTable[0x015B] = "s"; $translationTable[0x0160] = "S"; $translationTable[0x0161] = "s";
	$translationTable[0x015E] = "S"; $translationTable[0x015F] = "s"; $translationTable[0x015C] = "s";
	$translationTable[0x015D] = "S"; $translationTable[0xE1D2] = "S"; $translationTable[0xE1D3] = "s";
	$translationTable[0x0164] = "T"; $translationTable[0x0165] = "t"; $translationTable[0x0162] = "T";
	$translationTable[0x0163] = "t"; $translationTable[0x0166] = "T"; $translationTable[0x0167] = "t";
	$translationTable[0xE923] = "t"; $translationTable[0xE927] = "u"; $translationTable[0xE928] = "U";
	$translationTable[0x00DA] = "U"; $translationTable[0x00FA] = "u"; $translationTable[0x016C] = "U";
	$translationTable[0x016D] = "u"; $translationTable[0x00DB] = "U"; $translationTable[0x00FB] = "u";
	$translationTable[0x00D9] = "U"; $translationTable[0x00F9] = "u"; $translationTable[0x016A] = "U";
	$translationTable[0x016B] = "u"; $translationTable[0x0172] = "U"; $translationTable[0x0173] = "u";
	$translationTable[0x016E] = "U"; $translationTable[0x016F] = "u"; $translationTable[0x0168] = "U";
	$translationTable[0x0169] = "u"; $translationTable[0x00DC] = "U"; $translationTable[0x00FC] = "u";
	$translationTable[0x0174] = "W"; $translationTable[0x0175] = "w"; $translationTable[0x00DD] = "Y";
	$translationTable[0x00FD] = "y"; $translationTable[0x0176] = "Y"; $translationTable[0x0177] = "y";
	$translationTable[0x00FF] = "y"; $translationTable[0x0178] = "Y"; $translationTable[0x0179] = "Z";
	$translationTable[0x017A] = "z"; $translationTable[0x017D] = "z"; $translationTable[0x017B] = "Z";
	$translationTable[0x017C] = "z"; $translationTable[0xE953] = "z"; $translationTable[0x1E94] = "Z";
	$translationTable[0x00AB] = "\""; $translationTable[0x00BB] = "\""; $translationTable[0x2039] = "\"";
	$translationTable[0x2040] = "\""; $translationTable[0x2329] = "\""; $translationTable[0x2330] = "\"";
	$translationTable[0x2308] = "["; $translationTable[0x2309] = "]"; $translationTable[0x230A] = "[";
	$translationTable[0x230B] = "]"; $translationTable[0x2018] = "'"; $translationTable[0x2019] = "'";
	$translationTable[0x2020] = "'"; $translationTable[0x201C] = "\""; $translationTable[0x201D] = "\"";
	//-- The previously declared unhtmlentities
	$html = unhtmlentities($html);
	//-- We now begin the conversion
	$ascii_html = "";
	for($i=0;$i<strlen($html);$i++){
		$bytes = 0;
		if(ord($html[$i]) <= (0xFF/2)){
			//-- This is ASCII so we carry on!
			$ascii_html.=$html[$i];
			continue;
		}
		$char = ordUTF8($html,$i,$bytes);
		//-- No length? Funny but let's continue ...
		if(!$bytes){  continue; }
		$i += $bytes-1; // We add bytes-1 as for adds 1 by default!
		if(!isset($translationTable[$char])){
			//-- Not ASCII so we replace it with a space!
			$ascii_html .= " ";
			continue;
		}
		//-- We use the converion table to convert
		$ascii_html .= $translationTable[$char];
	}
	//-- We are ASCII only!
	return $ascii_html;
}

//-- Large tags not needed in content extraction must be dumped!
function stripLargeTags($html){
    $searches = array (
        "/<!\[CDATA\[(.*)\]\]>/si", // Remove CData
        "/<script[^>]*>.*?<\/script>/si", // Strip out javascript
        "/<style[^>]*>.*?<\/style>/si", // Strip out styles
        "/<code[^>]*>.*?<\/code>/si", // Strip out code chunks
        "/<!--.*?-->/s", // Strip comments
         "/<!.*>/Us", // Strip !Tags
         "/<\?.*>/Us" // Strip !Tags
    );
    $replace = array();
    foreach($searches as $search){
        array_push($replace, ''); // Replace all with ''
    } reset($searches);
    $text = preg_replace($searches, $replace, $html);
    return $text;
}

//-- HTML translation table in PHP does not contain all the below.
//-- Found these on the php.net site.
function get_html_translation_table_CP1252() {
    $trans = get_html_translation_table(HTML_ENTITIES);
    $trans[chr(130)] = '&sbquo;';    // Single Low-9 Quotation Mark
    $trans[chr(131)] = '&fnof;';    // Latin Small Letter F With Hook
    $trans[chr(132)] = '&bdquo;';    // Double Low-9 Quotation Mark
    $trans[chr(133)] = '&hellip;';    // Horizontal Ellipsis
    $trans[chr(134)] = '&dagger;';    // Dagger
    $trans[chr(135)] = '&Dagger;';    // Double Dagger
    $trans[chr(136)] = '&circ;';    // Modifier Letter Circumflex Accent
    $trans[chr(137)] = '&permil;';    // Per Mille Sign
    $trans[chr(138)] = '&Scaron;';    // Latin Capital Letter S With Caron
    $trans[chr(139)] = '&lsaquo;';    // Single Left-Pointing Angle Quotation Mark
    $trans[chr(140)] = '&OElig;';    // Latin Capital Ligature OE
    $trans[chr(145)] = '&lsquo;';    // Left Single Quotation Mark
    $trans[chr(146)] = '&rsquo;';    // Right Single Quotation Mark
    $trans[chr(147)] = '&ldquo;';    // Left Double Quotation Mark
    $trans[chr(148)] = '&rdquo;';    // Right Double Quotation Mark
    $trans[chr(149)] = '&bull;';    // Bullet
    $trans[chr(150)] = '&ndash;';    // En Dash
    $trans[chr(151)] = '&mdash;';    // Em Dash
    $trans[chr(152)] = '&tilde;';    // Small Tilde
    $trans[chr(153)] = '&trade;';    // Trade Mark Sign
    $trans[chr(154)] = '&scaron;';    // Latin Small Letter S With Caron
    $trans[chr(155)] = '&rsaquo;';    // Single Right-Pointing Angle Quotation Mark
    $trans[chr(156)] = '&oelig;';    // Latin Small Ligature OE
    $trans[chr(159)] = '&Yuml;';    // Latin Capital Letter Y With Diaeresis
    ksort($trans);
    return $trans;
}
// -----------------------------------------------------------
//-- Function to convert &*; formats to characters.
function unhtmlentities($string){
    // replace numeric entities
    $string = preg_replace('~&#x([0-9a-f]+);~ei', 'chr(hexdec("\\1"))', $string);
    $string = preg_replace('~&#([0-9]+);~e', 'chr("\\1")', $string);
    // replace literal entities
    $trans_tbl = get_html_translation_table_CP1252();
    $trans_tbl = array_flip($trans_tbl);
    return strtr($string, $trans_tbl);
}

function stripTags(
    $html, // The Html To strip
    $stripAttributes =false, // Strip Tag Attributes
    $keepTags =false, // Keep Html Tags
    $stripHtmlChars =true, // Strip Html Chars &*;
    $stripSpaces =true, // Replace Consecutive Spaces With Space
    $stripImages =true, // Replace Images With Alt Values
    $stripAcronyms =true // Replace Acronyms With Title Value
){
    //-- Separate Tags From Text
    $tags2Separate = "div|p|td|li|acronym|img";
    $tags2Separate = preg_split("/[^a-z]/i",$tags2Separate);
    $html = preg_replace("/<(\/?".implode("|",$tags2Separate).")([^>]+)>/i"," <\\1\\2>",$html);
    //-- Remove Images and Replace The With Their Alts
    if($stripImages){
        $html=preg_replace("/<img[^>]+?alt=\"([^\"]*)\"[^>]*>/si","\\1",$html);
    }
    //-- Remove Acronyms and Replace The With Their Titles
    if($stripAcronyms){
        $html=preg_replace("/<acronym.*title=\"([^\"]*)\"[^>]*>.*<\/acronym>/Ui","\\1",$html);
    }
    $text = stripLargeTags($html); // Change Params to keep <code>
    if($stripAttributes){
        //-- We strip attributes here! To overcome XHTML format we take the long way.
        //-- We find all tags and replace them.
        if(preg_match_all("@<[^\s>]+\s.+?>@si", $text, $tags)){
            $tags = $tags[0]; array_unique($tags);
            foreach($tags as $tag){
                if(!strchr($tag,' ')) continue;
                $tagml = $tag; $tag = trim($tag,"<>"); $tag = trim($tag);
                if(!preg_match("@^([^\s]+)\s.*$@is", $tag, $pcs)) continue;
                $tag_name = $pcs[1];
                if($tag_name[0]=='/'){
                    $tag_name = substr($tag_name, 1);
                    $text = str_replace($tagml, "</".$tag_name.">", $text);
                    continue;
                }
                if($tag_name[strlen($tag_name)-1]=='/'){
                    $tag_name = substr($tag_name, 0, strlen($tag_name)-1);
                    $text = str_replace($tagml, "<".$tag_name."/>", $text);
                    continue;
                }
                $text = str_replace($tagml, "<".$tag_name.">", $text);
            }
        }
    }
    //-- Strip Regular Tags
    if(is_bool($keepTags)){
        if(!$keepTags){
            //-- We strip all the tags here
            $text = preg_replace("@<[^>]+>@si", "", $text);
        }
        //-- Otherwise we keep all the tags
    }else{
        if(is_string($keepTags)){
            $keepTags = preg_split("/[^a-z]/i",$keepTags);
        }
        if(is_array($keepTags)){
            if(preg_match_all("/<([^\/\s>]+)[^>]*>/si",$text,$tags)){
                //-- Tags Found in The Html
                $tags=$tags[1];
                $stripTags = array_diff($tags, $keepTags);
                $text=preg_replace("/<\/?(".implode("|",$stripTags).
                    ")(\s|)[^>]*>/","",$text
                );
            }
        }
    }
    //-- Remove Here Some WellKnown Html Chars
    $text=str_replace("&amp;","&",$text);
    //-- Trash all special characters
    if($stripHtmlChars){
        $text = unhtmlentities($text);
        // If anything left-over
        $text = preg_replace("/&[^;]+;/Ui"," ",$text);
    }
    //-- Strip all Consecutive Spaces
    if($stripSpaces){
        $text=str_replace("&nbsp;"," ",$text);
        //$text=preg_replace("/\s+/"," ",$text);
        $text=preg_replace("/[ \t]+/"," ",$text);
    }
    //-- Here you can continue to play with the output
    //-- And then return it
    return trim($text);
}

?>