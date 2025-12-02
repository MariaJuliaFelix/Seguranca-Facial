import { startVideo, captureFrameAsBase64 } from './camera.js';
import { startFaceDetection } from './faceFeedback.js';

export function setupReconhecimento() {
    startVideo();
    startFaceDetection();
    const resultadoEl = document.getElementById('resultado');
    const video = document.getElementById('video');
    let isProcessing = false;

    setInterval(async () => {
        if (isProcessing || video.paused || video.ended || !video.srcObject) return;
        isProcessing = true;

        const imageData = captureFrameAsBase64();
        
        try {
            const response = await fetch('../php/processa_reconhecimento.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ image: imageData })
            });
            const result = await response.json();

            if (result.success) {
                let alunosHtml = '<ul>';
                result.alunos.forEach(aluno => {
                    alunosHtml += `<li><strong>${aluno.nome_completo}</strong> (Turma: ${aluno.turma})</li>`;
                });
                alunosHtml += '</ul>';

                resultadoEl.innerHTML = `
                    <p class="success">Responsável Reconhecido!</p>
                    <p><strong>Nome:</strong> ${result.responsavel.nome_completo}</p>
                    <p><strong>Crianças associadas:</strong></p>
                    ${alunosHtml}
                    <p><strong>LIBERAÇÃO AUTORIZADA <u>para o(s) aluno(s) listado(s) acima.</u></strong></p>
                `;
            } else {
                resultadoEl.innerText = result.message || "Procurando rosto...";
                resultadoEl.className = "status-message";
            }
        } catch (error) {
            console.error('Erro:', error);
            resultadoEl.innerText = "Erro ao comunicar com o servidor. Verifique o console (F12).";
            resultadoEl.className = "status-message error";
        }
        isProcessing = false;
    }, 2000);
}