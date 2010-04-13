<?php
class Ev_Address
{

	protected static $testValues = array(
		"Get Ready, Get Set, Get Fit, and Get Healthy!! Your annual Hutto Health Fair is being held on Saturday April 24! Admission is Free and Fun for the whole Family! 11Am - 3Pm at the Hutto Middle School, 1005 Exchange Blvd Hutto TX 78634.

		If you have any questions or would like to participate in this great community event, you may contact someone at the Hope Pregnancy Center (512) 846-1902. We hope to see you there! Rain or Shine!

		www.hpchutto.org

		We will also be accepting donations in either can foods to benefit the local area food pantry or diapers and hygeine for the pregnancy center.
		"
		);

	private static function parseAddress($address)
	{
		
		// from http://www.relatebase.com/development/misc/parse_address_code.txt
		
		// 2010-04-09 FIXME RHP: this could just a lot of cleanup to conform to the code standards
		// 						 plus the apt number stuff doesn't work?
		/***
		2004-10-05 Added HC n Box n, Star Route to function
		2004-10-04 Sam Fullman (compasspointmedia.com)
		function notes
		this function requires an address that has been stripped of periods and commas.  I don't believe commas are part of the USPS required addressing standards so I don't want to use them to try to get parsing information.
		this function starts from the RIGHT hand side, pulling unit numbers and other features like the direction (N,S,E,W).
		It also recognizes PO Boxes and Rural routes pretty well though there are surely formats I'm not familiar with.  Any Canadians chip in here, appreciate your feedback and we do want to mail things to you even if you are Canadians :-)
		Many of the parameters start with the prefix raw_ (raw_unit, raw_suffix_direction, etc.).  Usually there's a corresponding parameter called unit, suffix_direction, etc..  I'm not consistent on this but one of the concepts is that if you have this address:

		3791 S Park Place

		We can be SURE that S is a prefix direction, but we don't know if this address is:
			name=>Park Place
			type=>(none)
		or
			name=>Park
			type=>Pl
		so the idea was to store it something like this:
			name=Park
			type=>Pl
			raw_type=>Place

		On the above example, there would be no raw_prefix_direction, only a prefix_direction field, since we are assured that S means a prefix direction, but not the word South (since it could be "South Park" Place)

		***/
		$dir=array(
			'N'=>'N','S'=>'S','E'=>'E','W'=>'W','NW'=>'NW','SW'=>'SW','NE'=>'NE','SE'=>'SE',
			'North'=>'N','South'=>'S','East'=>'E','West'=>'W','Northwest'=>'NW','Southwest'=>'SW','Northeast'=>'NE','Southeast'=>'SE'
		);
		$type=array(
			'ave'=>'Ave','blvd'=>'Blvd','st'=>'St','wy'=>'Wy','cir'=>'Cir','dr'=>'Dr','ln'=>'Ln','Pl'=>'Pl','Rd'=>'Rd','
			Bvd'=>'Blvd','
			Avenue'=>'Ave','Boulevard'=>'Blvd','Street'=>'St','Way'=>'Wy','Circle'=>'Cir','Drive'=>'Dr','Lane'=>'Ln','Place'=>'Pl','Road'=>'Rd'
		);
		$a = array();
		$b = array();
		$address=trim($address);
		$b['raw_address']=$address;
		$original=$address;
		//remove any unit or apt # from the end
		//a number alone at the end is not enough, we need at least # or one of the descriptors in ()
		if(preg_match('/(\s+(Apt|Apartment|Suite|Ste|Unit|Bldg|Building|Room|Rm|#)\s*)+#?[-a-z0-9]+$/i',
		$address,$a)){
			$b['raw_unit']=$a[0];
			$b['unit']=preg_replace('/(\s+(Apt|Apartment|Suite|Ste|Unit|Bldg|Building|Room|Rm|#)\s*)+#?/i','',$a[0]);
			//break raw unit down
			$address=substr($address,0,strlen($address)-strlen($a[0]));
		}
		//parse suffix direction (SW)
		if(preg_match('/\s+(North|South|East|West|Northeast|Southeast|Southwest|Northwest|N|S|E|W|NE|SE|SW|NW)$/i',$address,$a)){
			$b['raw_suffix_direction']=$a[0];
			$b['suffix_direction']=$dir[$b['raw_suffix_direction']];
			$address=substr($address,0,strlen($address)-strlen($a[0]));
		}
		//remove type of street
		if(preg_match('/\s+(St|Bvd|Ave|Wy|Cir|Dr|Ln|Pl|Boulevard|Blvd|Street|Avenue|Way|Circle|Drive|Lane|Place)$/i',
		$address,$a)){
			$b['raw_type']=$a[0];
			strlen($b['raw_type'])>3 || strtolower($b['raw_type'])=='way' || strtolower($b['raw_type'])=='bvd'?$typeDefinite=false:$typeDefinite=true;
			$b['type']=$type[strtolower($b['raw_type'])];
			$address=substr($address,0,strlen($address)-strlen($a[0]));
		}
		//remove number and fraction
		if(preg_match('/^[0-9]+(\s+[0-9]+\/[0-9]+)*/',$address,$a)){
			$address=substr($address,strlen($a[0]),strlen($address)-strlen($a[0]));
			if(preg_match('/\s+[0-9]+\/[0-9]+$/',$a[0],$aa)){
				$b['fraction']=$aa[0];
				$a[0]=substr($a[0],0,strlen($a[0])-strlen($aa[0]));
			}
			$b['number']=trim($a[0]);
			$numberFormat='standard';
		}else{
			$numberFormat='irregular';
			//account for possible P.O. Boxes and Rural Routes
			if(preg_match('/^(POB\s+|P\s*O\s*Box|Post Office Box|Postal Box|Box|Boite Postal)\s*[0-9a-z]+(-[0-9a-z]+)*/i',$address,$a)){
				$b['raw_po_box']=$a[0];
				preg_match('/[0-9a-z]+(-[0-9a-z]+)*$/i',$a[0],$aa);
				$b['po_box']=strtoupper($aa[0]);
				$b['address_type']="Post Office Box";
			}
			if(preg_match('/(Rrte|RR|Rural Route|Rt|Rte|Route)\s+[0-9]+\s+(Box|Bx)\s+[0-9]+/i',$address,$a)){
				$b['raw_route']=$a[0];
				$a=explode('b',strtolower($a[0]));
				$b['route_number']=preg_replace('/[^0-9]+/','',$a[0]);
				$b['route_box_number']=preg_replace('/[^0-9]+/','',$a[1]);
				$b['address_type']="Rural Route";
			}
			//Account for HC nomenclature -- for drawmack
			// echo $address;
			if(preg_match('/(HC|Highway County|Hwy Cty|Hwy County)\s+[0-9]+\s+(Box|Bx)\s+[0-9]+/i',$address,$a)){
				$b['raw_hc']=$a[0];
				$a=explode('b',strtolower($a[0]));
				$b['hc_number']=preg_replace('/[^0-9]+/','',$a[0]);
				$b['hc_box_number']=preg_replace('/[^0-9]+/','',$a[1]);
				$b['address_type']="Highway County Route";
			}
			//Account for * | Star Route
			if(preg_match('/(\*\s+Rte|\*\s+Route|Star\s+Route|Star\s+Rte)\s+[0-9]+\s+(Box|Bx)\s+[0-9]+/i',$address,$a)){
				$b['raw_starrt']=$a[0];
				$a=explode('b',strtolower($a[0]));
				$b['starrt_number']=preg_replace('/[^0-9]+/','',$a[0]);
				$b['starrt_box_number']=preg_replace('/[^0-9]+/','',$a[1]);
				$b['address_type']="Star Route";
			}
			/***
			Note on the above 4 nodes: we don't check that an address only partially conforms, such as Rte 1 (no box number), and perhaps we should.  Perhaps "Route 1" is even OK in some areas :-|
			***/

		}
		//what remains is the prefix direction, and street, several analyses to make here

		//note that if there is still an address left over yet we pulled a PO Box above or a Rural Route, then either something is wrong or our code missed something, this should be flagged.
		$address=trim($address);
		if(preg_match('/^(North|South|East|West|Northeast|Southeast|Southwest|Northwest|N|S|E|W|NE|SE|SW|NW)\s+/i',$address,$a)){
			$b['prefix_direction']=$dir[trim($a[0])];
			strlen($a[0])>2?$b['raw_prefix_direction']=$a[0]:'';
			$address = substr($address,strlen($a[0]),strlen($address)-strlen($a[0]));
		} else {
			//presume all else is the name
			$b['name']=trim($address);
			$b['address_type']="Presumed Standard";
		}

		//present the array visibly in a logical order -- not required for operation but nice
		$order=array(
		   'type_definite',
		   'address_type',
		   'raw_po_box',
		   'po_box',
		   'raw_route',
		   'route_number',
		   'route_box_number',
		   'raw_hc',
		   'hc_number',
		   'hc_box_number',
		   'raw_starrt',
		   'starrt_number',
		   'starrt_box_number',
		   'number',
		   'fraction',
		   'prefix_direction',
		   'raw_prefix_direction',
		   'name',
		   'type',
		   'raw_type',
		   'suffix_direction',
		   'raw_suffix_direction',
		   'unit',
		   'raw_unit',
		   'raw_address'
		);
		foreach($order as $v){
			isset($b[$v])?$c[$v]=$b[$v]:'';
		}
		return $c;

	}

	public static function stringToAddress($string, $verbose = false)
	{		
		$matches = array();
		// This regexp matches some digits, some text and then a 5 or 9 digit zip code, it could be better.
		// '([0-9]{1,} [\s\S]*? [0-9]{5}(?:-[0-9]{4})?)'
		
		
		/*
			Reverse this because even with ungreedy set, preg_match will hit the first sequence of numbers, 
			find the zip code and assume we want everything in between.
			
			This is not usually correct, we want a much less greedy result. Unfortunately, we can't use 
			preg_match_all and then figure out which one we want because preg_match_all won't search inside of 
			one of its matches, which is dumb.
			
			What we really want is the rightmost ungreedy match, not the leftmost. We can get this by reversing 
			the string and doing the regexp backwards.
			
			This may break with apt numbers though, it isn't perfect yet.
		*/
		$string2 = strrev($string);
		if (preg_match('([0-9]{5} [\s\S]*? [0-9]{1,})', $string2, $matches))
		{
			if ($verbose)
			{
				print_r(strrev($matches[0]));
			}
			return self::parseAddress(strrev($matches[0]));
		}
		
		return false;
	}
	
	public static function testStringToAddress()
	{
		foreach (self::$testValues as $string)
		{
			echo $string . "\n";
			$addy = self::stringToAddress($string, true);
			print_r($addy);
		}
	}
	
	
}


?>