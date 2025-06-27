<?php

use PHPUnit\Framework\TestCase;

class PromptGeneratorTest extends TestCase {

    public function test_prompt_basico() {
        $base = "Explique como funciona um motor a combustão.";
        $requisitos = [
            'Tom' => 'Técnico',
            'Extensão' => '800 palavras'
        ];

        $esperado = "Explique como funciona um motor a combustão.\nTom: Técnico\nExtensão: 800 palavras";
        $resultado = Prompt_Builder_Utils::gerar_prompt($base, $requisitos);

        $this->assertEquals($esperado, $resultado);
    }

    public function test_prompt_vazio() {
        $base = "";
        $requisitos = [];

        $resultado = Prompt_Builder_Utils::gerar_prompt($base, $requisitos);

        $this->assertEquals("", $resultado);
    }

    public function test_prompt_html_injetado() {
        $base = "<script>alert('xss')</script>";
        $requisitos = [
            "<b>Chave</b>" => "<i>valor</i>"
        ];

        $resultado = Prompt_Builder_Utils::gerar_prompt($base, $requisitos);

        $this->assertStringNotContainsString('<', $resultado);
        $this->assertStringContainsString("Chave: valor", $resultado);
    }
}