<?php

/**
 *
 *	@module       LastForumEntries
 *	@version      0.4.1
 *	@authors      Herr Rilke, Dietrich Roland Pehlke (last)
 *	@license      GNU General Public License
 *	@platform     2.8.x
 *	@requirements PHP 5.4.x and higher
 *
 */

/**
 *	function LastForumEntries()
 *	function to display last forum entries of WB-Forum 0.3 on every/any page.
 *	(invoke function from template or code page)
 *
 *	@param int 		how many last entries to display
 *	@param int 		how many characters of the message body to display as preview
 *	@param string 	divide thread name from entry title by a divider if you like
 *	@param string 	heading
 *
 */

require_once( dirname(__FILE__)."/classes/forum_LastForumEntries.php" );

if (!function_exists('LastForumEntries')) {

	function LastForumEntries(
		$max_items = 5,
		$max_chars = 50,
		$owd_devider = ' &raquo; ',
		$heading = '<h3>Letzte ForenBeitr&auml;ge</h3>',
		$time_format = NULL,
		$only_this_section = 0,
		$return_content = false 
	)
	{
	
		if ($time_format === NULL) $time_format = DEFAULT_DATE_FORMAT." - ".DEFAULT_TIME_FORMAT;
		
		$options = array(
			'max_items'		=> $max_items,
			'max_chars'		=> $max_chars,
			'owd_devider'	=> $owd_devider,
			'heading'		=> $heading,
			'time_format'	=> $time_format,
			'only_this_section'	=> $only_this_section
		);
		
		$oForum = new forum_LastForumEntries( $options );
		
		$out = $oForum->toHTML();
		
		if( false === $return_content ) {
			echo $out;
		} else {
			return $out;
		}
	}
}


?>