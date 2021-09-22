<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Pokemon Finder App</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->

        <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
        <style type="text/css">
        .form-style-8{
            font-family: 'Open Sans Condensed', arial, sans;
            width: 700px;
            padding: 30px;
            background: #FFFFFF;
            margin: 50px auto;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.22);
            -moz-box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.22);
            -webkit-box-shadow:  0px 0px 15px rgba(0, 0, 0, 0.22);

        }
        .form-style-8 h2{
            background: #4D4D4D;
            text-transform: uppercase;
            font-family: 'Open Sans Condensed', sans-serif;
            color: white;
            font-size: 18px;
            font-weight: bold;
            padding: 20px;
            margin: -30px -30px 30px -30px;
        }
        .form-style-8 input[type="text"],
        .form-style-8 input[type="date"],
        .form-style-8 input[type="datetime"],
        .form-style-8 input[type="email"],
        .form-style-8 input[type="number"],
        .form-style-8 input[type="search"],
        .form-style-8 input[type="time"],
        .form-style-8 input[type="url"],
        .form-style-8 input[type="password"],
        .form-style-8 textarea,
        .form-style-8 select 
        {
            box-sizing: border-box;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            outline: none;
            display: block;
            width: 100%;
            padding: 7px;
            border: none;
            border-bottom: 1px solid #ddd;
            background: transparent;
            margin-bottom: 10px;
            font: 16px Arial, Helvetica, sans-serif;
            height: 45px;
        }
        .form-style-8 textarea{
            resize:none;
            overflow: hidden;
        }
        .form-style-8 input[type="button"], 
        .form-style-8 input[type="submit"]{
            -moz-box-shadow: inset 0px 1px 0px 0px #45D6D6;
            -webkit-box-shadow: inset 0px 1px 0px 0px #45D6D6;
            box-shadow: inset 0px 1px 0px 0px #45D6D6;
            background-color: #2CBBBB;
            border: 1px solid #27A0A0;
            display: inline-block;
            cursor: pointer;
            color: #FFFFFF;
            font-family: 'Open Sans Condensed', sans-serif;
            font-size: 14px;
            padding: 8px 18px;
            text-decoration: none;
            text-transform: uppercase;
        }
        .form-style-8 input[type="button"]:hover, 
        .form-style-8 input[type="submit"]:hover {
            background:linear-gradient(to bottom, #34CACA 5%, #30C9C9 100%);
            background-color:#34CACA;
        }
        </style>        


    </head>

    <script type="text/javascript">

        function isBlank(str) {
            return (!str || /^\s*$/.test(str));
        }

        function findPokemons() {

            const baseUrl = '<?php echo Request::url() ?>';

            let keyword = document.getElementById('keyword').value;
            if (isBlank(keyword)) {
                alert('Por favor ingrese un texto para buscar');
                return;
            }

            let xhr = new XMLHttpRequest();
            let url = baseUrl + '/api/v1/pokesearch?keyword=' + keyword; 
            xhr.open('GET', url);
            xhr.responseType = 'json';
            xhr.send();

            xhr.onload = function() {
                if (xhr.status != 200) {
                    console.log(`Error ${xhr.status}: ${xhr.statusText}`);
                    noResults();
                } else {                     
                    let json = xhr.response;
                    showResults(json);                     
                }
            };
        }

        function noResults() {
            let div = document.getElementById('results');
            div.innerHTML = ''; 
            div.innerHTML += '<h2>Sin resultados</h2>';
            div.innerHTML += '<input type="text" readonly="readonly" value="No existen pokemones con ese nombre" />'; 
            
            div.style.display = 'block';
        }

        function showResults(items) {

            if (items.length < 1) {
                noResults();
                return; 
            }

            let div = document.getElementById('results');
            div.innerHTML = ''; 
            div.innerHTML += '<h2>Resultados de la búsqueda</h2>';

            for(var i = 0; i < items.length; i++) {
                var obj = items[i];                
                div.innerHTML += '<input type="text" readonly="readonly" value="'+obj.name+'" />'; 
            }           
            
            div.style.display = 'block';
        }

    </script>

    <body>    
        <div class="form-style-8">
            <h2>Pokemon Finder</h2>            
            <form onkeydown="if (event.key == 'Enter') findPokemons(); return event.key != 'Enter';">
                <p>El que quiere Pokemones, que los busque.</p>
                <input type="text" id="keyword" name="keyword"  placeholder="Ingrese el nombre a buscar" />
                <input type="button" value="BUSCAR POKEMONES" onclick="javascript:findPokemons();" />
            </form>
        </div>

        <div class="form-style-8" id="results" style="display:none"></div>
   
        <div class="form-style-8">
            <p>
                Hecho por Pablo<br />
                <br />
                <a href="https://github.com/pcriado/pokemon-finder">Link a mi repo</a><br />
                <br />
            </p>
        </div>                   
     
    </body>

</html>