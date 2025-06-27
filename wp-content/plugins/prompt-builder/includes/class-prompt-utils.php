<?php

class Prompt_Builder_Utils {
	// Monta o prompt final a partir do texto base e dos requisitos
	public static function gerar_prompt( string $base, array $requisitos ): string {
		$base   = trim( strip_tags( $base ) );
		$linhas = array( $base );

		foreach ( $requisitos as $chave => $valor ) {
			$chave    = trim( strip_tags( $chave ) );
			$valor    = trim( strip_tags( $valor ) );
			$linhas[] = "{$chave}: {$valor}";
		}

		return implode( "\n", $linhas );
	}
}
