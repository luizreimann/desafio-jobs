<?php

class Prompt_Builder {
	// Inicializa hooks e rotas REST
	public function init() {
		add_action( 'admin_menu', array( $this, 'register_admin_page' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		require_once plugin_dir_path( __FILE__ ) . 'class-prompt-rest.php';
		add_action( 'rest_api_init', array( 'Prompt_Builder_REST', 'register_routes' ) );
	}

	// Registra a página no menu de ferramentas do admin
	public function register_admin_page() {
		add_submenu_page(
			'tools.php',
			__( 'Prompt Builder', 'prompt-builder' ),
			__( 'Prompt Builder', 'prompt-builder' ),
			'manage_options',
			'prompt-builder',
			array( $this, 'render_admin_page' )
		);
	}

	// Carrega o conteúdo da página do plugin
	public function render_admin_page() {
		include plugin_dir_path( __DIR__ ) . 'admin/prompt-builder-page.php';
	}

	// Adiciona os estilos e scripts da interface do plugin
	public function enqueue_assets( $hook ) {
		if ( strpos( $hook, 'prompt-builder' ) === false ) {
			return;
		}

		wp_enqueue_style( 'bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' );
		wp_enqueue_style( 'prompt-builder-css', plugin_dir_url( __DIR__ ) . 'assets/css/admin.css' );

		wp_enqueue_script( 'bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array(), null, true );
		wp_enqueue_script( 'prompt-builder-js', plugin_dir_url( __DIR__ ) . 'assets/js/admin.js', array(), false, true );

		wp_localize_script(
			'prompt-builder-js',
			'PB_VARS',
			array(
				'nonce'        => wp_create_nonce( 'wp_rest' ),
				'restUrl'      => esc_url_raw( rest_url( 'prompt-builder/v1/generate' ) ),
				'restUrlDraft' => esc_url_raw( rest_url( 'prompt-builder/v1/create-draft' ) ),
			)
		);
	}
}
