async function loadModels() {
    const MODEL_URL = 'https://cdn.jsdelivr.net/npm/@vladmandic/face-api@latest/model';
    try {
        console.log("Carregando modelos de IA para feedback visual (versão leve)...");
        await faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL);
        console.log("Modelos carregados com sucesso!");
    } catch (error) {
        console.error("Erro ao carregar modelos da face-api.js", error);
    }
}

export async function startFaceDetection() {
    await loadModels();

    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    if (!video || !canvas) return;

    video.addEventListener('play', () => {
        const displaySize = { width: video.width, height: video.height };
        faceapi.matchDimensions(canvas, displaySize);

        setInterval(async () => {
            const detections = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions());

            if (detections) {
                const resizedDetections = faceapi.resizeResults(detections, displaySize);
                canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
                faceapi.draw.drawDetections(canvas, resizedDetections);
            } else {
                canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
            }
        }, 100);
    });
}