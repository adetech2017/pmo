<?php
/**
 * Plugin Name: Create Sample Programmes
 * Description: Creates sample programmes for demonstration
 */

add_action('init', function() {
    // Only run once
    if (get_transient('sample_programmes_created')) {
        return;
    }

    $programmes = [
        [
            'title' => 'Lagos Bus Rapid Transit System Enhancement',
            'content' => 'The Lagos Bus Rapid Transit (BRT) System Enhancement programme focuses on improving the efficiency, capacity, and sustainability of the state\'s public transportation infrastructure. This strategic initiative aims to enhance service delivery, reduce urban congestion, and promote economic activities across the state through modern, efficient, and customer-centric public transportation solutions.',
            'code' => 'PROG-2024-001',
            'status' => 'In Progress',
            'budget' => '₦2.5 Billion',
            'beneficiaries' => '2 Million+ Daily Commuters',
            'completion' => 45,
        ],
        [
            'title' => 'Healthcare Infrastructure Modernization Initiative',
            'content' => 'This programme aims to modernize healthcare delivery systems across Lagos State by upgrading health facilities, deploying advanced medical equipment, and strengthening institutional capacity. The initiative focuses on providing quality, accessible, and affordable healthcare services to all residents.',
            'code' => 'PROG-2024-002',
            'status' => 'Planned',
            'budget' => '₦3.2 Billion',
            'beneficiaries' => '3 Million+ Residents',
            'completion' => 10,
        ],
        [
            'title' => 'Education Excellence and Institutional Development',
            'content' => 'A comprehensive programme designed to transform the education sector through curriculum enhancement, teacher capacity development, infrastructure modernization, and institutional governance improvement. The initiative aims to produce graduates equipped with 21st-century skills.',
            'code' => 'PROG-2024-003',
            'status' => 'Active',
            'budget' => '₦1.8 Billion',
            'beneficiaries' => '500,000+ Students',
            'completion' => 60,
        ],
    ];

    foreach ($programmes as $prog) {
        $post_id = wp_insert_post([
            'post_type' => 'pmo_project',
            'post_title' => $prog['title'],
            'post_content' => $prog['content'],
            'post_status' => 'publish',
            'post_excerpt' => substr($prog['content'], 0, 100) . '...',
        ]);

        if ($post_id) {
            update_post_meta($post_id, '_pmo_project_code', $prog['code']);
            update_post_meta($post_id, '_pmo_project_status', $prog['status']);
            update_post_meta($post_id, '_pmo_budget', $prog['budget']);
            update_post_meta($post_id, '_pmo_beneficiaries', $prog['beneficiaries']);
            update_post_meta($post_id, '_pmo_completion_percentage', $prog['completion']);
            update_post_meta($post_id, '_pmo_funding_source', 'Lagos State Government');
            update_post_meta($post_id, '_pmo_start_date', '2024-01-15');
            update_post_meta($post_id, '_pmo_end_date', '2025-12-31');
        }
    }

    set_transient('sample_programmes_created', true, 3600);
});
