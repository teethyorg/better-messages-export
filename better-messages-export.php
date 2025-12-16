<?php
/**
 * Plugin Name: Better Messages Personal Data Export (Messages Only)
 * Plugin URI: https://teethy.org
 * Description: Export Better Messages messages for WP Personal Data Export.
 * Version: 1.1
 * Author: teethy
 * Author URI: https://teethy.org
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('ABSPATH')) exit;

add_filter('wp_privacy_personal_data_exporters', 'bm_export_register');

function bm_export_register($exporters) {
    $exporters['better_messages'] = [
        'exporter_friendly_name' => __('Better Messages', 'bm'),
        'callback'               => 'bm_export_user_data'
    ];
    return $exporters;
}

function bm_export_user_data($email, $page = 1) {
    global $wpdb;

    $user = get_user_by('email', $email);
    if (!$user) return ['data'=>[], 'done'=>true];
    $user_id = $user->ID;

    $limit  = 200;
    $offset = ($page - 1) * $limit;

    $messages_table = $wpdb->prefix . 'bm_message_messages';
    $meta_table     = $wpdb->prefix . 'bm_message_meta';

    $data = [];

    /*--------------------------------------------------------------
     * EXPORT MESSAGES
     *--------------------------------------------------------------*/
    $messages = $wpdb->get_results($wpdb->prepare(
        "SELECT id, thread_id, message, date_sent 
        FROM {$messages_table} 
        WHERE sender_id = %d 
        ORDER BY date_sent DESC 
        LIMIT %d OFFSET %d",
        $user_id, $limit, $offset
    ), ARRAY_A);

    foreach ($messages as $msg) {
        $item_data = [
            'Thread ID' => $msg['thread_id'],
            'Message'   => $msg['message'],
            'Date Sent' => $msg['date_sent']
        ];
        $data[] = [
            'group_id'    => 'bm_messages',
            'group_label' => __('Better Messages – Messages', 'bm'),
            'item_id'     => 'bm_message-' . $msg['id'],
            'data'        => array_map(
                fn($k, $v) => ['name' => $k, 'value' => $v],
                array_keys($item_data),
                $item_data
            )
        ];
    }

    /*--------------------------------------------------------------
     * EXPORT META
     *--------------------------------------------------------------*/
    $meta = $wpdb->get_results($wpdb->prepare(
        "SELECT bm_message_id, meta_key, meta_value 
        FROM {$meta_table} 
        WHERE bm_message_id IN (
            SELECT id FROM {$messages_table} WHERE sender_id = %d
        )
        ORDER BY bm_message_id 
        LIMIT %d OFFSET %d",
        $user_id, $limit, $offset
    ), ARRAY_A);

    foreach ($meta as $m) {
        $item_data = [
            'Message ID' => $m['bm_message_id'],
            'Meta Key'   => $m['meta_key'],
            'Meta Value' => $m['meta_value']
        ];
        $data[] = [
            'group_id'    => 'bm_meta',
            'group_label' => __('Better Messages – Meta', 'bm'),
            'item_id'     => 'bm_meta-' . $m['bm_message_id'] . '-' . $m['meta_key'],
            'data'        => array_map(
                fn($k, $v) => ['name' => $k, 'value' => $v],
                array_keys($item_data),
                $item_data
            )
        ];
    }

    /*--------------------------------------------------------------
     * DONE FLAG
     * (Recipients removed from logic)
     *--------------------------------------------------------------*/
    $done = count($messages) < $limit && count($meta) < $limit;

    return [
        'data' => $data,
        'done' => $done
    ];
}
