from json import loads

from src.config import StorageConfig, CptecConfig
from src.utils.exporters.exporter_interface import ExporterInterface

class JsonExporter(ExporterInterface):
    def export(self, kind):
        if (kind not in CptecConfig.kinds):
            return None

        json_path = f'{StorageConfig.dataset_dir}/{kind}.json'

        with open(json_path) as json:
            return json.read()
