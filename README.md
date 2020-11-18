# CPTEC Data Extractor

A simple PHP Lumen based extractor to save and export data from [CPTEC][1] temperature maps from Leme-SP region and export to a JSON response.

The extractor is actually hosted on [Heroku][2], feel free to try some extractions and exportations.

## Extracting Data

The **extraction process** is only responsable for downloading the CPTEC images and extract the average temperature using the image color from the region of Leme-SP, so building a MySQL database with the extracted data.

The **extraction** is done by sending a GET request to https://cptec-data-extractor.herokuapp.com/api/extract/{kind}/{initialExtractionYear}/{finalExtractionYear}

#### OBS

Due to performance issues and [Heroku timeout policy][3] the actual extraction range is limited to one year maximum. But this will be improved in the future.


## Exporting Data

The **exporting process** is responsable for offering a JSON response based on database data.

The **exporting** is done by sending a GET request to https://cptec-data-extractor.herokuapp.com/api/extract/{kind}/


## Request Parameters

The GET requests from API uses the following parameters

- {kind}: The desired temperature average:
    - tempmin: minimum average temperatures
    - tempmax: maximum average temperatures
- {initialExtractionYear}: The initial extraction year
- {finalExtractionYear}: The final extraction year


[1]: http://clima1.cptec.inpe.br/monitoramentobrasil/pt
[2]: https://www.heroku.com/
[3]: https://devcenter.heroku.com/articles/request-timeout
