<?php

class Prompt_Builder_Utils {
    public static function gerar_prompt(string $base, array $requisitos): string {
        $base = trim(strip_tags($base));
        $linhas = [$base];

        foreach ($requisitos as $chave => $valor) {
            $chave = trim(strip_tags($chave));
            $valor = trim(strip_tags($valor));
            $linhas[] = "{$chave}: {$valor}";
        }

        return implode("\n", $linhas);
    }
}