from flask import Flask, render_template, request

from src.utils.resolve import make
from src.utils.exporters.json_exporter import JsonExporter

app = Flask(__name__)

@app.get('/')
def index():
    return render_template('index.html', url=request.url)

@app.get('/api/export/kind=<kind>')
def export(kind):
    return make(JsonExporter).export(kind)

