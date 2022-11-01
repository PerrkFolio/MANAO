<?php
/*
 * Добавляем новое меню в Админ Консоль
 */

// Хук событие 'admin_menu', запуск функции 'yoomoney_wp_Add_My_Admin_Link()'
add_action( 'admin_menu', 'yoomoney_wp_Add_My_Admin_Link' ); 

// Добавляем новую ссылку в меню Админ Консоли
function yoomoney_wp_Add_My_Admin_Link()
{
 add_menu_page(
 'Yoomoney Настройки', // Название страниц (Title)
 'Yoomoney', // Текст ссылки в меню
 'manage_options', // Требование к возможности видеть ссылку
 'yoomoney-wp/admin/partials/yoomoney-wp-admin-display.php' // 'slug' - файл отобразится по нажатию на ссылку
 );
}