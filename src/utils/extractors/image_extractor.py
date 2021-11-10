from datetime import datetime

from requests import get

from src.config import StorageConfig, CptecConfig
from src.utils.extractors.extractor_interface import ExtractorInterface
from src.utils.enums.months_enum import MonthsEnum


class ImageExtractor(ExtractorInterface):
    def extract(self, start_year, end_year):
        year_range = self._get_year_range(start_year, end_year)

        for year in year_range:
            short_year = str(year)[2:]

            for month in MonthsEnum:
                self._download_month_images(month, short_year)

    def _get_year_range(self, start_year, end_year):
        actual_year = datetime.now().year

        if (end_year < actual_year):
            return range(start_year, (end_year + 1))

        return range(start_year, actual_year)

    def _download_month_images(self, month, short_year):
        month_name, (short_month_name, month_number) = month.describe()

        for kind in CptecConfig.kinds:
            self._download_image(kind, month_number, short_year, short_month_name)

    def _download_image(self, kind, month_number, short_year, short_month_name):
        file_name = f'{kind}{month_number:02d}{short_year}'
        image_url = f'{CptecConfig.base_url}{short_month_name}/{file_name}.gif'

        stream = get(image_url, stream=True)

        with open(f'{StorageConfig.image_dir}/{file_name}.gif', 'wb') as handler:
                handler.write(stream.content)
