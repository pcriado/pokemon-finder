## Acerca de Pokemon Finder

Pokemon Finder es una app para buscar pokemones por nombre. Contiene una vista simple de blade y una API dentro del mismo Laravel 8 que utiliza toda la app.  
Funciona como middleware con un servicio externo que ofrece pokeapi.co  
Esta app utiliza cache para minimizar el uso de pokeapi.co y proveer búsqueda parcial por nombre


## Entorno local

Se requiere [docker] https://docs.docker.com y [docker-compose] https://docs.docker.com/compose/ y el puerto 8000 libre  

Luego de clonar el repositorio, ejecutar docker-compose para construir y servir el contenido 
```
sudo docker-compose up -d
```

Navegar a:

```
http://localhost:8000
```
Y utilizar el formulario.

Para ejecutar los tests, se puede ejecutar desde fuera del docker asumiendo php cli instalado
```
./artisan test
```
o ingresando al contenedor usando docker ps para obtener el ID de container:
```
docker ps
docker exec -it {container_id} sh
```
Dependiendo de su instalación, es posible que todos los comandos de [docker] y [docker-compose] requieran [sudo]

## API

La api se puede invocar directamente, sin vista web, y se pueden realizar búsquedas con el parámetro keyword que es case insensitive.

```
GET http://localhost:8000/api/v1/pokesearch?keyword=charm
```

Ejemplo de response body con status 200
```
[
    {
        "name": "charmander",
        "url": "https://pokeapi.co/api/v2/pokemon/4/"
    },
    {
        "name": "charmeleon",
        "url": "https://pokeapi.co/api/v2/pokemon/5/"
    }
]
```

## Links útiles

Documentación de pokeapi: https://pokeapi.co/docs/v2

## Archivos de interés

Entorno local
```
Dockerfile
docker-compose.yaml
```
Rutas
```
routes/api.php
routes/web.php
```
Vistas
```
resources/views/pokesearchform.blade.php
```
Configuración
```
config/pokesearch.php
config/env/dev.env
```
Se puede configurar el tiempo de cache, y el endpoint de pokeapi desde config/pokesearch.php  
El archivo dev.env se copia al root de la app para proveer un config de entorno local

Conector para pokeapi.co
```
app/Http/Services/PokeapiService.php
```

Controlador principal de la API: 
```
app/Http/Controllers/PokemonController.php
```

Tests
```
tests/Feature/PokeSearchApiTest.php
```

## Laravel

Docs: https://laravel.com/docs

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
