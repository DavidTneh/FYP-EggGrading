import os
import tensorflow as tf
import numpy as np
from tensorflow.keras.models import load_model
from tensorflow.keras.preprocessing.image import load_img, img_to_array
import sys
import absl.logging

# Suppress TensorFlow and Abseil logs
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3'
tf.get_logger().setLevel('ERROR')
absl.logging.set_verbosity(absl.logging.ERROR)

# Path to the trained model
model_path = r"C:\Users\User\Documents\FYP\FYP-EggGrading\storage\weighML28Nov\weightModel.h5"

# Check if model exists
if not os.path.exists(model_path):
    print(f"Error: Model file not found at {model_path}")
    sys.exit(1)

# Load the trained model
try:
    model = load_model(model_path)
except Exception as e:
    print(f"Error loading model: {e}")
    sys.exit(1)

# Function to preprocess the image
def preprocess_image(img_path, target_size=(128, 128)):
    """
    Preprocess an image for prediction.
    Args:
        img_path (str): Path to the input image.
        target_size (tuple): Target size for resizing the image.
    Returns:
        numpy.ndarray: Preprocessed image ready for prediction.
    """
    try:
        img = load_img(img_path, target_size=target_size)  # Load and resize the image
        img_array = img_to_array(img) / 255.0  # Normalize pixel values
        return np.expand_dims(img_array, axis=0)  # Add batch dimension
    except Exception as e:
        print(f"Error preprocessing image: {e}")
        sys.exit(1)

# Validate command-line arguments
if len(sys.argv) < 2:
    print("Usage: python classifyV28Nov.py <image_path>")
    sys.exit(1)

# Input image path
image_path = sys.argv[1]

# Check if the image file exists
if not os.path.exists(image_path):
    print(f"Error: Image file not found: {image_path}")
    sys.exit(1)

# Predict the class of the image
try:
    input_data = preprocess_image(image_path)
    prediction = model.predict(input_data, verbose=0)  # Generate prediction
    predicted_class = int(np.argmax(prediction))  # Get the predicted class
    print(predicted_class)  # Output the predicted class
except Exception as e:
    print(f"Error during prediction: {e}")
    sys.exit(1)
