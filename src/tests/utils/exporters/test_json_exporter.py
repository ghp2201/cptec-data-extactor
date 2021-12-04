from pytest import raises
from unittest import TestCase

from src.tests.config import FixtureStorageConfig, FixtureCptecConfig
from src.utils.exceptions.invalid_kind_exception import InvalidKindException
from src.utils.exporters.json_exporter import JsonExporter


class TestJsonExporter(TestCase):
    @property
    def exporter(self):
        return JsonExporter(FixtureStorageConfig(), FixtureCptecConfig())

    def _expected_json_string(self, kind):
        dataset = f'{self.exporter.storage_config.dataset_dir}/{kind}.json'

        with open(dataset) as json:
            json_string = json.read()

        return json_string

    def test_export_should_raise_invalid_kind_exception_if_using_invalid_kind(self):
        with raises(InvalidKindException):
            self.exporter.export('foo')

    def test_export_should_return_valid_json_string_on_valid_kinds(self):
        for valid_kind in self.exporter.cptec_config.kinds:
            json_string = self.exporter.export(valid_kind)
            expected_json_string = self._expected_json_string(valid_kind)

            self.assertEqual(json_string, expected_json_string)
