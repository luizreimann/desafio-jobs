<div class="wrap container mt-4">
	<h1 class="mb-4"><?php esc_html_e( 'Prompt Builder', 'prompt-builder' ); ?></h1>

	<form id="prompt-builder-form" class="mb-3">
	<div class="mb-3">
		<label for="pb-briefing" class="form-label">Prompt Base</label>
		<textarea id="pb-briefing" class="form-control" rows="4" placeholder="Digite o prompt base..."></textarea>
	</div>

	<div id="pb-requisitos-container" class="mb-3">
		<!-- Requisitos dinâmicos via JS -->
	</div>

	<button type="button" id="pb-add-requisito" class="btn btn-outline-primary mb-3">+ Adicionar Requisito</button>

	<div class="d-flex gap-2">
		<button type="submit" class="btn btn-success">Gerar Prompt</button>
		<button type="button" id="pb-create-draft" class="btn btn-secondary">Criar Rascunho de Post</button>
	</div>
	</form>

	<div class="mb-3">
	<label class="form-label">Prompt Gerado</label>
	<textarea readonly id="pb-prompt-gerado" class="form-control" rows="6"></textarea>
	</div>

	<div id="pb-draft-status" class="mt-3 text-success fw-bold"></div>
</div>