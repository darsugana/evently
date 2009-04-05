<?php

class Ev_EventlyCityRouter extends Lvc_RegexRewriteRouter implements Lvc_RouterInterface
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
			
			$matches = array();
			foreach ($this->routes as $regex => $parsingInfo) {
				if (preg_match($regex, implode('/', $url), $matches)) {

					// Check for redirect action first
					if (isset($parsingInfo['redirect'])) {
						$redirectUrl = preg_replace($regex, $parsingInfo['redirect'], $url);
						header('Location: ' . $redirectUrl);
						exit();
					}

					// Get controller name if available
					if (isset($parsingInfo['controller'])) {
						if (is_int($parsingInfo['controller'])) {
							// Get the controller name from the regex matches
							$request->setControllerName(@$matches[$parsingInfo['controller']]);
						} else {
							// Use the constant value
							$request->setControllerName($parsingInfo['controller']);
						}
					}

					// Get action name if available
					if (isset($parsingInfo['action'])) {
						if (is_int($parsingInfo['action'])) {
							// Get the action from the regex matches
							$request->setActionName(@$matches[$parsingInfo['action']]);
						} else {
							// Use the constant value
							$request->setActionName($parsingInfo['action']);
						}
					}

					// Get action parameters
					$actionParams = array();
					if (isset($parsingInfo['action_params'])) {
						foreach ($parsingInfo['action_params'] as $key => $value) {
							if (is_int($value)) {
								// Get the value from the regex matches
								if (isset($matches[$value])) {
									$actionParams[$key] = $matches[$value];
								} else {
									$actionParams[$key] = null;
								}
							} else {
								// Use the constant value
								$actionParams[$key] = $value;
							}
						}
					}
					if (isset($parsingInfo['additional_params'])) {
						if (is_int($parsingInfo['additional_params'])) {
							// Get the value from the regex matches
							if (isset($matches[$parsingInfo['additional_params']])) {
								$actionParams = $actionParams + explode('/', $matches[$parsingInfo['additional_params']]);
							}
						}
					}


					$request->setActionParams($actionParams);
					return true;
				} // route matched
			} // loop through routes
		} // url _GET value set

		return false;
	}
	
}