<?php

/**
 *
 *	@module       LastForumEntries
 *	@version      0.4.0
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

if (!function_exists('LastForumEntries')) {

	function LastForumEntries(
		$max_items = 5,
		$max_chars = 50,
		$owd_devider = ' &raquo; ',
		$heading = '<h3>Letzte ForenBeitr&auml;ge</h3>',
		$time_format = DEFAULT_DATE_FORMAT." - ".DEFAULT_TIME_FORMAT
	)
	{
		global $wb;
		
		require_once WB_PATH . '/modules/forum/functions.php';
		//	require_once WB_PATH . '/modules/forum/config.php';

		require_once (dirname(dirname(__FILE__))."/forum/classes/class.subway.php");
		$subway = new subway(); 

		$temp_path = $subway->CMS_PATH."/templates/";
		$temp_path .= ( $wb->page['template'] == "" ? DEFAULT_TEMPLATE : $wb->page['template']);
		$temp_path .= "/frontend/LastForumEntries/";
		
		$template_path = (file_exists($temp_path."frontend_view.lte"))
			? $temp_path
			: dirname(__FILE__)."/templates/"
			;
		
		$subway->template_path = $template_path;
		if( true === $subway->twig_loaded ) $subway->loader->prependPath(  $subway->template_path );
		
		$out = "";
		
		$sql = 'SELECT f.title as forum,
				 p.postid, p.threadid, p.username,p.title,
				 p.dateline as datum, p.text,
				 p.page_id, p.section_id

				FROM '.TABLE_PREFIX.'mod_forum_post p
					JOIN  '.TABLE_PREFIX.'mod_forum_thread t USING(threadid)
					JOIN  '.TABLE_PREFIX.'mod_forum_forum f ON (t.forumid = f.forumid)

				ORDER BY p.dateline DESC
				LIMIT ' . intval($max_items);

		$all_hits = array();
		$query = $subway->db->get_all(
			$sql,
			$all_hits
		);
		
		if($subway->db->is_error()) {
			echo $subway->db->get_error();
			return 0;
		}

		// echo $subway->display( $temp_path );
		// return 0;

		if( count($all_hits) > 0 )
		{
			$out .= '<div id="mod_last_forum_entries">' . $heading;

			foreach( $all_hits as &$f )
			{
			
				$values = array(
					'CMS_URL' => $subway->CMS_URL,
					'forum_postid'	=> $f['postid'],
					'forum_forum'	=> $f['forum'],
					'forum_title'	=> $f['title'],
					'forum_date'	=> date( $time_format, $f['datum']),
					'owd_devider'	=> $owd_devider,
					'forum_teaser' => owd_mksubstr ( strip_bbcode($f['text']), $max_chars)
				);
				
				$out .= $subway->render(
					'frontend_view.lte',
					$values
				);
			}
			$out .= '</div>';
		}

		echo $out;
	}
}

?>