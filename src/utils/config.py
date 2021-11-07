from os import path

class Config:
    storage_dir = path.join(path.dirname(__file__), 'storage')
    storage_dataset_dir = path.join(storage_dir, 'datasets')
    storage_image_dir = path.join(storage_dir, 'images')
