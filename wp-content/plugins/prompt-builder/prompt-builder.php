<?php
/**
 * Plugin Name: Prompt Builder
 * Description: Gera prompts estruturados para posts com base em briefing e requisitos.
 * Version: 1.0.0
 * Author: Luiz Reimann
 * Author URI: https://luizreimann.dev/
 * Text Domain: prompt-builder
 */

if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'includes/class-prompt-builder.php';

function pb_init_plugin() {
    $plugin = new Prompt_Builder();
    $plugin->init();
}
add_action('plugins_loaded', 'pb_init_plugin');