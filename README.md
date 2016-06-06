
## LastForumEntries
Snippet to display the last forum entries (WB-Forum - Module)

##### Requirements
- WB 2.8.3 (sp6 recomented)
- WBCE 1.1.6 or later
- PHP >= 5.4
- Modul: Forum 0.5.9

##### Authors
"Herr Rilke", Dietrich Roland Pehlke (last) 


##### 2.1 call as function

````code
LastForumEntries (
	$max_items = 5,
	$max_chars=50,
	$owd_devider=\' &raquo; \',
	$heading=\'&lt;h3&gt;Letzte ForenBeitr&auml;ge&lt;/h3&gt;\',
	$time_format = DEFAULT_DATE_FORMAT." - ".DEFAULT_TIME_FORMAT
);			
````
or
````code
LastForumEntries( 5, 50, ' &raquo; ', '<h3>Letzte ForenBeitr&auml;ge</h3>', "d.m.Y - H:m", 24 );
````

##### 2.2 call OOP-like
````code
// get instance
$oForum = new forum_LastForumEntries();

//	overwrite/set some values direct
$oForum->time_format = "Y-m-d";
$oForum->only_this_section = 24;
$oForum->heading = "<h4>Die aktuellsten Beiträge</h4>";

//	get the entries
echo $oForum->toHTML();
````

##### 2.3 call for own templates
If you want to use your own template path and/or own template-file  
e.g. inside your frontend-template direct, you'll have to set the values  
direct via the instance e.g.

````code
if (class_exists("forum_LastForumEntries")) {
	$oForum = new forum_LastForumEntries();

	// set the own template path
	$oForum->template_path = __DIR__."/";
						
	// set the own template file
	$oForum->template_file = "aldus_view.lte";
						
	//	output
	echo $oForum->toHTML();
}
````
#### 2.4 Droplet
Example of a droplet
````code
$items = array('max_items','max_chars','owd_devider','heading', 'time_format','only_this_section','template_file');

$options = array();
foreach($items as &$i) if(isset( ${$i} )) $options[ $i ] = ${$i};

$oForum = new forum_LastForumEntries( $options );

return $oForum->toHTML();
````
Assumee you name it 'lastForumEntries' then you can 'call' it like e.g.:
````code
[[lastForumEntries?time_format=d.m.y]]
````
#### 2.4.1 Timeformats
As for the timeformats, this codesnippet use the [PHP-]"date" function, so  
please visit [PHP net :: date-manual](http://php.net/manual/en/function.date.php "date-manual") for details 



#### Brief changelog

##### 0.4.1
- Bugfixes for the use of constants prior PHP 5.6

##### 0.4.0
- Update header
- Requirements to Forum 0.5.9 (need "subway"-class and "parser" for templates)
- Add template for fronteendoutput
- Add new param for formating date and time

##### 0.3.1
- Bugfixes for WB 2.8.3 SP6 and WBCE

##### 0.3.0
- First initial commit on GitHub