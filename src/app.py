from flask import Flask, render_template, request

from src.config import StorageConfig, CptecConfig
from src.utils.exceptions.invalid_kind_exception import InvalidKindException
from src.utils.exporters.json_exporter import JsonExporter
from src.utils.extractors.image_extractor import ImageExtractor
from src.utils.resolve import make


app = Flask(__name__)

@app.get('/')
def index():
    return render_template('index.html', url=request.url)

@app.get('/api/export/kind=<kind>')
def export(kind):
    exporter = JsonExporter(StorageConfig(), CptecConfig())

    try:
        return exporter.export(kind)
    except InvalidKindException as e:
        return str(e)

@app.get('/api/extract/start=<start>&end=<end>')
def extract(start, end):
    return make(ImageExtractor).extract(int(start), int(end))
