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

class c_LastForumEntries
{
	protected	$version	= "0.4.0";
	protected	$guid		= "064F1FD5-2206-44C9-BF34-E5C9EDB64106";
	
	public $max_items = 5;
	public $max_chars = 50;
	public $owd_devider = ' &raquo; ';
	public $heading = '<h3>Last Postings</h3>';
	public $time_format = DEFAULT_DATE_FORMAT." - ".DEFAULT_TIME_FORMAT;
	public $only_this_section = 0;
	public $template_path = "";
	public $template_file = "frontend_view.lte";
	
	public function __construct( $options=array() ) {
		
		if(isset($options['max_items'])) $this->max_items = $options['max_items'];
		if(isset($options['max_chars'])) $this->max_chars = $options['max_chars'];
		if(isset($options['owd_devider'])) $this->owd_devider = $options['owd_devider'];
		if(isset($options['heading'])) $this->heading = $options['heading'];
		if(isset($options['time_format'])) $this->time_format = $options['time_format'];
		if(isset($options['only_this_section'])) $this->only_this_section = $options['only_this_section'];
	}
	
	public function toHTML() {
		
		global $wb;

		//	require_once WB_PATH . '/modules/forum/config.php';

		require_once (dirname(dirname(dirname(__FILE__)))."/forum/classes/class.subway.php");
		$subway = new subway(); 

		require_once $subway->CMS_PATH . '/modules/forum/functions.php';

		$temp_path = $subway->CMS_PATH."/templates/";
		$temp_path .= ( $wb->page['template'] == "" ? DEFAULT_TEMPLATE : $wb->page['template']);
		$temp_path .= "/frontend/LastForumEntries/";
		
		$template_path = (file_exists($temp_path."frontend_view.lte"))
			? $temp_path
			: dirname(dirname(__FILE__))."/templates/"
			;
		
		if( $this->template_path != "" ) $template_path = $this->template_path;
		
		$subway->template_path = $template_path;
		if( true === $subway->twig_loaded ) $subway->loader->prependPath(  $subway->template_path );
		
		$out = "";
		
		$section_addition = ($this->only_this_section == 0) ? "" : " WHERE f.section_id ='".$this->only_this_section."' ";
		
		$sql = 'SELECT f.title as forum,
				 p.postid, p.threadid, p.username,p.title,
				 p.dateline as datum, p.text,
				 p.page_id, p.section_id

				FROM '.TABLE_PREFIX.'mod_forum_post p
					JOIN  '.TABLE_PREFIX.'mod_forum_thread t USING(threadid)
					JOIN  '.TABLE_PREFIX.'mod_forum_forum f ON (t.forumid = f.forumid)
				'. $section_addition .'
				ORDER BY p.dateline DESC
				LIMIT ' . intval($this->max_items);

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
			$out .= '<div id="mod_last_forum_entries">' . $this->heading;

			foreach( $all_hits as &$f )
			{
			
				$values = array(
					'CMS_URL' => $subway->CMS_URL,
					'forum_postid'	=> $f['postid'],
					'forum_forum'	=> $f['forum'],
					'forum_title'	=> $f['title'],
					'forum_date'	=> date( $this->time_format, $f['datum']),
					'owd_devider'	=> $this->owd_devider,
					'forum_teaser' => owd_mksubstr ( strip_bbcode($f['text']), $this->max_chars)
				);
				
				$out .= $subway->render(
					$this->template_file, // 'frontend_view.lte',
					$values
				);
			}
			$out .= '</div>';
		}
		
		return $out;
	}
}

?>