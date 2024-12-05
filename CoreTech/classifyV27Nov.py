import os
import tensorflow as tf
import numpy as np
from tensorflow.keras.models import load_model
from tensorflow.keras.preprocessing import image
import sys
import absl.logging

# Suppress TensorFlow and Abseil logs
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3'
tf.get_logger().setLevel('ERROR')
absl.logging.set_verbosity(absl.logging.ERROR)

# Load the model
model_path = "C:/Users/User/Documents/FYP/FYP-EggGrading/storage/vNov27/egg_quality_model.h5"

if not os.path.exists(model_path):
    print(f"Model file not found at {model_path}")
    sys.exit(1)

model = load_model(model_path)

def preprocess_image(img_path):
    img = image.load_img(img_path, target_size=(128, 128))  # Match model input size
    img_array = image.img_to_array(img) / 255.0  # Normalize to [0, 1]
    return np.expand_dims(img_array, axis=0)

if len(sys.argv) < 2:
    print("No image path provided.")
    sys.exit(1)

image_path = sys.argv[1]
if not os.path.exists(image_path):
    print(f"Image file not found: {image_path}")
    sys.exit(1)

try:
    input_data = preprocess_image(image_path)
    prediction = model.predict(input_data, verbose=0)  # Suppress progress bars
    predicted_class = int(np.argmax(prediction))
    print(predicted_class)  # Output only the prediction
except Exception as e:
    print(f"Error during prediction: {e}")
