# CPTEC Data Extractor

A simple PHP Lumen based extractor to save and export data from [CPTEC][1] temperature maps from Leme-SP region and export to a JSON response.

## Extracting Data

The **extraction process** is only responsable for downloading the CPTEC images and extract the average temperature using the image color from the region of Leme-SP, so building a MySQL database with the extracted data.

## Exporting Data

The **exporting process** is responsable for offering a JSON response based on database data.


[1]: http://clima1.cptec.inpe.br/monitoramentobrasil/pt
