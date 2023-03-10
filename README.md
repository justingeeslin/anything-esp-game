# Anything ESP Game

An open source version of the [ESP Game](https://en.wikipedia.org/wiki/ESP_game), designed to be customized and easily deployed.

## Usage

### Sample Config
The images and the prompt can be customized.

```js
{
    "images": [
        {
            "url" : "https://twin-cities.umn.edu/sites/twin-cities.umn.edu/files/fashion_6.jpg",
            "alt" : ""
        },
        {
            "url" : "https://twin-cities.umn.edu/sites/twin-cities.umn.edu/files/fashion_5.jpg",
            "alt" : ""
        },
        {
            "url" : "https://twin-cities.umn.edu/sites/twin-cities.umn.edu/files/fashion_4.jpg",
            "alt" : ""
        }
    ],
    "prompt": "Please describe the image below. "
}
```

### Viewing Results

### Results Tag Cloud
Navigate to `tagcloud.php`. This will show a webpage of all the things and a tag cloud of all their words.
```
http://0.0.0.0:4444/tagcloud.php
```

### CSV Export
Navigate to `results.php`. This will download a CSV of all the things, their words, and how many times they were input by players.
```
http://0.0.0.0:4444/results.php
```

### Custom Configuration
A custom configuration can be used by adding a `config` variable to the URL, like so:

```
http://0.0.0.0:4444/?config=https://justin.geesl.in/config-alternate.json
```

The results will appear in a CSV file on the server whose name cooresponds to the `config` URL, like so:
```
http://0.0.0.0:4444/justin-geesl-in_config_alternate-json-RESULTS.csv
```
