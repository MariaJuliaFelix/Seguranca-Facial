import { startVideo, captureFrameAsBase64 } from './camera.js';
import { setupAjaxForm } from './ajaxForms.js'; 

export function setupCadastro() {
    startVideo();
    const captureBtns = document.querySelectorAll('.capture-btn');
    const submitBtn = document.getElementById('submitBtn');
    
    if (!submitBtn) return; 
    const capturedImages = { 1: false, 2: false, 3: false, 4: false, 5: false };

    captureBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const targetInputId = btn.getAttribute('data-target');
            const imageField = document.getElementById(targetInputId);
            const previewImgId = 'preview_' + targetInputId.slice(-1);
            const previewImg = document.getElementById(previewImgId);
            const imageData = captureFrameAsBase64();

            if (imageData) {
                imageField.value = imageData;
                previewImg.src = imageData;
                previewImg.classList.add('visible');
                btn.style.backgroundColor = '#28a745';
                capturedImages[targetInputId.slice(-1)] = true;

                const allCaptured = Object.values(capturedImages).every(status => status === true);
                if (allCaptured) {
                    submitBtn.disabled = false;
                    const tempStatus = document.getElementById('status');
                    if(tempStatus) tempStatus.innerText = "Todas as 5 fotos foram capturadas! Pode salvar.";
                }
            }
        });
    });

    function resetCadastroVisual() {
        captureBtns.forEach(btn => btn.style.backgroundColor = '');
        document.querySelectorAll('.preview-img').forEach(img => {
            img.src = '';
            img.classList.remove('visible');
        });
        
        for (let key in capturedImages) {
            capturedImages[key] = false;
        }

        submitBtn.disabled = true;
        const tempStatus = document.getElementById('status');
        if(tempStatus) tempStatus.innerText = "Capture as 5 fotos para salvar.";
    }

    
    setupAjaxForm('cadastroForm', 'formStatus', resetCadastroVisual);
}