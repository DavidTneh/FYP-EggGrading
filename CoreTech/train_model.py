import tensorflow as tf
from tensorflow.keras import layers, models
import os

# Function to parse TFRecord data
# Define a function to parse TFRecord data with corrected feature keys
def parse_tfrecord_fn(example):
    # Define feature description with VarLenFeature for label to handle missing or multiple labels
    feature_description = {
        'image/encoded': tf.io.FixedLenFeature([], tf.string),
        'image/object/class/label': tf.io.VarLenFeature(tf.int64),  # Use VarLenFeature to handle variable label counts
    }
    parsed_example = tf.io.parse_single_example(example, feature_description)
    
    # Decode and preprocess the image
    image = tf.io.decode_jpeg(parsed_example['image/encoded'], channels=3)
    image = tf.image.resize(image, [128, 128])
    image = tf.cast(image, tf.float32) / 255.0
    
    # Handle label as sparse tensor (for cases with multiple or missing labels)
    label = parsed_example['image/object/class/label']
    label = tf.sparse.to_dense(label, default_value=-1)  # Set default for missing labels
    label = tf.cond(tf.shape(label)[0] > 0, lambda: label[0], lambda: tf.constant(-1, dtype=tf.int64))  # Use the first label if multiple
    
    # Filter out examples where the label is -1 (indicating missing label)
    return image, label



def load_dataset(tfrecord_path, batch_size=32, max_label=8):  # Set max_label based on dataset
    raw_dataset = tf.data.TFRecordDataset(tfrecord_path)
    parsed_dataset = raw_dataset.map(parse_tfrecord_fn, num_parallel_calls=tf.data.experimental.AUTOTUNE)
    # Filter out records with missing or out-of-range labels
    filtered_dataset = parsed_dataset.filter(lambda image, label: tf.logical_and(tf.not_equal(label, -1), label <= max_label))
    dataset = filtered_dataset.shuffle(1000).batch(batch_size).prefetch(buffer_size=tf.data.experimental.AUTOTUNE)
    return dataset


# Load training, validation, and test datasets
train_tfrecord_path = 'public/storage/egg_quality_dataset/train/Eggs.tfrecord'
valid_tfrecord_path = 'public/storage/egg_quality_dataset/valid/Eggs.tfrecord'
test_tfrecord_path = 'public/storage/egg_quality_dataset/test/Eggs.tfrecord'

train_dataset = load_dataset(train_tfrecord_path)
valid_dataset = load_dataset(valid_tfrecord_path)
test_dataset = load_dataset(test_tfrecord_path)

# Define the CNN model architecture
def create_model(input_shape=(128, 128, 3), num_classes=9):  # Adjust num_classes based on your dataset
    model = models.Sequential([
        layers.Conv2D(32, (3, 3), activation='relu', input_shape=input_shape),
        layers.MaxPooling2D((2, 2)),
        layers.Conv2D(64, (3, 3), activation='relu'),
        layers.MaxPooling2D((2, 2)),
        layers.Conv2D(128, (3, 3), activation='relu'),
        layers.MaxPooling2D((2, 2)),
        layers.Flatten(),
        layers.Dense(128, activation='relu'),
        layers.Dense(num_classes, activation='softmax')
    ])
    return model


# Create and compile the model
model = create_model()
model.compile(optimizer='adam',
              loss='sparse_categorical_crossentropy',
              metrics=['accuracy'])

# Train the model
epochs = 10
history = model.fit(
    train_dataset,
    validation_data=valid_dataset,
    epochs=epochs
)

# Evaluate the model on the test set
test_loss, test_accuracy = model.evaluate(test_dataset)
print(f"Test accuracy: {test_accuracy:.2f}")

# Save the model
model.save('egg_quality_model.h5')
