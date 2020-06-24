<?php
define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';


$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);

include($phpbb_root_path . 'includes/functions_display.' . $phpEx);


// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup('viewforum');
echo "<br>config=".$config['load_moderators'];
display_forums('', $config['load_moderators']);

