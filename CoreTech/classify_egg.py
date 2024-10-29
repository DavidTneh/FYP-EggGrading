import sys
import os
from tensorflow.keras.models import load_model
from tensorflow.keras.preprocessing import image
import numpy as np

# Load the model
model_directory = 'storage/eggGradingModel'  # Update path as necessary
model_path = os.path.join(model_directory, 'egg_quality_model.h5')

try:
    model = load_model(model_path)
    print("Model loaded successfully.")
except Exception as e:
    print(f"Error loading model: {e}")
    sys.exit(1)

# Preprocess image function
def preprocess_image(img_path):
    try:
        img = image.load_img(img_path, target_size=(128, 128))
        img_array = image.img_to_array(img)
        img_array = np.expand_dims(img_array, axis=0)
        img_array /= 255.0  # Normalize to [0, 1]
        return img_array
    except Exception as e:
        print(f"Error preprocessing image: {e}")
        sys.exit(1)

# Check for input image argument
if len(sys.argv) < 2:
    print("No image path provided.")
    sys.exit(1)

image_path = sys.argv[1]
processed_image = preprocess_image(image_path)


# Make prediction
try:
    prediction = model.predict(processed_image)
    print(f"Predicted probabilities: {prediction}")
    print(f"Predicted class: {np.argmax(prediction)}")

except Exception as e:
    print(f"Error during prediction: {e}")
    sys.exit(1)
