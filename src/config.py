from os import path


class StorageConfig:
    base_dir = path.join(path.dirname(__file__), 'storage')
    dataset_dir = path.join(base_dir, 'datasets')
    image_dir = path.join(base_dir, 'images')


class CptecConfig:
    base_url = 'http://img0.cptec.inpe.br/~rclima/historicos/mensal/brasil/'
    kinds = ('tempmax', 'tempmin')
