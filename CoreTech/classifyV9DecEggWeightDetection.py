import os
import tensorflow as tf
import numpy as np
from tensorflow.keras.models import load_model
from PIL import Image, ImageOps
import sys
import absl.logging
import hashlib
import time

# Suppress TensorFlow and Abseil logs
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3'
tf.get_logger().setLevel('ERROR')
absl.logging.set_verbosity(absl.logging.ERROR)

# Path to the trained model
model_path = r"C:\Users\User\Documents\FYP\FYP-EggGrading\storage\1DecEggWeightDetect\multi_task_model.keras"

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

# Label map for Egg Detection (Egg vs Non-Egg)
egg_label_map = {
    1: "Brown-egg", 
    2: "Non-egg", 
    3: "White-egg"
}

# Label map for Weight Classification (Different types of eggs)
weight_label_map = {
    1: "47.14g", 2: "47.17g", 3: "50.96g", 4: "50.96g", 5: "51.29g",
    6: "51.34g", 7: "51.38g", 8: "51.53g", 9: "51.90g", 10: "52.01g",
    11: "52.08g", 12: "52.41g", 13: "52.48g", 14: "52.65g", 15: "52.77g",
    16: "52.93g", 17: "56.31g", 18: "58.39g", 19: "59.23g", 20: "60.00g",
    21: "60.02g", 22: "60.04g", 23: "60.49g", 24: "60.56g", 25: "61.55g",
    26: "62.70g", 27: "63.51g", 28: "63.83g", 29: "64.00g", 30: "64.13g",
    31: "65.26g", 32: "66.05g", 33: "66.09g", 34: "66.41g", 35: "66.80g",
    36: "67.08g", 37: "67.10g", 38: "67.75g", 39: "67.83g", 40: "70.52g",
    41: "71.57g", 42: "73.23g", 43: "73.35g", 44: "73.41g", 45: "74.07g",
    46: "74.19g", 47: "74.32g", 48: "74.67g", 49: "74.89g", 50: "74.98g",
    51: "77.27g", 52: "80.64g", 53: "82.90g", 54: "89.50g", 55: "92.62g",
    56: "Legg", 57: "Megg", 58: "Segg", 59: "XLegg"
}

# Generate a unique hash for each image to prevent reprocessing the same image
def generate_image_hash(image_path):
    with open(image_path, "rb") as f:
        file_data = f.read()
        return hashlib.md5(file_data).hexdigest()

# Time-based check: only process the image every N seconds
last_processed_time = None
processing_interval = 10  # seconds

# Preprocess the image
def preprocess_image(img_path, target_size=(640, 640)):
    try:
        img = Image.open(img_path).convert("RGB")
        img = ImageOps.exif_transpose(img)

        # Resize while maintaining aspect ratio
        original_width, original_height = img.size
        target_width, target_height = target_size

        scale = min(target_width / original_width, target_height / original_height)
        new_width = int(original_width * scale)
        new_height = int(original_height * scale)

        img = img.resize((new_width, new_height), Image.Resampling.BILINEAR)

        # Create a new image with the target size and paste the resized image into the center
        new_img = Image.new("RGB", target_size, (0, 0, 0))  # Black background
        paste_position = ((target_width - new_width) // 2, (target_height - new_height) // 2)
        new_img.paste(img, paste_position)

        # Normalize pixel values
        img_array = np.array(new_img) / 255.0
        return new_img, np.expand_dims(img_array, axis=0)
    except Exception as e:
        sys.stderr.write(f"Error preprocessing image: {e}\n")
        sys.exit(1)

# Predict the class of the image
def predict_class(img_path, model):
    original_image, input_data = preprocess_image(img_path)
    predictions = model.predict(input_data, verbose=0)

    # Get both egg and weight predictions
    egg_prediction = np.argmax(predictions[0])  # Egg Detection output
    weight_prediction = np.argmax(predictions[1])  # Weight Classification output

    # Map the predictions to the corresponding labels
    egg_class = egg_label_map.get(egg_prediction + 1, "Unknown")  # Add 1 to match the label map indexing
    weight_class = weight_label_map.get(weight_prediction, "Unknown")

    return egg_class, weight_class

# Main function to prevent re-processing the same image within a short time
def process_image(image_path):
    global last_processed_time

    # Generate a hash for the current image
    image_hash = generate_image_hash(image_path)

    # Get the current time
    current_time = time.time()

    # If enough time has passed since the last processed image or the image has changed, process the new image
    if last_processed_time is None or current_time - last_processed_time > processing_interval or image_hash != last_processed_time[1]:
        try:
            # Predict the class ID and return the result
            egg_class, weight_class = predict_class(image_path, model)

            # Log the predictions and return the result
            print(f"Predicted Egg Class: {egg_class}")
            print(f"Predicted Weight Class: {weight_class}")
            last_processed_time = (current_time, image_hash)  # Update last processed time and image hash

        except Exception as e:
            sys.stderr.write(f"Error during prediction: {e}\n")
            sys.exit(1)
    else:
        print("Image has already been processed recently or is the same as before. Skipping re-processing.")

if __name__ == "__main__":
    # Validate command-line arguments
    if len(sys.argv) < 2:
        sys.stderr.write("Usage: python classifyV9DecEggWeightDetection.py <image_path>\n")
        sys.exit(1)

    # Input image path
    image_path = sys.argv[1]
    if not os.path.exists(image_path):
        sys.stderr.write(f"Error: Image file not found: {image_path}\n")
        sys.exit(1)

    # Call the image processing function
    process_image(image_path)
