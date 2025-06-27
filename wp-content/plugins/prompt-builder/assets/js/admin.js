document.addEventListener('DOMContentLoaded', () => {
   const form = document.getElementById('prompt-builder-form');
   const requisitosContainer = document.getElementById('pb-requisitos-container');
   const resultadoTextarea = document.getElementById('pb-prompt-gerado');

  // Adiciona campo de requisito
   function addRequisitoRow(key = '', value = '') {
   const row = document.createElement('div');
   row.className = 'row g-2 align-items-center mb-2';
   row.innerHTML = `
      <div class="col-sm-5">
         <input type="text" class="form-control" name="requisito_key[]" placeholder="Chave" value="${key}" />
      </div>
      <div class="col-sm-5">
         <input type="text" class="form-control" name="requisito_value[]" placeholder="Valor" value="${value}" />
      </div>
      <div class="col-sm-2">
         <button type="button" class="btn btn-outline-danger w-100 remove-requisito">Remover</button>
      </div>
   `;
   requisitosContainer.appendChild(row);
   }

   // Evento: adicionar novo requisito
   document.getElementById('pb-add-requisito').addEventListener('click', () => {
      addRequisitoRow();
   });

   // Evento: remover requisito
   requisitosContainer.addEventListener('click', (e) => {
      if (e.target.classList.contains('remove-requisito')) {
         const row = e.target.closest('.row');
         if (row) row.remove();
      }
   });

   // Evento: submit do formulário
   form.addEventListener('submit', (e) => {
         e.preventDefault();

         const promptBase = document.getElementById('pb-briefing').value;
         const keys = document.getElementsByName('requisito_key[]');
         const values = document.getElementsByName('requisito_value[]');

         const requisitos = {};
         for (let i = 0; i < keys.length; i++) {
         const key = keys[i].value.trim();
         const val = values[i].value.trim();
         if (key && val) requisitos[key] = val;
      }

      fetch(PB_VARS.restUrl, {
         method: 'POST',
         headers: {
         'Content-Type': 'application/json',
         'X-WP-Nonce': PB_VARS.nonce
      },
      body: JSON.stringify({
         prompt_base: promptBase,
         requisitos: requisitos
      })
      })
      .then(res => res.json())
      .then(data => {
         resultadoTextarea.value = data.prompt || 'Erro ao gerar prompt';
      })
      .catch(err => {
         resultadoTextarea.value = 'Erro: ' + err.message;
      });
   });

   document.getElementById('pb-create-draft').addEventListener('click', () => {
      const content = document.getElementById('pb-prompt-gerado').value;

      if (!content.trim()) {
         alert('Por favor, gere o prompt antes de criar o rascunho.');
         return;
      }

      fetch(PB_VARS.restUrlDraft, {
         method: 'POST',
         headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': PB_VARS.nonce
         },
         body: JSON.stringify({ content })
      })
      .then(res => res.json())
      .then(data => {
         const div = document.getElementById('pb-draft-status');
         if (data.success && data.post_id) {
            div.innerHTML = `Rascunho criado com sucesso! <a href="/wp-admin/post.php?post=${data.post_id}&action=edit" target="_blank">Editar</a>`;
         } else {
            div.innerText = 'Erro ao criar rascunho.';
         }
      })
      .catch(err => {
         document.getElementById('pb-draft-status').innerText = 'Erro: ' + err.message;
      });
   });
});