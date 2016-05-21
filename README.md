
## LastForumEntries
Snippet to display the last forum entries (WB-Forum - Module)

##### Requirements
- WB 2.8.3 (sp6 recomented)
- WB(CE) 1.1.6
- PHP >= 5.4
- Modul: Forum 0.5.9

##### Authors
"Herr Rilke", Dietrich Roland Pehlke (last) 


##### call

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
or OOP-like
````code
// get instance
$oForum = new c_LastForumEntries();

//	overwrite/set some values direct
$oForum->time_format = "Y-m-d";
$oForum->only_this_section = 24;
$oForum->heading = "<h4>Die aktuellsten Beiträge</h4>";

//	get the entries
echo $oForum->toHTML();
````


#### Brief changelog

##### 0.4.0
- Update header
- Requirements to Forum 0.5.9 (need "subway"-class and "parser" for templates)
- Add template for fronteendoutput
- Add new param for formating date and time

##### 0.3.1
- Bugfixes for WB 2.8.3 SP6 and WB(CE)

##### 0.3.0
- First initial commit on GitHub