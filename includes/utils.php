<?php
//get link to page with template
function basic_get_template_page_link($template_file)
{
    $url = null;

    $pages = query_posts(array(
        'post_type' => 'page',
        'meta_key'  => '_wp_page_template',
        'meta_value' => $template_file,
    ));

    if (isset($pages[0])) {
        $url = get_permalink($pages[0]->ID);
    }
    return $url;
}

/**
 * Function for autoloading script files, whitout order
 * $folders - folders for scan 
 */
function basic_autoload_scripts(array $folders)
{
    $except = array('.', '..');

    foreach ($folders as $one) {
        $files = scandir($one);
        foreach ($files as $item) {
            if (!in_array($item, $except)) {
                require_once($one . '/' . $item);
            }
        }
    }
}

//check if user is author of item
function basic_is_item_author($post_obj)
{
    $acf_item_owner = get_field('owner', $post_obj->ID) == get_current_user_id();
    $post_author = $post_obj->post_author == get_current_user_id();
    return $acf_item_owner || $post_author;
}

//upload image
function insert_attachment($file_path, $file_name, $parent_post_id = null)
{
    $file_type = wp_check_filetype($file_name, null);
    $attachment_title = sanitize_file_name(pathinfo($file_name, PATHINFO_FILENAME));
    $wp_upload_dir = wp_upload_dir();

    $post_info = array(
        'guid'           => $wp_upload_dir['url'] . '/' . $file_name,
        'post_mime_type' => $file_type['type'],
        'post_title'     => $attachment_title,
        'post_content'   => '',
        'post_status'    => 'inherit',
    );
    $destination_path = $wp_upload_dir['path'] . '/' . basename($file_name);

    // Create the attachment
    $attach_id = wp_insert_attachment($post_info, $destination_path, $parent_post_id);
    if ($attach_id) {
        move_uploaded_file($file_path, $destination_path);
    }
    // Include image.php
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    // Define attachment metadata
    $attach_data = wp_generate_attachment_metadata($attach_id, $destination_path);
    // Assign metadata to attachment
    wp_update_attachment_metadata($attach_id,  $attach_data);
    return $attach_id;
}

//whether array is associative
function is_assoc(array $arr)
{
    if (array() === $arr) return false;
    return array_keys($arr) !== range(0, count($arr) - 1);
}

//custom pagination
function basic_pagination($pages = '', $range = 2)
{
    $showitems = ($range * 2) + 1;

    global $paged;
    if (empty($paged)) $paged = 1;

    if ($pages == '') {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if (!$pages) {
            $pages = 1;
        }
    }

    if (1 != $pages) {
        echo '<ul class="pagination justify-content-center">';
        if ($paged > 2 && $paged > $range + 1 && $showitems < $pages) echo "<a class='page-link' tabindex='-1' href='" . get_pagenum_link(1) . "'>&laquo;</a>";
        if ($paged > 1 && $showitems < $pages) echo "<a href='" . get_pagenum_link($paged - 1) . "'>&lsaquo;</a>";
        for ($i = 1; $i <= $pages; $i++) {
            if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
                $current = '<li class="active"><span>' . $i . '<span class="sr-only">(current)</span></span></li>';
                $page = '<li class=""><a href="' . get_pagenum_link($i) . '">' . $i . '<span class="sr-only">(current)</span></a></li>';
                echo ($paged == $i) ? $current : $page;
            }
        }
        $next = '<li><a href=' . get_pagenum_link($paged + 1) . '><span aria-hidden="true"><i class="fa fa-angle-right"></i></span></a></li>';
        if ($paged < $pages && $showitems < $pages) echo $next;
        if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages) echo "<a href='" . get_pagenum_link($pages) . "'>&raquo;</a>";
        echo '</ul>';
    }
}

/*
 <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">&laquo;</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">...</a></li>
                <li class="page-item"><a class="page-link" href="#">5</a></li>
                <li class="page-item active"><a class="page-link" href="#">6</a></li>
                <li class="page-item"><a class="page-link" href="#">7</a></li>
                <li class="page-item"><a class="page-link" href="#">...</a></li>
                <li class="page-item"><a class="page-link" href="#">10</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">&raquo;</a>
                </li>
            </ul>
*/