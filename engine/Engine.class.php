<?php

/**
 * MySmartBB Engine
 */

// ... //

// General systems

// ... //

/*if (is_array($CALL_SYSTEM))
{
	// ... //
	
	$files = array();
	
	$files[] = (isset($CALL_SYSTEM['INFO'])) 				? 'info.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['ADS'])) 				? 'ads.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['ANNOUNCEMENT'])) 		? 'announcement.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['AVATAR'])) 				? 'avatar.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['BANNED'])) 				? 'banned.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['GROUP'])) 				? 'group.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['MEMBER'])) 				? 'member.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['ONLINE'])) 				? 'online.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['PAGES'])) 				? 'pages.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['PM'])) 					? 'pm.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['REPLY'])) 				? 'reply.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['SEARCH'])) 				? 'search.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['SECTION'])) 			? 'sections.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['STYLE'])) 				? 'style.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['SUBJECT'])) 			? 'subject.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['CACHE'])) 				? 'cache.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['REQUEST'])) 			? 'request.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['MISC'])) 				? 'misc.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['MESSAGE'])) 			? 'messages.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['ATTACH'])) 				? 'attach.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['FIXUP'])) 				? 'fixup.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['FILESEXTENSION'])) 		? 'extension.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['USERTITLE'])) 			? 'usertitle.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['ICONS'])) 				? 'icons.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['TOOLBOX'])) 			? 'toolbox.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['MODERATORS'])) 			? 'moderators.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['POLL'])) 				? 'poll.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['VOTE'])) 				? 'vote.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['TAG'])) 				? 'tags.class.php' : null;
	$files[] = (isset($CALL_SYSTEM['BOOKMARK'])) 			? 'bookmark.class.php' : null;
	
	// ... //

	if (sizeof($files) > 0)
	{
		foreach ($files as $filename)
		{
			if (!is_null($filename))
			{
				require_once(DIR . 'engine/systems/' . $filename);
			}
		}
	}
	
	// ... //
}*/

// ... //

class Engine
{
}

?>
