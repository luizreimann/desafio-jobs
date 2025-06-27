<?php

use PHPUnit\Framework\TestCase;

class PromptGeneratorTest extends TestCase {

	// Testa um prompt com requisitos simples e base preenchida
	public function test_prompt_basico() {
		$base       = 'Explique como funciona um motor a combustão.';
		$requisitos = array(
			'Tom'      => 'Técnico',
			'Extensão' => '800 palavras',
		);

		$esperado  = "Explique como funciona um motor a combustão.\nTom: Técnico\nExtensão: 800 palavras";
		$resultado = Prompt_Builder_Utils::gerar_prompt( $base, $requisitos );

		$this->assertEquals( $esperado, $resultado );
	}

	// Testa um prompt vazio sem requisitos
	public function test_prompt_vazio() {
		$base       = '';
		$requisitos = array();

		$resultado = Prompt_Builder_Utils::gerar_prompt( $base, $requisitos );

		$this->assertEquals( '', $resultado );
	}

	// Verifica se tags HTML são removidas corretamente do prompt
	public function test_prompt_html_injetado() {
		$base       = "<script>alert('xss')</script>";
		$requisitos = array(
			'<b>Chave</b>' => '<i>valor</i>',
		);

		$resultado = Prompt_Builder_Utils::gerar_prompt( $base, $requisitos );

		$this->assertStringNotContainsString( '<', $resultado );
		$this->assertStringContainsString( 'Chave: valor', $resultado );
	}
}
