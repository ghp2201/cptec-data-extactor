from json import loads

from src.config import StorageConfig, CptecConfig
from src.utils.exporters.exporter_interface import ExporterInterface
from src.utils.exceptions.invalid_kind_exception import InvalidKindException

class JsonExporter(ExporterInterface):
    def __init__(self, storage_config, cptec_config):
        self.storage_config = storage_config
        self.cptec_config = cptec_config

    def export(self, kind):
        if (kind not in self.cptec_config.kinds):
            raise InvalidKindException(kind)

        json_path = f'{self.storage_config.dataset_dir}/{kind}.json'

        with open(json_path) as json:
            return json.read()
