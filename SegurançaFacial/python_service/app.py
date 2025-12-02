import os
import base64
import io
import numpy as np
import face_recognition
from flask import Flask, request, jsonify
from dotenv import load_dotenv
from PIL import Image

load_dotenv()
app = Flask(__name__)

script_dir = os.path.dirname(os.path.abspath(__file__))

FACES_DIR = os.path.join(script_dir, 'known_faces')

if not os.path.exists(FACES_DIR):
    os.makedirs(FACES_DIR)


def base64_to_image(base64_string):
    if "base64," in base64_string:
        base64_string = base64_string.split("base64,")[1]
    img_data = base64.b64decode(base64_string)
    return Image.open(io.BytesIO(img_data))

@app.route('/add_face', methods=['POST'])
def add_face():
    data = request.json
    if not data or 'image' not in data or 'id_responsavel' not in data or 'index' not in data:
        return jsonify({"success": False, "error": "Dados inválidos"}), 400
    try:
        id_responsavel = data['id_responsavel']
        index = data['index']
        image = base64_to_image(data['image'])
        image_np = np.array(image)
        face_encodings = face_recognition.face_encodings(image_np)
        if len(face_encodings) > 0:
            encoding = face_encodings[0]
            filepath = os.path.join(FACES_DIR, f"{id_responsavel}_{index}.npy")
            np.save(filepath, encoding)
            return jsonify({"success": True, "message": f"Rosto (amostra {index}) cadastrado."})
        else:
            return jsonify({"success": False, "error": "Nenhum rosto encontrado na imagem."}), 400
    except Exception as e:
        return jsonify({"success": False, "error": str(e)}), 500

@app.route('/recognize_face', methods=['POST'])
def recognize_face():
    data = request.json
    if not data or 'image' not in data:
        return jsonify({"success": False, "error": "Imagem não fornecida."}), 400
    try:
        known_face_encodings = []
        known_face_ids = []
        for filename in os.listdir(FACES_DIR):
            if filename.endswith(".npy"):
                filepath = os.path.join(FACES_DIR, filename)
                encoding = np.load(filepath)
                known_face_encodings.append(encoding)
                responsavel_id = os.path.splitext(filename)[0].split('_')[0]
                known_face_ids.append(responsavel_id)
        if not known_face_encodings:
            return jsonify({"success": False, "error": "Nenhum rosto cadastrado no sistema."})
        unknown_image = base64_to_image(data['image'])
        unknown_image_np = np.array(unknown_image)
        unknown_encodings = face_recognition.face_encodings(unknown_image_np)
        if len(unknown_encodings) > 0:
            unknown_encoding = unknown_encodings[0]
            matches = face_recognition.compare_faces(known_face_encodings, unknown_encoding, tolerance=0.55)
            face_distances = face_recognition.face_distance(known_face_encodings, unknown_encoding)
            best_match_index = np.argmin(face_distances)
            if matches[best_match_index]:
                matched_id = known_face_ids[best_match_index]
                return jsonify({"success": True, "id_responsavel": int(matched_id)})
            else:
                return jsonify({"success": False, "message": "Nenhuma correspondência encontrada."})
        else:
            return jsonify({"success": False, "message": "Nenhum rosto detectado na imagem."})
    except Exception as e:
        return jsonify({"success": False, "error": str(e)}), 500

if __name__ == '__main__':
    host = os.getenv('FLASK_HOST', '127.0.0.1')
    port = int(os.getenv('FLASK_PORT', 5000))
    app.run(host=host, port=port, debug=True)