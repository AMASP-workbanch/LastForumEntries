<?php

/**
 *
 *	@module       LastForumEntries
 *	@version      0.4.2
 *	@authors      Herr Rilke, Dietrich Roland Pehlke (last)
 *	@license      GNU General Public License
 *	@platform     2.8.x
 *	@requirements PHP 5.4.x and higher
 *
 */

$module_directory	= 'LastForumEntries';
$module_name		= 'LastForumEntries';
$module_function	= 'snippet';
$module_version		= '0.4.2';
$module_platform	= (defined("LEPTON_PATH")) ? '2.2.0' : '2.8.3' ;
$module_guid		= '4F62CE3B-0AE7-402A-A73F-AC08FD99A025';
$module_author		= 'Herr Rilke, Dietrich Roland Pehlke (last)';
$module_license		= 'GNU General Public License';
$module_description	= 'Snippet to display the last forum entries (WB-Forum - Module)<br/>
NEEDS VERSION 0.5.9 (16) OF WB-FORUM !<br/>
call as snippet e.g.:<br/>
<pre>LastForumEntries ($max_items = 5, $max_chars=50, $owd_devider=\' &raquo; \', $heading=\'&lt;h3&gt;Letzte ForenBeitr&auml;ge&lt;/h3&gt;\')<pre>';

?>