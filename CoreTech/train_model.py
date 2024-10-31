from tensorflow.keras.applications import ResNet50V2
import tensorflow as tf
from tensorflow.keras import layers, models
import os
import numpy as np
import matplotlib.pyplot as plt
from sklearn.metrics import confusion_matrix, classification_report
import seaborn as sns

# Function to parse TFRecord data
def parse_tfrecord_fn(example):
    feature_description = {
        'image/encoded': tf.io.FixedLenFeature([], tf.string),
        'image/object/class/label': tf.io.VarLenFeature(tf.int64),
    }
    parsed_example = tf.io.parse_single_example(example, feature_description)
    
    # Decode and preprocess the image
    image = tf.io.decode_jpeg(parsed_example['image/encoded'], channels=3)
    image = tf.image.resize(image, [128, 128])
    image = tf.cast(image, tf.float32) / 255.0
    
    # Handle label as sparse tensor
    label = parsed_example['image/object/class/label']
    label = tf.sparse.to_dense(label, default_value=-1)
    label = tf.cond(tf.shape(label)[0] > 0, lambda: label[0], lambda: tf.constant(-1, dtype=tf.int64))
    
    return image, label


# Load and preprocess dataset
def load_dataset(tfrecord_path, batch_size=32, max_label=8):
    raw_dataset = tf.data.TFRecordDataset(tfrecord_path)
    parsed_dataset = raw_dataset.map(parse_tfrecord_fn, num_parallel_calls=tf.data.experimental.AUTOTUNE)
    filtered_dataset = parsed_dataset.filter(lambda image, label: tf.logical_and(tf.not_equal(label, -1), label <= max_label))
    dataset = filtered_dataset.shuffle(1000).batch(batch_size).prefetch(buffer_size=tf.data.experimental.AUTOTUNE)
    return dataset


# Paths to datasets
train_tfrecord_path = 'public/storage/eggDataset/train/Eggs.tfrecord'
valid_tfrecord_path = 'public/storage/eggDataset/valid/Eggs.tfrecord'
test_tfrecord_path = 'public/storage/eggDataset/test/Eggs.tfrecord'

# Load datasets
train_dataset = load_dataset(train_tfrecord_path)
valid_dataset = load_dataset(valid_tfrecord_path)
test_dataset = load_dataset(test_tfrecord_path)

# Define the CNN model architecture
def create_model(input_shape=(128, 128, 3), num_classes=9):
    base_model = ResNet50V2(weights='imagenet', include_top=False, input_shape=input_shape)
    base_model.trainable = False

    model = models.Sequential([
        base_model,
        layers.GlobalAveragePooling2D(),
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

# Confusion matrix and classification report
# Get predictions from the test dataset
y_true = []
y_pred = []

for images, labels in test_dataset:
    preds = model.predict(images)
    y_true.extend(labels.numpy())
    y_pred.extend(np.argmax(preds, axis=1))

# Convert lists to numpy arrays
y_true = np.array(y_true)
y_pred = np.array(y_pred)

# Calculate confusion matrix
conf_matrix = confusion_matrix(y_true, y_pred)

# Plot confusion matrix
plt.figure(figsize=(10, 8))
sns.heatmap(conf_matrix, annot=True, fmt="d", cmap="Blues", xticklabels=range(9), yticklabels=range(9))
plt.xlabel("Predicted Labels")
plt.ylabel("True Labels")
plt.title("Confusion Matrix")
plt.show()

# Print classification report for accuracy, precision, recall, F1-score
print("Classification Report:")
print(classification_report(y_true, y_pred))
