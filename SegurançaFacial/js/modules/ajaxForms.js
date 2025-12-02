export function setupAjaxForm(formId, statusDivId, onSuccessCallback = null) {
    const form = document.getElementById(formId);
    const statusDiv = document.getElementById(statusDivId);
    const submitBtn = form.querySelector('button[type="submit"]');

    if (!form || !statusDiv || !submitBtn) return;

    form.addEventListener('submit', async (event) => {
        event.preventDefault(); 

        const originalBtnText = submitBtn.innerHTML;
        submitBtn.innerHTML = 'Salvando...';
        submitBtn.disabled = true;
        statusDiv.style.display = 'none';

        try {
            const formData = new FormData(form);

            const response = await fetch(form.action, {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            statusDiv.innerHTML = result.message;
            statusDiv.className = `status-message ${result.success ? 'success' : 'error'}`;
            statusDiv.style.display = 'block';

            if (result.success) {
                form.reset(); 
                if (onSuccessCallback) {
                    onSuccessCallback();
                }
            }
        } catch (error) {
            statusDiv.innerHTML = 'Ocorreu um erro de comunicação. Tente novamente.';
            statusDiv.className = 'status-message error';
            statusDiv.style.display = 'block';
            console.error('Erro no formulário AJAX:', error);
        } finally {
            submitBtn.innerHTML = originalBtnText;
    
            if(!statusDiv.classList.contains('success')) {
                submitBtn.disabled = false;
            }
        }
    });
}