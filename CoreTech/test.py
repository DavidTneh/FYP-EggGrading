import tensorflow as tf

model_path = r"C:\Users\User\Documents\FYP\FYP-EggGrading\storage\1DecEggWeightDetect\sizeModel.keras"

try:
    model = tf.keras.models.load_model(model_path)
    print("Model loaded successfully!")
except Exception as e:
    print(f"Error loading model: {e}")
