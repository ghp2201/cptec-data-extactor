# CPTEC Data Extractor

A simple PHP Lumen based extractor to save and export data from [CPTEC][1] temperature maps from Leme-SP region and export to a JSON response.

## Extracting Data

The **extraction process** use Lumen jobs to download the CPTEC heat map images and extract the average temperature using the image color from the region of Leme-SP, so building a MySQL database with the extracted data.

### Request Url

```http://{host}/api/extract/start={start}&end={end}```

### Request Parameters

- {host}: The actual host of the application¹
- {start}: The starting year² of extraction
- {end}: The last year² of extraction

## Exporting Data

The **exporting process** is responsable for returning a JSON response based on all database data from the desired kind.

### Request Url

```http://{host}/api/export/kind={kind}```

### Request Parameters

- {host}: The actual host of the application¹
- {kind}: The type of data to be exported, can be:
  - 'tempmin': The minimum temperature
  - 'tempmax': The maximum temperature

## Installation

1. Clone this repository
2. Copy .env.example to .env and change the necessary *env vars*
3. Use `docker-compose up --build` to start the necessary containers and active the *Artisan Queue*
4. Enter on PHP docker container bash using ```docker-compose exec php bash```
5. Run ```composer install``` to install all dependencies
6. Run ```php artisan migrate``` to initialize the database
7. exit PHP docker container bash using `exit`
8. Grant the necessary permissions to ```storage/logs/ storage/framework/ public/uploads/```
9. Start sending requests :smiley:

## Notes

¹ If the application is running on local the host will be ```127.0.0.1```.  
² A valid four digit year between 1961 and 2020.  


[1]: http://clima1.cptec.inpe.br/monitoramentobrasil/pt
