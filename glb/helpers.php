<?php
	namespace Globals\helpers;
	
	/*
	 * Remove characters that might be used for SQL injection
	 *
	 * @param text content to be stripped off 
	 * @return string
	 */
	function cleanup_string($string){
		$string = strip_tags($string); // strip off all html and php tags
		$string = stripslashes($string); // strip off backslashes and quotes
		return $string;
	}
	
	/*
	 * Simple helper to debug to the console
	 *
	 * @param $data object, array, string $data
	 * @param $context string  Optional a description.
	 * @return string
	 */
	function debug_to_console( $data, $context = 'Debug in Console' ) {

		// Buffering to solve problems frameworks, like header() in this and not a solid return.
		ob_start();
		$output  = 'console.info( \'' . $context . ':\' );';
		$output .= 'console.log(' . json_encode( $data ) . ');';
		$output  = sprintf( '<script>%s</script>', $output );

		echo $output;
	}
?>