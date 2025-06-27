<?php

require_once __DIR__ . '/../includes/class-prompt-utils.php';

class Prompt_Builder_REST {
	public static function register_routes() {
		register_rest_route(
			'prompt-builder/v1',
			'/generate',
			array(
				'methods'             => 'POST',
				'callback'            => array( self::class, 'handle_generate' ),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			)
		);

		register_rest_route(
			'prompt-builder/v1',
			'/create-draft',
			array(
				'methods'             => 'POST',
				'callback'            => array( self::class, 'create_draft_post' ),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			)
		);
	}

	public static function handle_generate( $request ) {
		$params = $request->get_json_params();

		$prompt_base = sanitize_textarea_field( $params['prompt_base'] ?? '' );
		$requisitos  = $params['requisitos'] ?? array();

		if ( ! is_array( $requisitos ) ) {
			return new WP_Error( 'invalid_requisitos', 'Requisitos inválidos.', array( 'status' => 400 ) );
		}

		$lines = array( $prompt_base );

		foreach ( $requisitos as $key => $value ) {
			$clean_key   = sanitize_text_field( $key );
			$clean_value = sanitize_text_field( $value );
			$lines[]     = "{$clean_key}: {$clean_value}";
		}

		$prompt_final = Prompt_Builder_Utils::gerar_prompt( $prompt_base, $requisitos );

		return rest_ensure_response(
			array(
				'prompt' => $prompt_final,
			)
		);
	}

	public static function create_draft_post( $request ) {
		$params  = $request->get_json_params();
		$content = sanitize_textarea_field( $params['content'] ?? '' );

		if ( ! $content ) {
			return new WP_Error( 'empty_content', 'Conteúdo não pode estar vazio.', array( 'status' => 400 ) );
		}

		$post_id = wp_insert_post(
			array(
				'post_title'   => 'Prompt Gerado ' . current_time( 'Y-m-d H:i' ),
				'post_content' => $content,
				'post_status'  => 'draft',
				'post_type'    => 'post',
			)
		);

		if ( is_wp_error( $post_id ) ) {
			return new WP_Error( 'insert_failed', 'Falha ao criar rascunho.', array( 'status' => 500 ) );
		}

		return rest_ensure_response(
			array(
				'success' => true,
				'post_id' => $post_id,
			)
		);
	}
}
