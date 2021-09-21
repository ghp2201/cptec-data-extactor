<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="API de dados climáticos históricos da cidade de Leme-SP">
  <meta name="author" content="Gustavo Henrique Pinto">

  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

  <title>
    Extrator climático
  </title>
</head>
<body>
  <main>
    <section>
      <div class="w-full text-center mt-10">
        <h1 class="text-6xl font-extrabold">
          API - CPTEC Data Extractor
        </h1>
        <h2 class="text-md mt-1">
          Uma maneira descomplicada de obter dados climáticos históricos da cidade de Leme-SP
        </h2>
      </div>
    </section>

    <section>
      <div class="grid w-full mt-20">
        <div class="place-self-center text-center w-full md:w-1/2">
          <h3 class="text-3xl">
            Exportando dados
          </h3>
          <div>
            O processo de exportação retornará um array de objetos JSON contendo os dados climáticas ordenados por ano
          </div>

          <div class="grid w-full mt-8">
            <h4 class="text-xl">
              Histórico de temperaturas mínimas
            </h4>
            <p class="place-self-center p-2 bg-gray-200 text-gray-700 w-max rounded-2xl">
              <a href="https://cptecextractor.gustapinto.dev/api/export/kind=tempmin">
                https://cptecextractor.gustapinto.dev/api/export/kind=tempmin
              </a>
            </p>
          </div>

          <div class="grid w-full mt-8">
            <h4 class="text-xl">
              Histórico de temperaturas máximas
            </h4>
            <p class="place-self-center p-2 bg-gray-200 text-gray-700 w-max rounded-2xl">
              <a href="https://cptecextractor.gustapinto.dev/api/export/kind=tempmax">
                https://cptecextractor.gustapinto.dev/api/export/kind=tempmax
              </a>
            </p>
          </div>
        </div>
      </div>
    </section>
  </main>
</body>
</html>
