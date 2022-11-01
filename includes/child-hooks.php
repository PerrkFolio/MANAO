<?php

//login
add_action('wp_ajax_nopriv_basic_login', 'basic_login_handler');
if (!function_exists('basic_login_handler')) {
    function basic_login_handler()
    {
        $out = [];

        $login = filter_input(INPUT_POST, 'login');
        $password = filter_input(INPUT_POST, 'password');

        $user_id = basic_login_user($login, $password);
        if (is_wp_error(($user_id))) {
            $out['message'] = $user_id->get_error_message();
        } else {
            wp_send_json_success($out);
        }
        wp_send_json_error($out);
    }
}

//registration
add_action('wp_ajax_nopriv_basic_registration', 'basic_registration_handler');
if (!function_exists('basic_registration_handler')) {
    function basic_registration_handler()
    {
        $out = [];

        $email = filter_input(INPUT_POST, 'email');
        $name = filter_input(INPUT_POST, 'name');
        $password = filter_input(INPUT_POST, 'password');
        $password_match = filter_input(INPUT_POST, 'password2');

        if (strcmp($password, $password_match) === 0) {
            $user_id = basic_register_user($name, $password, $email);
            if (is_wp_error(($user_id))) {
                $out['message'] = $user_id->get_error_message();
            } else {
                basic_login_user($email, $password); //user login
                wp_send_json_success($out);
            }
        } else {
            $out['message'] = 'Пароли не совпадают!';
        }
        wp_send_json_error($out);
    }
}

//change reset password url
add_filter('lostpassword_url',  'basic_lostpassword_url', 10, 1);
if (!function_exists('basic_lostpassword_url')) {
    function basic_lostpassword_url($url)
    {
        $url = basic_get_template_page_link('page-password-reset.php') ?: $url;
        return $url;
    }
}

//reset password send link
add_action('wp_ajax_nopriv_basic_password_reset_send', 'basic_password_reset_send_handler');
if (!function_exists('basic_password_reset_send_handler')) {
    function basic_password_reset_send_handler()
    {
        $out = [];

        $email = filter_input(INPUT_POST, 'email');

        $found = get_user_by('email', $email);
        if ($found !== false) {
            $reset_key = get_password_reset_key($found);

            $user_login = $found->user_login;
            $reset_page_link = basic_get_template_page_link('page-password-reset.php');
            $reset_link = $reset_page_link . "?key=$reset_key&login=$user_login";

            $message = "Ссылка на востановление пароля:\n$reset_link";
            wp_mail($found->user_email, 'Восстановление пароля', $message);

            wp_send_json_success($out);
        } else {
            $out['message'] = 'Данные email не существует';
        }

        wp_send_json_error($out);
    }
}

//reset password create
add_action('wp_ajax_nopriv_basic_password_reset_create', 'basic_password_reset_create_handler');
if (!function_exists('basic_password_reset_create_handler')) {
    function basic_password_reset_create_handler()
    {
        $out = [];

        $user_login = filter_input(INPUT_POST, 'login');
        $reset_key = filter_input(INPUT_POST, 'key');
        $password = filter_input(INPUT_POST, 'password');
        $password_match = filter_input(INPUT_POST, 'password2');

        $user = check_password_reset_key($reset_key, $user_login);

        if (is_wp_error($user)) {
            $out['message'] = $user->get_error_message();
        } else {
            if (strcmp($password, $password_match) === 0) {
                wp_set_password($password, $user->ID);
                wp_send_json_success($out);
            } else {
                $out['message'] = 'Пароли не совпадают!';
            }
        }
        wp_send_json_error($out);
    }
}

//items modal content

//create
add_action('wp_ajax_basic_create_item', 'basic_create_item_handler');
if (!function_exists('basic_create_item_handler')) {
    function basic_create_item_handler()
    {
        if (is_user_logged_in()) {
            $out = [];
            ob_start();
            get_template_part('parts/item/profile/modal/create');
            $html = ob_get_clean();
            $out['html'] = $html;
            wp_send_json_success($out);
        }
        wp_send_json_error();
    }
}

//edit
add_action('wp_ajax_basic_edit_item', 'basic_edit_item_handler');
if (!function_exists('basic_edit_item_handler')) {
    function basic_edit_item_handler()
    {
        if (is_user_logged_in()) {
            $out = [];
            $post_id = filter_input(INPUT_POST, 'post_id');
            $post = get_post($post_id);
            if ($post && basic_is_item_author($post)) {
                ob_start();
                include(locate_template('parts/item/profile/modal/edit.php'));
                $html = ob_get_clean();
                $out['html'] = $html;
                wp_send_json_success($out);
            }
        }
        wp_send_json_error();
    }
}

//store
add_action('wp_ajax_basic_store_item', 'basic_store_item_handler');
if (!function_exists('basic_store_item_handler')) {
    function basic_store_item_handler()
    {
        if (is_user_logged_in()) {
            $out['success'] = true;

            $post_data = $_POST;
            unset($post_data['action']);

            $user_id = get_current_user_id();
            $post = array(
                'post_author' => $user_id,
                'post_status' => "publish",
            );

            //filling params
            foreach ($post_data as $key => $value) {
                if ($key != 'meta') {
                    $post[$key] = $value;
                }
            }
            //update post
            if (!isset($post['ID'])) {
                //creating
                $post_id = wp_insert_post($post);
                $post['ID'] = $post_id;

                basic_top_item_in_time($post['ID']); //creating post, initing post system-time
            } else {
                //editing 

                //in archive
                if (has_term('in-archive', 'task_type', $post['ID'])){
                    basic_top_item_in_time($post['ID']); //to top
                }
                
                wp_update_post($post);
            }

            //update meta
            foreach ($post_data as $key => $value) {
                if ($key == 'meta') {

                    if (is_email($_POST['email_to_buy'])) {
                        $email = $_POST['email_to_buy'];
                        update_field('contacts', $email);
                    }else{
                        if (is_email($_POST['contacts'])) {
                            $email = $_POST['contacts'];
                            update_field('contacts', $email);
                        }else{
                            $email = get_userdata($user_id)->user_email; // Тут берется через get_userdata($user_id)->user_email
                        }
                    }

                    foreach ($value as $val_key => $val) {
                        if ($val_key == 'premium' && get_field($val_key, $post['ID']) == false) {
                            $premium_item_product = get_field('premium_item_product', 'options');
                            if ($premium_item_product) {
                                $price = get_field('premium_price', 'options');
                                $pay_title = 'Покупка Premium';
                                $payment_method = $_POST['payment_method'];

//                                var_dump($premium_item_product);
//                                var_dump($post['ID']);
//                                var_dump($email);
//                                var_dump($price);
//                                var_dump($pay_title);
//                                var_dump($payment_method);

//                                $payment_method - тута NULL, должно быть какое-то значение от сюад  D:\Call-Of-Duty-Mobile.su\wp-content\themes\basic-child\parts\item\profile\modal\create.php

                                $out['pay_link'] = get_pay_link($premium_item_product, $post['ID'], $email, $price, $pay_title, $payment_method);
                            }
                            continue;
                        }else if($val_key == 'to_top'){
                            $premium_item_product = get_field('to_top_item_product', 'options');
                            if ($premium_item_product) {
                                $out['pay_link'] = create_premium_checkout_link($premium_item_product, $post['ID']);
                            }
                            continue;
                        }
                        update_post_meta($post['ID'], $val_key, $val);
                    }
                }
            }

            //upload files
            $allowed_file_types = ['image/jpeg', 'image/jpg', 'image/png'];
            $allowed_file_size = 10485760; //10mb
            foreach ($_FILES as $key => $files) {

                $file_path = $files['tmp_name'];
                $file_name = $files['name'];
                if (!empty($file_path)) {
                    if (in_array($files['type'], $allowed_file_types) && $allowed_file_size >= $files['size']) {
                        $attachment_id = insert_attachment($file_path, $file_name);
                        $old_attachment = get_field($key, $post['ID']);
                        if ($attachment_id) {
                            if ($old_attachment) {
                                wp_delete_attachment($old_attachment['ID'], true);
                            }
                            update_field($key, $attachment_id, $post['ID']);
                        }
                    } else {
                        $out['success'] = false;
                        $out['message'] = 'Файл слишком большой или неверный формат';
                    }
                }
            }

            //moderation
            if(get_field('moderation', 'options')){
                $taxonomy = 'item_type';
                $moderating_term = get_term_by('slug', 'in-moderation', $taxonomy);
                wp_set_object_terms($post['ID'], $moderating_term->term_id, $taxonomy, true);
            }

            if ($out['success']) {
                wp_send_json_success($out);
            } else {
                wp_send_json_error($out);
            }
        }
        wp_send_json_error();
    }
}

//delete
add_action('wp_ajax_basic_delete_item', 'basic_delete_item_handler');
if (!function_exists('basic_delete_item_handler')) {
    function basic_delete_item_handler()
    {
        if (is_user_logged_in()) {
            $out = [];
            $post_id = filter_input(INPUT_POST, 'post_id');
            $post = get_post($post_id);
            if ($post && basic_is_item_author($post)) {
                if (wp_delete_post($post_id)) {
                    wp_send_json_success($out);
                }
            }
        }
        wp_send_json_error();
    }
}

add_action('wp_ajax_nopriv_basic_filter_items', 'basic_filter_items_handler');
add_action('wp_ajax_basic_filter_items', 'basic_filter_items_handler');

if (!function_exists('basic_filter_items_handler')) {
    function basic_filter_items_handler()
    {
        global $wp_query, $paged;

        $post_data = $_POST;
        unset($post_data['action']);

        $html = '';

        $exclude_terms = array('in-archive');

        //if moderation is enabled
        if (get_field('moderation', 'options')) {
            $exclude_terms[] = 'in-moderation';
        }

        $args = [
            'post_type' => 'item',
            'posts_per_page' => 10,
            'paged' => $post_data['paged'],
            'tax_query' => [
                [
                    'taxonomy' => 'item_type',
                    'field' => 'slug',
                    'terms' => $exclude_terms,
                    'operator' => 'NOT IN',
                ],
            ],
            'meta_query' => [
                'relation' => 'AND'
            ],
        ];

        unset($post_data['paged']);

        //sorting
        if (isset($post_data['orderby'])) {
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = array_keys($post_data['orderby'])[0];
            $args['order'] = array_values($post_data['orderby'])[0];
        }

        //meta fields
        if (isset($post_data['meta'])) {
            foreach ($post_data['meta'] as $key => $values) {
                if (is_assoc($values)) {
                    foreach ($values as $compare => $value) {
                        if (empty($value) == false) {
                            $args['meta_query'][] = [
                                'key' => $key,
                                'compare' => "$compare",
                                'value' => "$value"
                            ];
                        }
                    }
                } else {
                    $args['meta_query'][] = [
                        'key' => $key,
                        'compare' => "IN",
                        'value' => array_values($values)
                    ];
                }
            }
        }

        $query = new WP_Query($args);
        $wp_query = $query;

        //premium first
        while ($query->have_posts()) {
            $query->the_post();
            if (get_field('premium')) {
                $template_part = get_field('premium') ? '-premium' : '';
                ob_start();
                get_template_part('parts/item/item', 'loop' . $template_part);
                $html .= ob_get_clean();
            }
        }

        //regular another
        while ($query->have_posts()) {
            $query->the_post();
            if (get_field('premium') == false) {
                $template_part = get_field('premium') ? '-premium' : '';
                ob_start();
                get_template_part('parts/item/item', 'loop' . $template_part);
                $html .= ob_get_clean();
            }
        }

        ob_start();
        the_posts_pagination();
        $breadcrumbs = ob_get_clean();

        wp_reset_query();

        $out = [
            'html' => $html,
            'message' => $query->found_posts,
            'pagination' => $breadcrumbs
        ];

        wp_send_json_success($out);
    }
}

add_action('wp_ajax_basic_user_settings', 'basic_user_settings_handler');
if (!function_exists('basic_user_settings_handler')) {
    function basic_user_settings_handler()
    {
        $out = [
            'message' => ''
        ];
        $user = get_userdata(get_current_user_id());

        if (is_wp_error($user)) {
            $out['message'] = $user->get_error_message();
            wp_send_json_error($out);
        } else {
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            //changeing email if filled
            if ($email) {
                $args = array(
                    'ID' => get_current_user_id(),
                    'user_email' => $email
                );
                $user_id = wp_update_user($args);
                if (is_wp_error($user_id)) {
                    $out['message'] = $user_id->get_error_message();
                    wp_send_json_error($out);
                }
            }

            $old_password = filter_input(INPUT_POST, 'old_password');
            //if password need's to be changed
            if ($old_password) {
                if (wp_check_password($old_password, $user->data->user_pass)) {
                    $password = filter_input(INPUT_POST, 'password');
                    wp_set_password($password, get_current_user_id());
                } else {
                    $out['message'] = 'Неверный пароль';
                    wp_send_json_error($out);
                }
            }
        }
        wp_send_json_success($out);
    }
}

//menu dynamic item
add_filter( 'wp_nav_menu_items', 'basic_dynamic_item', 10, 2 );
function basic_dynamic_item( $items, $args ) {
    //main menu
    if($args->theme_location == 'top'){
        $items .= '<div class="dynamic-menu-item"><img alt="" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBzdGFuZGFsb25lPSJubyI/Pgo8IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPgo8c3ZnIHdpZHRoPSI0MHB4IiBoZWlnaHQ9IjQwcHgiIHZpZXdCb3g9IjAgMCA0MCA0MCIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4bWw6c3BhY2U9InByZXNlcnZlIiBzdHlsZT0iZmlsbC1ydWxlOmV2ZW5vZGQ7Y2xpcC1ydWxlOmV2ZW5vZGQ7c3Ryb2tlLWxpbmVqb2luOnJvdW5kO3N0cm9rZS1taXRlcmxpbWl0OjEuNDE0MjE7IiB4PSIwcHgiIHk9IjBweCI+CiAgICA8ZGVmcz4KICAgICAgICA8c3R5bGUgdHlwZT0idGV4dC9jc3MiPjwhW0NEQVRBWwogICAgICAgICAgICBALXdlYmtpdC1rZXlmcmFtZXMgc3BpbiB7CiAgICAgICAgICAgICAgZnJvbSB7CiAgICAgICAgICAgICAgICAtd2Via2l0LXRyYW5zZm9ybTogcm90YXRlKDBkZWcpCiAgICAgICAgICAgICAgfQogICAgICAgICAgICAgIHRvIHsKICAgICAgICAgICAgICAgIC13ZWJraXQtdHJhbnNmb3JtOiByb3RhdGUoLTM1OWRlZykKICAgICAgICAgICAgICB9CiAgICAgICAgICAgIH0KICAgICAgICAgICAgQGtleWZyYW1lcyBzcGluIHsKICAgICAgICAgICAgICBmcm9tIHsKICAgICAgICAgICAgICAgIHRyYW5zZm9ybTogcm90YXRlKDBkZWcpCiAgICAgICAgICAgICAgfQogICAgICAgICAgICAgIHRvIHsKICAgICAgICAgICAgICAgIHRyYW5zZm9ybTogcm90YXRlKC0zNTlkZWcpCiAgICAgICAgICAgICAgfQogICAgICAgICAgICB9CiAgICAgICAgICAgIHN2ZyB7CiAgICAgICAgICAgICAgICAtd2Via2l0LXRyYW5zZm9ybS1vcmlnaW46IDUwJSA1MCU7CiAgICAgICAgICAgICAgICAtd2Via2l0LWFuaW1hdGlvbjogc3BpbiAxLjVzIGxpbmVhciBpbmZpbml0ZTsKICAgICAgICAgICAgICAgIC13ZWJraXQtYmFja2ZhY2UtdmlzaWJpbGl0eTogaGlkZGVuOwogICAgICAgICAgICAgICAgYW5pbWF0aW9uOiBzcGluIDEuNXMgbGluZWFyIGluZmluaXRlOwogICAgICAgICAgICB9CiAgICAgICAgXV0+PC9zdHlsZT4KICAgIDwvZGVmcz4KICAgIDxnIGlkPSJvdXRlciI+CiAgICAgICAgPGc+CiAgICAgICAgICAgIDxwYXRoIGQ9Ik0yMCwwQzIyLjIwNTgsMCAyMy45OTM5LDEuNzg4MTMgMjMuOTkzOSwzLjk5MzlDMjMuOTkzOSw2LjE5OTY4IDIyLjIwNTgsNy45ODc4MSAyMCw3Ljk4NzgxQzE3Ljc5NDIsNy45ODc4MSAxNi4wMDYxLDYuMTk5NjggMTYuMDA2MSwzLjk5MzlDMTYuMDA2MSwxLjc4ODEzIDE3Ljc5NDIsMCAyMCwwWiIgc3R5bGU9ImZpbGw6YmxhY2s7Ii8+CiAgICAgICAgPC9nPgogICAgICAgIDxnPgogICAgICAgICAgICA8cGF0aCBkPSJNNS44NTc4Niw1Ljg1Nzg2QzcuNDE3NTgsNC4yOTgxNSA5Ljk0NjM4LDQuMjk4MTUgMTEuNTA2MSw1Ljg1Nzg2QzEzLjA2NTgsNy40MTc1OCAxMy4wNjU4LDkuOTQ2MzggMTEuNTA2MSwxMS41MDYxQzkuOTQ2MzgsMTMuMDY1OCA3LjQxNzU4LDEzLjA2NTggNS44NTc4NiwxMS41MDYxQzQuMjk4MTUsOS45NDYzOCA0LjI5ODE1LDcuNDE3NTggNS44NTc4Niw1Ljg1Nzg2WiIgc3R5bGU9ImZpbGw6cmdiKDIxMCwyMTAsMjEwKTsiLz4KICAgICAgICA8L2c+CiAgICAgICAgPGc+CiAgICAgICAgICAgIDxwYXRoIGQ9Ik0yMCwzMi4wMTIyQzIyLjIwNTgsMzIuMDEyMiAyMy45OTM5LDMzLjgwMDMgMjMuOTkzOSwzNi4wMDYxQzIzLjk5MzksMzguMjExOSAyMi4yMDU4LDQwIDIwLDQwQzE3Ljc5NDIsNDAgMTYuMDA2MSwzOC4yMTE5IDE2LjAwNjEsMzYuMDA2MUMxNi4wMDYxLDMzLjgwMDMgMTcuNzk0MiwzMi4wMTIyIDIwLDMyLjAxMjJaIiBzdHlsZT0iZmlsbDpyZ2IoMTMwLDEzMCwxMzApOyIvPgogICAgICAgIDwvZz4KICAgICAgICA8Zz4KICAgICAgICAgICAgPHBhdGggZD0iTTI4LjQ5MzksMjguNDkzOUMzMC4wNTM2LDI2LjkzNDIgMzIuNTgyNCwyNi45MzQyIDM0LjE0MjEsMjguNDkzOUMzNS43MDE5LDMwLjA1MzYgMzUuNzAxOSwzMi41ODI0IDM0LjE0MjEsMzQuMTQyMUMzMi41ODI0LDM1LjcwMTkgMzAuMDUzNiwzNS43MDE5IDI4LjQ5MzksMzQuMTQyMUMyNi45MzQyLDMyLjU4MjQgMjYuOTM0MiwzMC4wNTM2IDI4LjQ5MzksMjguNDkzOVoiIHN0eWxlPSJmaWxsOnJnYigxMDEsMTAxLDEwMSk7Ii8+CiAgICAgICAgPC9nPgogICAgICAgIDxnPgogICAgICAgICAgICA8cGF0aCBkPSJNMy45OTM5LDE2LjAwNjFDNi4xOTk2OCwxNi4wMDYxIDcuOTg3ODEsMTcuNzk0MiA3Ljk4NzgxLDIwQzcuOTg3ODEsMjIuMjA1OCA2LjE5OTY4LDIzLjk5MzkgMy45OTM5LDIzLjk5MzlDMS43ODgxMywyMy45OTM5IDAsMjIuMjA1OCAwLDIwQzAsMTcuNzk0MiAxLjc4ODEzLDE2LjAwNjEgMy45OTM5LDE2LjAwNjFaIiBzdHlsZT0iZmlsbDpyZ2IoMTg3LDE4NywxODcpOyIvPgogICAgICAgIDwvZz4KICAgICAgICA8Zz4KICAgICAgICAgICAgPHBhdGggZD0iTTUuODU3ODYsMjguNDkzOUM3LjQxNzU4LDI2LjkzNDIgOS45NDYzOCwyNi45MzQyIDExLjUwNjEsMjguNDkzOUMxMy4wNjU4LDMwLjA1MzYgMTMuMDY1OCwzMi41ODI0IDExLjUwNjEsMzQuMTQyMUM5Ljk0NjM4LDM1LjcwMTkgNy40MTc1OCwzNS43MDE5IDUuODU3ODYsMzQuMTQyMUM0LjI5ODE1LDMyLjU4MjQgNC4yOTgxNSwzMC4wNTM2IDUuODU3ODYsMjguNDkzOVoiIHN0eWxlPSJmaWxsOnJnYigxNjQsMTY0LDE2NCk7Ii8+CiAgICAgICAgPC9nPgogICAgICAgIDxnPgogICAgICAgICAgICA8cGF0aCBkPSJNMzYuMDA2MSwxNi4wMDYxQzM4LjIxMTksMTYuMDA2MSA0MCwxNy43OTQyIDQwLDIwQzQwLDIyLjIwNTggMzguMjExOSwyMy45OTM5IDM2LjAwNjEsMjMuOTkzOUMzMy44MDAzLDIzLjk5MzkgMzIuMDEyMiwyMi4yMDU4IDMyLjAxMjIsMjBDMzIuMDEyMiwxNy43OTQyIDMzLjgwMDMsMTYuMDA2MSAzNi4wMDYxLDE2LjAwNjFaIiBzdHlsZT0iZmlsbDpyZ2IoNzQsNzQsNzQpOyIvPgogICAgICAgIDwvZz4KICAgICAgICA8Zz4KICAgICAgICAgICAgPHBhdGggZD0iTTI4LjQ5MzksNS44NTc4NkMzMC4wNTM2LDQuMjk4MTUgMzIuNTgyNCw0LjI5ODE1IDM0LjE0MjEsNS44NTc4NkMzNS43MDE5LDcuNDE3NTggMzUuNzAxOSw5Ljk0NjM4IDM0LjE0MjEsMTEuNTA2MUMzMi41ODI0LDEzLjA2NTggMzAuMDUzNiwxMy4wNjU4IDI4LjQ5MzksMTEuNTA2MUMyNi45MzQyLDkuOTQ2MzggMjYuOTM0Miw3LjQxNzU4IDI4LjQ5MzksNS44NTc4NloiIHN0eWxlPSJmaWxsOnJnYig1MCw1MCw1MCk7Ii8+CiAgICAgICAgPC9nPgogICAgPC9nPgo8L3N2Zz4K" /></div>';
    }
    return $items;
}

add_action('wp_ajax_nopriv_basic_dynamic_menu_item', 'basic_dynamic_menu_item_handler');
add_action('wp_ajax_basic_dynamic_menu_item', 'basic_dynamic_menu_item_handler');
if (!function_exists('basic_dynamic_menu_item_handler')) {
    function basic_dynamic_menu_item_handler()
    {
        $html = '';
        if(is_user_logged_in()){
            $profile_page_link = basic_get_template_page_link('page-profile.php');
            $profile_settings_link = basic_get_template_page_link('page-profile-settings.php');
            $logout_link = wp_logout_url('/');
            $html = '<li class="dynamic-menu-item-inited profile-page-button menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children"><a href="#">Кабинет</a><span class="open-submenu"></span>
            <ul class="sub-menu">
            <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="' . $profile_page_link . '">Мои объявления</a></li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="' . $profile_settings_link . '">Настройки профиля</a></li>
        <li class="menu-item menu-item-type-custom menu-item-object-custom"><a href="' . $logout_link . '">Выход</a></li>
    </ul>
    </li>';   
        }else{
            $login_page_link = basic_get_template_page_link('page-login.php');
            $html = '<li class="dynamic-menu-item-inited login-page-button menu-item menu-item-type-post_type menu-item-object-page"><a href="' . $login_page_link . '">Вход</a></li>';
        }
        wp_send_json_success($html);
    }
}

add_action('wp_ajax_nopriv_check_login', 'check_login_handler');
add_action('wp_ajax_check_login', 'check_login_handler');
if (!function_exists('check_login_handler')) {
    function check_login_handler()
    {
        $t_or_f = true;
        if(is_user_logged_in()){
            wp_send_json_success($t_or_f);  
        }else{
            $t_or_f = false;
			wp_send_json_success($t_or_f);
        }
    }
}

add_action('wp_ajax_nopriv_basic_filter_items_profile', 'basic_filter_items_profile_handler');
add_action('wp_ajax_basic_filter_items_profile', 'basic_filter_items_profile_handler');

if(!function_exists('basic_filter_items_profile_handler')){
    function basic_filter_items_profile_handler(){
        global $wp_query;
        $post_data = $_POST;

        $args = [
            'post_type' => 'item',
            'posts_per_page' => 10,
            'paged' => $post_data['paged'],
            'meta_query' => [
                [
                    'key' => 'owner',
                    'value' => get_current_user_id(),
                ],
            ]
        ];
        $query = new WP_Query($args);
        $wp_query = $query;

        ob_start();
        while ($query->have_posts()) {
            $query->the_post();
            $template_part = get_field('premium') ? '-premium' : '';
            get_template_part('parts/item/profile/item', 'loop' . $template_part);
        }
        the_posts_pagination();
        $html = ob_get_clean();
        wp_reset_query();

        $out['html'] = $html;

        wp_send_json_success($out);
    }
}

add_action('wp_ajax_nopriv_basic_success', 'basic_success_handler');
add_action('wp_ajax_basic_success', 'basic_success_handler');
if(!function_exists('basic_success_handler')){
    function basic_success_handler(){
        wp_send_json_success([]);
     }
}

add_action('wp_ajax_basic_get_thank_you_page_text', 'basic_get_thank_you_page_text_handler');
if(!function_exists('basic_get_thank_you_page_text_handler')){
    function basic_get_thank_you_page_text_handler(){
        $out = [];
        if(get_field('moderation', 'options')){
            $out['message'] = '<p>Ваше объявление успешно принято и проходит модерацию</p>';
        }else{
            $out['message'] = '<p>Ваше объявление поднято</p>';
        }
        wp_send_json_success($out);
     }
}


// foreach(get_posts(['post_type' => 'item']) as $one){
//     basic_top_item_in_time($one->ID);
// }
