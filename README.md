# CPTEC Data Extractor

A simple PHP Lumen based extractor to save and export data from [CPTEC][1] temperature maps from Leme-SP region and export to a JSON response.

## Extracting Data

The **extraction process** use Lumen jobs to download the CPTEC heat map images and extract the average temperature using the image color from the region of Leme-SP, so building a MySQL database with the extracted data.

## Exporting Data

The **exporting process** is responsable for returning a JSON response based on database data from the desired kind.

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


[1]: http://clima1.cptec.inpe.br/monitoramentobrasil/pt
