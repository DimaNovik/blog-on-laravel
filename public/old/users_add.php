    <?php
    /**
    * @ignore
    */

    @set_time_limit(0);
    //@ignore_user_abort(true);
    @ini_set('memory_limit', '64M');

    define('IN_PHPBB', true);
    $phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
    $phpEx = substr(strrchr(__FILE__, '.'), 1);
    include($phpbb_root_path . 'common.' . $phpEx);
    include_once($phpbb_root_path . 'includes/functions_user.' . $phpEx);

    // Start session management
    $user->session_begin();
    $auth->acl($user->data);
    $user->setup();

    $users_start = request_var('us', 0);
    $users_step = request_var('up', 50);

    $users_data = array();

    $users_counter = 0;
    $handle = fopen('users_to_add.csv', 'r');
    while (($data = fgetcsv($handle, 0, ',')) !== false)
    {
       $num = count($data);
       for ($c = 0; $c < $num; $c++)
       {
          $users_data[$users_counter][$c] = $data[$c];
       }
       $users_counter++;
    }
    fclose($handle);

    //include($phpbb_root_path . 'users_to_add.' . $phpEx);

    $users_list = '';
    $total_users = count($users_data);
    $users_this_step = min($users_start + $users_step, $total_users);
    $users_this_step = ($users_this_step == 0) ? $total_users : $users_this_step;
    $new_start = $users_start;

    $users_fields_name = array('username', 'user_password', 'user_email', 'group_id', 'user_lang', 'user_type', 'user_regdate');
    for ($i = $users_start; $i < $users_this_step; $i++)
    {
       $users_fields_values = array($users_data[$i][0], phpbb_hash($users_data[$i][1]), $users_data[$i][2], '2', 'en', '0', time());
       for ($j = 0; $j < count($users_fields_name); $j++)
       {
          $users_data[$i][$j] = (empty($users_data[$i][$j])) ? $users_fields_values[$j] : $users_data[$i][$j];
          $users_data[$i][$users_fields_name[$j]] = $users_fields_values[$j];
          unset($users_data[$i][$j]);
       }
       $user_id = user_add($users_data[$i]);
       if ($user_id !== false)
       {
          $users_list .= (($users_list == '') ? '' : ', ') . $users_data[$i]['username'];
       }
       $new_start++;
    }

    $message_text = 'Следующие пользователи были добавлены в базу данных:<br /><br />' . $users_list;

    if ($new_start >= $total_users)
    {
       $message = 'Все указанные пользователи были успешно добавлены!<br /><br />' . $message_text;
       $template->assign_vars(array(
          'MESSAGE_TITLE' => 'Добавление пользователей',
          'MESSAGE_TEXT' => $message
          )
       );
       page_header('Добавление пользователей');
       $template->set_filenames(array('body' => 'message_body.html'));
       page_footer();
    }
    else
    {
       $meta_url = append_sid("{$phpbb_root_path}users_add.$phpEx", "us=$new_start&amp;up=$users_step");
       meta_refresh(3, $meta_url);
       $message = 'Процесс добавления пользователей еще не закончен. Данная страница автоматически обновится через несколько секунд. Пожалуйста, подождите…<br /><br />' . $message_text;
       trigger_error($message);
       exit;
    }

    ?>