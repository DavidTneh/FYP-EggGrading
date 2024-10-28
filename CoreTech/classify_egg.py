import sys
import numpy as np
from tensorflow.keras.models import load_model
from tensorflow.keras.preprocessing import image
import os

# Load the model
model_path = os.path.join(os.getcwd(), 'public', 'storage', 'GradingModel', 'egg_quality_model.h5')
print("Current Working Directory:", os.getcwd())
print("Model Path:", model_path)

try:
    model = load_model(model_path)  # Use the absolute path
except Exception as e:
    print(f"Error loading model: {e}")
    sys.exit(1)

# Preprocess image function
def preprocess_image(img_path):
    img = image.load_img(img_path, target_size=(128, 128))
    img_array = image.img_to_array(img)
    img_array = np.expand_dims(img_array, axis=0)  # Add batch dimension
    img_array /= 255.0  # Normalize to [0, 1]
    return img_array

# Check for input image argument
if len(sys.argv) < 2:
    print("No image path provided.")
    sys.exit(1)

image_path = sys.argv[1]
processed_image = preprocess_image(image_path)

# Make prediction
predictions = model.predict(processed_image)
predicted_class = np.argmax(predictions, axis=1)[0]  # Get the index of the class with the highest probability

# Print the predicted class
print(predicted_class)
