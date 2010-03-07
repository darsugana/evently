<?php
/*
// Debug static class 
// TODO: break this up in a more sensible fashion
*/
class Debug {
	/**
	 * Shows where item is defined (if it's an object) and dumps it's contents
	 * to the screen.
	 * 
	 * @param mixed $var - the object / variable to dump
	 * @param boolean $return - set to true if you want it to return the output rather than echo it (just like print_r)
	 * @return mixed - if $return is true, returns the output as string, otherwise it returns true.
	 * @author Anthony Bush
	 **/
	static function jamvar($var, $return = false) {
		$html  = '';
		$html .= '<div class="debug">';
		$html .= '<pre>';
		
		// Show where this class is defined:
		if (is_object($var)) {
			$reflector = new ReflectionClass($var);
			$html .= $reflector->getName()
				. ' is defined in ' . $reflector->getFileName()
				. ' on line ' . $reflector->getStartLine() . "\n";
		}
		
		$html .= print_r($var, true);
		$html .= '</pre>';
		$html .= '</div>';
		
		if ($return) {
			return $html;
		} else {
			echo $html;
			return true;
		}
	}
	
	/**
	 * Does a jamvar in HTML comments (e.g. for printing SQL to the HTML source without disturbing the display)
	 * 
	 * @param mixed $var - the object / variable to dump
	 * @param boolean $return - set to true if you want it to return the output rather than echo it (just like print_r)
	 * @return mixed - if $return is true, returns the output as string, otherwise it returns true.
	 * @author Wayne Wight
	 **/
	static function comment($var, $return = false) {
		$html  = "\n<!--\n";
		
		// Show where this class is defined:
		if (is_object($var)) {
			$reflector = new ReflectionClass($var);
			$html .= $reflector->getName()
				. ' is defined in ' . $reflector->getFileName()
				. ' on line ' . $reflector->getStartLine() . "\n";
		}
		
		$html .= print_r($var, true);
		$html .= "\n-->\n";
		
		if ($return) {
			return $html;
		} else {
			echo $html;
			return true;
		}
	}
	
	public static function getShowHideJavascript() {
		static $called = false;
		if ($called) {
			return;
		}
		$called = true;
		ob_start();
		?>
		<style type="text/css" media="screen">
		/* <![CDATA[ */
			.debug {
				border: 1px solid #000;
				background: #fff;
				color: #000;
			}
			.debug,
			.debug table td {
				text-align: left;
			}
			.debug table {
				margin: .5em 0;
			}
			.debug .title {
				display: block;
				background: #ddd;
				padding: 5px;
				font-weight: bold;
			}
			.debug a:link,
			.debug a:visited,
			.debug a:hover,
			.debug a:active {
				color: #0000A2;
				font-weight: bold;
			}
			.debug .superjam_methods {
				display: none;
			}
			.debug .superjam_results {
				display: none;
				padding: 5px;
			}
			.debug .methodName {
				color: #9D6F38;
			}
		/* ]]> */
		</style>
		<script type="text/javascript" language="javascript" charset="utf-8">
		// <![CDATA[
			function showHide(elementId) {
				e = document.getElementById(elementId);
				if (e.style.display == 'none') {
					e.style.display = 'block';
				} else {
					e.style.display = 'none';
				}
			}
		// ]]>
		</script>
		<?php
		return ob_get_clean();
	}
	
	/**
	 * Completely expose the contents of the given item in a way that makes it
	 * easy to find out more about that item.
	 * 
	 * It displays invisible characters (nulls, boolean, empty strings) and
	 * builds collapsable tables out of arrays and objects.
	 *
	 * @param mixed $var - the object / variable to dump
	 * @param boolean $return - set to true if you want it to return the output rather than echo it (just like print_r)
	 * @return mixed - if $return is true, returns the output as string, otherwise it returns true.
	 * @author Anthony Bush
	 **/
	public static function superjam($var, $return = false, $overrideTitle = '') {
		$html = '';
		if (is_array($var)) {
			$html .= self::superjamObject($var, true, $overrideTitle);
		} else if (is_object($var)) {
			$html .= self::superjamObject($var, true, $overrideTitle);
		} else {
			$html .= '<pre>';
			if (strlen($overrideTitle) > 0) {
				$html .= htmlentities($overrideTitle);
			} else {
				$html .= 'Superjam';
			}
			$html .= ': ' . self::getVisual($var) . '</pre>';
		}
		
		if ($return) {
			return $html;
		} else {
			echo $html;
			return true;
		}
	}
	
	public static function getVisual($var) {
		if (is_null($var)) {
			return '[null]';
		} else if ($var === true) {
			return '[true]';
		} else if ($var === false) {
			return '[false]';
		} else if ($var === '') {
			return '[empty string]';
		} else if (is_array($var)) {
			return self::superjamObject($var, true);
		} else if (is_object($var)) {
			return self::superjamObject($var, true);
		} else {
			return htmlentities($var);
		}
	}
	
	/**
	 * Shows where item is defined (if it's an object) dumps it's contents, and
	 * lists the public / private methods in a collapsable format.
	 * 
	 * @param mixed $var - the object / variable to dump
	 * @param boolean $return - set to true if you want it to return the output rather than echo it (just like print_r)
	 * @return mixed - if $return is true, returns the output as string, otherwise it returns true.
	 * @author Anthony Bush
	 **/
	static public function superjamObject($var, $return = false, $overrideTitle = '') {
		$html  = '';
		static $num = 0;
		
		if (is_object($var))
		{
			
			$reflector = new ReflectionClass($var);
			
			$html .= self::getShowHideJavascript();
			
			$html .= '<div class="debug">';
			$html .= '<a class="title" href="javascript:void(showHide(\'superjam' . $num . '\'))">';
			if (strlen($overrideTitle) > 0) {
				$html .= htmlentities($overrideTitle);
			} else {
				$html .= 'Superjam: ' . $reflector->getName();
			}
			$html .= '</a>';
			$html .= '<div id="superjam' . $num . '" class="superjam_results" style="display:none">';

			// Show where this class is defined:
			$html .= 'Definition: ' . $reflector->getFileName() . ':' . $reflector->getStartLine() . "<br />\n";
			
			// Get methods
			$methods = array(
				  'public' => array()
				, 'private' => array()
				, 'protected' => array()
			);
			foreach ($reflector->getMethods() as $method) {
				if ($method->isPrivate()) {
					$access = 'private';
				} elseif ($method->isProtected()) {
					$access = 'protected';
				} else {
					$access = 'public';
				}
				$methods[$access][$method->getName()] = $method;
			}
			foreach ($methods as $access => $accessMethods) {
				ksort($methods[$access]);
			}
			
			// Show methods
			ob_start();
			foreach ($methods as $access => $accessMethods) {
				if ( ! empty($accessMethods)) {
					echo '<a class="' . $access . '" href="javascript:void(showHide(\'superjam_' . $access . $num . '\'))">Show/Hide ' . ucwords($access) . ' Methods</a>' . "<br />\n";
					echo '<pre id="superjam_' . $access . $num . '" class="superjam_methods" style="display:none">';
					foreach ($accessMethods as $method) {
						$params = array();
						foreach ($method->getParameters() as $param) {
							$params[] = '<span class="methodParam">$' . $param->getName() . '</span>';
						}
						$paramNames = implode(', ', $params);
						printf(
							   '<div class="method ' . $access . '">'
							   . "%s%s%s "
							   . '<span class="methodName">'
							   . "%s</span>("
							   . $paramNames
							   . ');</div>'
							   , $method->isAbstract() ? ' abstract' : ''
							   , $method->isFinal() ? ' final' : ''
							   , $method->isStatic() ? ' static' : ''
							   , $method->getName()
							   );
					}
					echo '</pre>';
				}
			}
			$html .= ob_get_clean();
			
			
			// Show contents
			$html .= '<a class="superjam_contents" href="javascript:void(showHide(\'superjam_contents' . $num . '\'))">Show/Hide Contents</a>' . "<br />\n";
			$html .= '<pre id="superjam_contents' . $num . '" style="display:none">';
			$html .= htmlentities(print_r($var, true));
			$html .= '</pre>';
			
			$html .= '</div>'; // superjam . $num
			$html .= '</div>'; // debug
			
			$num++;
		}
		else if (is_array($var))
		{
			
			// Just show contents
			$html .= self::getShowHideJavascript();
			$html .= '<div class="debug" style="border: 1px solid #000; background: #fff">';
			$html .= '<a class="title" style="display: block; background: #ddd; padding: 5px; font-weight: bold;" href="javascript:void(showHide(\'superjam' . $num . '\'))">';
			if (strlen($overrideTitle) > 0) {
				$html .= htmlentities($overrideTitle);
			} else {
				$html .= 'Superjam: PHP Array';
			}
			$html .= '</a>';
			$html .= '<pre id="superjam' . $num . '" style="display:none; padding: 5px">';
			$html .= htmlentities(print_r($var, true));
			$html .= '</pre>';
			$html .= '</div>'; // debug
			
			$num++;
		}
		
		if ($return) {
			return $html;
		} else {
			echo $html;
			return true;
		}
		
	}
	
	/**
	 * A light backtrace. Useful if you need many backtraces on the page and
	 * can't afford the extra markup given by superbt.
	 *
	 * @return void
	 * @author Anthony Bush
	 **/
	public static function lightbt() {
		echo '<pre class="lightbt" style="font-weight: normal; font-family: monospace; font-size: 10pt; background: #ccc; color: #000; padding: 5px; border: 1px solid #999">';
		ob_start();
		debug_print_backtrace();
		echo htmlentities(ob_get_clean());
		echo '</pre>';
	}
	
	/**
	 * Super backtrace. It shows ALL included files in addition to the trace.
	 * 
	 * The order each file that has been included is shown, and the backtrace
	 * of files is highlighted, and the parameters for function calls listed.
	 *
	 * @return void
	 * @author Anthony Bush
	 **/
	public static function superbt() {
		$includedFiles = get_included_files();
		$bt = debug_backtrace();
		
		// Entity encode the includedFiles array:
		$fileCount = count($includedFiles);
		for ($i = 0; $i < $fileCount; $i++) {
			$includedFiles[$i] = htmlentities($includedFiles[$i]);
		}
		
		// Append the backtrace line numbers to each included file.
		// We go through the backtrace array backwards so the line numbers
		// are appened in order of their execution.
		$keysToHighlight = array();
		$btCount = count($bt);
		for ($i = $btCount - 1; $i >= 0; $i--) {
			$key = array_search($bt[$i]['file'], $includedFiles);
			if ($key !== false) {
				// Record key to include file and line number of backtrace.
				$keysToHighlight[$key][] = $bt[$i]['line'];
			}
		}
		// Highlight all the include files rows that are part of the backtrace.
		foreach ($keysToHighlight as $key => $lines) {
			$includedFiles[$key] = '<span style="color: red">' . $includedFiles[$key] . ':' . implode(',', $lines) . '</span>';
		}
		
		// Get an easier to read backtrace (objects and arrays passed as args pre-collapsed)
		$simpleTrace = array();
		for ($i = 0; $i < $btCount; $i++) {
			
			$trace = array();
			
			$trace['where'] = $bt[$i]['file'] . ':' . $bt[$i]['line'];
			
			$displayArgs = true;
			if (isset($bt[$i]['class'])) {
				$trace['what'] = $bt[$i]['class'] . $bt[$i]['type'] . $bt[$i]['function'];
			} else {
				$trace['what'] = $bt[$i]['function'];
				if (count($bt[$i]['args']) == 1 && in_array($bt[$i]['function'], array('include', 'include_once', 'require', 'require_once'))) {
					$trace['what'] .= '(' . $bt[$i]['args'][0] . ')';
					$displayArgs = false;
				}
			}
			if ($displayArgs && isset($bt[$i]['args'])) {
				if (count($bt[$i]['args']) > 0) {
					$trace['what'] .= '( ' . count($bt[$i]['args']) . ' args passed )';
					$trace['args'] = array();
					foreach ($bt[$i]['args'] as $arg) {
						$trace['args'][] = self::getVisual($arg, true);
					}
				} else {
					$trace['what'] .= '()';
				}
			}
			if (isset($bt[$i]['object'])) {
				$trace['object'] = self::superjam($bt[$i]['object'], true);
			}
			
			$simpleTrace[] = $trace;
		}
		
		// Output results
		ob_start();
		static $num = 0;
		echo self::getShowHideJavascript();
		
		echo '<div class="debug" style="border: 1px solid #000; background: #fff">';
		echo '<a class="title" style="display: block; background: #ddd; padding: 5px; font-weight: bold;" href="javascript:void(showHide(\'superbt' . $num . '\'))">Superbt:&nbsp;' . $bt[0]['file'] . ':' . $bt[0]['line'] . '</a>';
		echo '<div id="superbt' . $num . '" style="display:none; padding: 5px">';
		
		new dBug($includedFiles, '', false, 'Listing all included files; red ones are part of the backtrace:');
		new dBug($simpleTrace, '', false, 'Backtrace with Arrays and Objects pre-collapsed:');
		
		// The output I wanted to avoid by creating this function is typically provided by something like:
		// echo 'Traditional BT:';
		// echo '<pre>';
		// echo htmlentities(print_r(debug_backtrace(), true));
		// echo '</pre>';
		// 
		// echo 'Traditional BT w/ dBug:';
		// new dBug(debug_backtrace());
		
		echo '</div>'; // superbt . $num
		echo '</div>'; // debug
		
		echo ob_get_clean();
		
		$num++;
	}
	
	public static function env() {
		echo self::getEnv();
	}
	
	public static function getEnv() {
		ob_start();
		
		new dBug(get_defined_constants(true));
		new dBug(get_included_files());
		new dBug(get_loaded_extensions());
		new dBug(debug_backtrace());
		
		return ob_get_clean();
	}
	
	static function methods($obj) {
		if (is_object($obj)) {
			$className = get_class($obj);
			$refClass = new ReflectionClass($className);
			$methods = array(  'public'=>array()
							 , 'private'=>array()
							 , 'protected'=>array());
			foreach ($refClass->getMethods() as $method) {
				if ($method->isPrivate()) {
					$access = 'private';
				} elseif ($method->isProtected()) {
					$access = 'protected';
				} else {
					$access = 'public';
				}
				$methods[$access][$method->getName()] = $method;
			}
			foreach ($methods as $access => $accessMethods) {
				ksort($methods[$access]);
			}
			echo '<div class="debug" ';
			echo 'onclick="det = document.getElementById(\'debug_details_' . $className . '\'); if (Css.hasClass(det, \'hide\')) { Css.removeClass(det, \'hide\'); } else { Css.addClass(det, \'hide\'); }">';
			echo '<h1>Class ' . $className . '</h1>';
			echo '<div id="debug_details_' . $className . '" class="hide">';
			foreach ($methods as $access => $accessMethods) {
				if (count($accessMethods)) {
					echo '<h2 class="' . $access . '">' . ucwords($access) . ':</h2>';
					foreach ($accessMethods as $method) {
						$params = array();
						foreach ($method->getParameters() as $param) {
							$params[] = '<span class="methodParam">$' . $param->getName() . '</span>';
						}
						$paramNames = implode(', ', $params);
						printf(
							   '<div class="method ' . $access . '">'
							   . "%s%s%s "
							   . '<span class="methodName">'
							   . "%s("
							   . $paramNames
							   . ')</span>;</div>'
							   , $method->isAbstract() ? ' abstract' : ''
							   , $method->isFinal() ? ' final' : ''
							   , $method->isStatic() ? ' static' : ''
							   , $method->getName()
							   );
					}
				}
			}
			echo '</div>';
			echo '</div>';
		} else {
			echo 'Not An Object';
		}
	}
	
	public static function classes() {
		$classes = get_declared_classes();
		sort($classes);
		self::jamvar($classes);
	}
	
	/**
	 * Calls all the getters for the passed in object that do not require any
	 * parameters.
	 * 
	 * @param object $obj - the object to call the getters for
	 * @param string $id - an optional unique id to append to the CSS id
	 * @return void
	 * @author Anthony Bush
	 **/
	static function callGetters($obj, $id = '') {
		if (is_object($obj)) {
			$className = get_class($obj);
			$refClass = new ReflectionClass($className);
			
			echo '<div class="debug" ';
			echo 'onclick="det = document.getElementById(\'debug_details_' . $className . 'Getters' . $id . '\'); if (hasClass(det, \'hide\')) { removeClass(det, \'hide\'); } else { addClass(det, \'hide\'); }">';
			echo '<h1>' . $className . '(' . $id . ') Getters</h1>';
			echo '<table id="debug_details_' . $className . 'Getters' . $id. '" class="hide" border="1" cellspacing="0" cellpadding="3">';
			foreach ($refClass->getMethods() as $method) {
				if ($method->isPublic()) {
					$methodName = $method->getName();
					if (substr($methodName, 0, 3) == 'get' && count($method->getParameters()) == 0) {
						echo '<tr><td>' . $methodName . '()</td><td>' . $obj->$methodName() . '</td></tr>';
					}
				}
			}
			echo '</table>';
			echo '</div>';
		} else {
			echo 'Not An Object';
		}
	}
	static function showBacktrace($arr = null) {
		if (SHOW_BACKTRACE == true) {
			if (empty($trace)) {
				$arr = debug_backtrace();
			}
			?>
			<table width=100% border=1><tr><td bgcolor="#DDDDDD"><b>Backtrace:</b></td></tr>
			<?php
			foreach ($arr as $level => $step) {
				?>
				<tr><td bgcolor="#ABCDEF">Level <?=$level?></td></tr>
				<?php
				self::showBacktraceItem($step);
			}
			?>
			</table>
			<?php
		}
	}
	static function showBacktraceItem($item) {
		?>
		<tr><td>
			<?php if ($item["file"] != "") { ?>
				<b>File: </b><?=$item["file"]?><br>
			<?php } ?>
			<?php if ($item["type"] == "->" OR ($item["type"] == "::")) {
					?>
					<b>Method: </b> <?=$item["class"]?><?=$item["type"]?><?=$item["function"]?><br>
					<?php
			} else {
				?>
				<?php if ($item["class"] != "") { ?>
					<b>Class: </b><?=$item["class"]?><br>
				<?php } ?>
				<?php if ($item["function"] != "") { ?>
					<b>Function: </b><?=$item["function"]?><br>
					<?php if ($item["type"] != "") { ?>
						(Call type: <?=$item["type"]?>)<br>
					<?php } ?>
				<?php } 
			} ?>
				
				<?php if ($item["line"] != "") { ?>
					<b>Line: </b><?=$item["line"]?><br>
				<?php } ?>
				<?php if (count($item["args"]) > 0) { ?>
					<b>Args: </b><?php jamvar($item["args"])?><br>
				<?php } else {
					?>
					<b>Args: none passed</b>
					<?php
				} ?>
		</td></tr>
		<?php
	}
	
	/**
	 * The next three methods are a modification of the showBacktrace routines.
	 *
	 * The differences are as follows:
	 *    - Functions no longer output html, but instead return the html.
	 *    - Additional sanity checks to insure that "type" and "class" indexes
	 *      actually exist before referencing them. This removes some of the
	 *      bogus output that was complaining about the backtrace functions themselves.
	 *    - New function: showBacktraceInWindow() opens the backtrace in a popup window.
	 *      You can have multiple backtraces and have them either all in same popup in
	 *      different popups or a combination of same/different. This popup version
	 *      allows you to call backtraces in places in the code where there is not
	 *      enough room to fit the backtrace output.
	 *
	 * Possible Enhancements:
	 *    - Add functions that output custom things in various ways, e.g.
	 *        - Debug::showInWindow('Inside crazyFunction():<br>' . print_r($var, true));
	 *        - Debug::showInComment('Inside crazyFunction():' . "\n" . print_r($var, true));
	 *        - Debug::showInLine('Inside crazyFunction():<br>' . print_r($var, true));
	 *
	 * @author Anthony Bush
	 **/
	
	/**
	 * Returns the backtrace item as a string instead of outputting it.
	 * 
	 * Used by showBacktraceInWindow (well, getBacktrace).
	 * 
	 * Probably could merge this with showBacktraceItem and give that function
	 * a second parameter $returnResult that, when set to true, would have the
	 * function return the result instead of outputting it.
	 *
	 * @return string
	 * @author Anthony Bush
	 **/
	private function getBacktraceItem($item) {

		$html  = '';
		$html .= '<tr><td>';

		if ($item["file"] != "") {
			$html .= '<b>File: </b>' . $item["file"] . '<br>';
		}
		if (isset($item["type"]) && ($item["type"] == "->" || $item["type"] == "::")) {
				$html .= '<b>Method: </b>' . $item["class"] . $item["type"] . $item["function"] . '<br>';
		} else {
			if (isset($item["class"]) && $item["class"] != "") {
				$html .= '<b>Class: </b>' . $item["class"] . '<br>';
			}
			if ($item["function"] != "") {
				$html .= '<b>Function: </b>' . $item["function"] . '<br>';
				if (isset($item["type"]) && $item["type"] != "") {
					$html .= '(Call type: ' . $item["type"] . ')<br>';
				}
			} 
		}

		if ($item["line"] != "") {
			$html .= '<b>Line: </b>' . $item["line"] . '<br>';
		}
		if (count($item["args"]) > 0) {
			$html .= '<b>Args: </b>';
			$html .= '<pre>';
			$html .= print_r($item["args"], true);
			$html .= '</pre>';
			$html .= '<br>';
		} else {
			$html .= '<b>Args: none passed</b>';
		}

		$html .= '</td></tr>';

		return $html;
	}
	
	/**
	 * Returns the backtrace as a string instead of outputting it.
	 * 
	 * Used by showBacktraceInWindow.
	 * 
	 * Probably could merge this with showBacktraceItem and give that function
	 * a second parameter $returnResult that, when set to true, would have the
	 * function return the result instead of outputting it.
	 *
	 * @return string
	 * @author Anthony Bush
	 **/
	static public function getBacktrace($backtraceArray = null) {
		if (is_null($backtraceArray)) {
			$backtraceArray = debug_backtrace();
		}

		$html  = '';
		$html .= '<table width=100% border=1 style="margin-bottom: 5em;"><tr><td bgcolor="#DDDDDD"><b>Backtrace:</b></td></tr>';
		foreach ($backtraceArray as $level => $step) {
			$html .= '<tr><td bgcolor="#ABCDEF">Level ' . $level . '</td></tr>';
			$html .= self::getBacktraceItem($step);
		}
		$html .= '</table>';

		return $html;
	}

	/**
	 * Opens a backtrace in a popup window.
	 * 
	 * This allows you to call backtraces in places in the code where there is
	 * not enough room to fit the backtrace output. You can specify optional
	 * window id and title. See below for a bit more info:
	 *
	 * If you do not specify the first parameter $windowId, or set it as an
	 * empty string, all backtrace calls will go to the same popup.
	 * 
	 * If you want a new popup for each one, then specify a different $windowId
	 * for each backtrace call. For example, in a function that gets called
	 * multiple times, you could activate a new backtrace window for each one
	 * like so:
	 *
	 *    static $windowId = 0; ++$windowId;
	 *    Debug::showBacktraceInWindow($windowId, 'Trace '.$windowId);
	 *
	 * The $windowTitle parameter provides a way for you to set the title of window.
	 *
	 * @param $windowId string the id of the popup window (optional, see full documentation)
	 * @param $windowTitle string the window title of the popup window (optional)
	 * @return void
	 * @author Anthony Bush
	 **/
	static public function showBacktraceInWindow($windowId = '', $windowTitle = "Untitled Backtrace") {
		$windowTitle = String::convertToJavaScript($windowTitle);

		$html = self::getBacktrace();
		$js = String::convertToJavaScript($html);
		?>
		<script type="text/javascript" language="javascript" charset="utf-8">
		// <![CDATA[
			var backtraceWindow<?= $window ?> = window.open("", <?= (empty($windowId) ? 'null' : '"btWin'.$windowId.'"') ?>);
			backtraceWindow<?= $window ?>.document.writeln('<html><head><title><?= $windowTitle ?></title></head><body><?= $js ?></body></html>');
		// ]]>
		</script>
		<?php
	}
	
	static function getmicrotime() {
	        list($usec, $sec) = explode(" ",microtime());
	        return ((float)$usec + (float)$sec);
	}
	static function showBenchmark($marker = "unlabeled", $echoBit=FALSE) {
		global $time_measurement;
		global $global_trace;
		global $sbCallCt;
		
		if (SHOW_BENCHMARKS) {
			$thisTime = getmicrotime();
			if ($time_measurement != "") {
				//echo "<br>".$thisTime." - ".$time_measurement;
				$elapsed = $thisTime - $time_measurement;
				$time_measurement = $thisTime;
				$sbCallCt++;
				if ($elapsed > 0.3) {
					$color = "#FF0000";
				} else {
					$color = "#000000";
				}
				if (is_array($marker) || is_object($marker)) {
					// $jamCache = print_r($marker, true);
					// echo("<pre>".$jamCache."</pre>");
					$global_trace .= "<br><font color=".$color."><b> $sbCallCt : JAMVAR INVOKED -- Elapsed Time: ".($elapsed)." msecs </b></font><br>\r";
				} else {
					if ($echoBit) {
						echo ("<br><b> $sbCallCt : At '".$marker."' -- Elapsed Time: ".($elapsed)." msecs <br>\r");
					} else {
					$global_trace .= "<br><font color=".$color."><b> $sbCallCt : At '".$marker."' -- Elapsed Time: ".($elapsed)." msecs </b></font><br>\r";
						//$global_trace .= "<br><b> $sbCallCt : At '".$marker."' -- Elapsed Time: ".($elapsed)." msecs <br>\r";
					}
				}
			} else {
				//echo "<br><b>Started Benchmark</b><br>";
				$time_measurement = $thisTime;
			}
		}	
	}
	static function getAncestors($class) {
     for ($classes[] = $class; $class = get_parent_class ($class); $classes[] = $class);
     return $classes;
	}
	static function dbug($obj) {
		return new dBug($obj);
	}
}
