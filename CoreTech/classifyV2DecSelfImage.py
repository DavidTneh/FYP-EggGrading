import os
import tensorflow as tf
import numpy as np
from tensorflow.keras.models import load_model
from PIL import Image, ImageOps
import sys
import absl.logging

# Suppress TensorFlow and Abseil logs
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3'
tf.get_logger().setLevel('ERROR')
absl.logging.set_verbosity(absl.logging.ERROR)

# Path to the trained model
model_path = r"C:\Users\User\Documents\FYP\FYP-EggGrading\storage\2DecSelfImage\sizeModel.keras"

# Check if model exists
if not os.path.exists(model_path):
    sys.stderr.write("Error: Model file not found.\n")
    sys.exit(1)

# Load the trained model
try:
    model = load_model(model_path)
except Exception as e:
    sys.stderr.write(f"Error loading model: {e}\n")
    sys.exit(1)

# Function to preprocess the image
def preprocess_image(img_path, target_size=(640, 640)):
    """
    Preprocess the image: auto-orient, resize (stretch), and normalize pixel values.
    Args:
        img_path (str): Path to the input image.
        target_size (tuple): Target size for resizing the image.
    Returns:
        numpy.ndarray: Preprocessed image ready for prediction.
    """
    try:
        img = Image.open(img_path)
        img = ImageOps.exif_transpose(img)  # Auto-orient
        img = img.resize(target_size, Image.Resampling.BILINEAR)  # Resize with stretch
        img_array = np.array(img) / 255.0  # Normalize
        if img_array.ndim == 2:  # Convert grayscale to RGB
            img_array = np.stack((img_array,)*3, axis=-1)
        return np.expand_dims(img_array, axis=0)  # Add batch dimension
    except Exception as e:
        sys.stderr.write(f"Error preprocessing image: {e}\n")
        sys.exit(1)

# Validate command-line arguments
if len(sys.argv) < 2:
    sys.stderr.write("Usage: python classifyV2DecSelfImage.py <image_path>\n")
    sys.exit(1)

# Input image path
image_path = sys.argv[1]
if not os.path.exists(image_path):
    sys.stderr.write(f"Error: Image file not found: {image_path}\n")
    sys.exit(1)

# Predict the class of the image
try:
    input_data = preprocess_image(image_path)
    prediction = model.predict(input_data, verbose=0)
    predicted_class = int(np.argmax(prediction))  # Get the predicted class ID
    print(predicted_class)  # Output only the predicted class ID
except Exception as e:
    sys.stderr.write(f"Error during prediction: {e}\n")
    sys.exit(1)
