<?php

class ErrorHandler {

	public function handleError($errno, $errstr) {
		// from http://php.net/manual/en/function.set-error-handler.php#example-474
		
		switch ($errno) {
			case E_USER_ERROR:
				echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
				echo "  Fatal error on line $errline in file $errfile";
				echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
				echo "Aborting...<br />\n";
				exit(1);
				break;

			case E_USER_WARNING:
				echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
				break;

			case E_USER_NOTICE:
				echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
				break;

			default:
				echo "Unknown error type: [$errno] $errstr<br />\n";
				break;
		}

		/* Don't execute PHP internal error handler */
		return true;
	}

	public function handleException($e) {
		echo $e->getMessage();
	}

	public function handleFatalError() {
		dd('fatal error!');
	}
}
