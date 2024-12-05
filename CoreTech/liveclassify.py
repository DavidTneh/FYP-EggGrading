import os
import tensorflow as tf
import numpy as np
from tensorflow.keras.models import load_model
from tensorflow.keras.preprocessing.image import img_to_array
import sys
import io
from PIL import Image

os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3'

# Load the model
model_path = r"C:\Users\User\Documents\FYP\FYP-EggGrading\storage\weighML28Nov\optimized_weight_model.h5"
model = load_model(model_path)

def preprocess_image(image_data):
    img = Image.open(io.BytesIO(image_data))
    img = img.resize((128, 128))
    img_array = img_to_array(img) / 255.0
    return np.expand_dims(img_array, axis=0)

def classify_image(image_data):
    input_data = preprocess_image(image_data)
    prediction = model.predict(input_data)
    return int(np.argmax(prediction))

if __name__ == "__main__":
    image_data = sys.stdin.buffer.read()
    try:
        result = classify_image(image_data)
        print(result)
    except Exception as e:
        print(f"Error: {e}", file=sys.stderr)
        sys.exit(1)
