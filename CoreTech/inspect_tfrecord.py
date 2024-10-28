import tensorflow as tf

def inspect_tfrecord(tfrecord_path):
    raw_dataset = tf.data.TFRecordDataset(tfrecord_path)
    for raw_record in raw_dataset.take(1):  # Inspect just one example
        example = tf.train.Example()
        example.ParseFromString(raw_record.numpy())
        print(example)

# Replace 'path/to/train/Eggs.tfrecord' with the actual path
inspect_tfrecord('public/storage/egg_quality_dataset/train/Eggs.tfrecord')
