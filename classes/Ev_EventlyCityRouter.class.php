<?php

class Ev_EventlyCityRouter implements Lvc_RouterInterface
{
	public function route($request) {
		$params = $request->getParams();
		
		if (isset($params['get']['url'])) {
			
			// Use mod_rewrite's url
			$url = explode('/', $params['get']['url']);
			$count = count($url);
			
			if ($count > 0)
			{
				$cityName = strtolower($url[0]);
				$city = City::constructByShortName($cityName);
				if (is_object($city))
				{
					City::setInstance($city);
					$count--;
					array_shift($url);
				}
			}
			
			// Set controller, action, and some action params from the segmented URL.
			if ($count > 0) {
				$request->setControllerName($url[0]);
				
				$actionParams = array();
				if ($count > 1) {
					$request->setActionName($url[1]);
					if ($count > 2) {
						for ($i = 2; $i < $count; $i++) {
							if ( ! empty($url[$i])) {
								$actionParams[] = $url[$i];
							}
						}
					}
				}
				
				$request->setActionParams($actionParams);
				return true;
			}
		}
		return false;
	}
	
}