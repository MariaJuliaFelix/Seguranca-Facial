const video = document.getElementById('video');

export async function startVideo() {
    if (!video) return;
    try {
        const stream = await navigator.mediaDevices.getUserMedia({ video: {} });
        video.srcObject = stream;
    } catch (err) {
        console.error("Erro ao acessar a câmera: ", err);
    }
}

export function captureFrameAsBase64() {
    if (!video || !video.srcObject) return null;
    const canvas = document.createElement('canvas');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    const context = canvas.getContext('2d');
    context.drawImage(video, 0, 0, canvas.width, canvas.height);
    return canvas.toDataURL('image/jpeg', 0.9);
}