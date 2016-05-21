<?php
/*
 Website Baker Project <http://www.websitebaker.org/>
 Copyright (C) 2004-2007, Ryan Djurovich

 Website Baker is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 Website Baker is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Website Baker; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

 -----------------------------------------------------------------------------------------
  Licencsed under GNU, written by herr rilke
 -----------------------------------------------------------------------------------------
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
		$max_chars=50,
		$owd_devider=' &raquo; ',
		$heading='<h3>Letzte ForenBeitr&auml;ge</h3>'
	)
	{
		global $database;
		global $wb;
		global $section_id;
		global $page_id;
		
		require_once WB_PATH . '/modules/forum/functions.php';
		//	require_once WB_PATH . '/modules/forum/config.php';

		$out = "";
		
		$sql = 'SELECT f.title as forum,
				 p.postid, p.threadid, p.username,p.title,
				 FROM_UNIXTIME(p.dateline) as datum, p.text,
				 p.page_id, p.section_id

				FROM '.TABLE_PREFIX.'mod_forum_post p
					JOIN  '.TABLE_PREFIX.'mod_forum_thread t USING(threadid)
					JOIN  '.TABLE_PREFIX.'mod_forum_forum f ON (t.forumid = f.forumid)

				ORDER BY p.dateline DESC
				LIMIT ' . intval($max_items);

		$query = $database->query($sql);
		
		if($database->is_error()) {
			echo $database->get_error();
			return 0;
		}

		if($query->numRows() > 0)
		{
			$out .= '<div id="mod_last_forum_entries">' . $heading;

			while($f = $query->fetchRow())
			{
				$out .= '<div class="mod_last_forum_hits_f">';
				$out .= '<a href="'.
					   WB_URL.'/modules/forum/thread_view.php?goto=' .
					   $f['postid'].'"  class="mod_last_forum_entries_hits_link_f">';
				$out .= '<span class="mod_last_forum_entries_hits_forum_f">'. $f['forum'] . '</span>';
				$out .= '<span class="mod_last_forum_entires_hits_devider_f">' . $owd_devider .'</span>';
				$out .= '<span class="mod_last_forum_entries_hits_title_f">'. $f['title'] . '</span>';
				$out .= '</a>';
				$out .= '</div>';
				$out .= '<p class="mod_last_forum_entries_hits_text_f">'.  owd_mksubstr ( strip_bbcode($f['text']), $max_chars) . '</p>';

			}
			$out .= '</div>';
		}


		echo $out;

	}

}

?>