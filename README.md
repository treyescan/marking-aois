# Marking AOIs

The goal of this part of the HPT toolset is to let experts identify **MUST** and **MAY** be seen Areas Of Interest. This folder contains a Laravel web-applicaton and should be uploaded to a web server to function properly.

## Usage

1. When navigating to the path of the server, users may click on a specified video
1. The clicks on the video are stored in files and may be exported (no database required)
1. Those exported files can be used to generate a video with a python script (i.e. overlay the "clicks" on the video)

**Notes:**

-   Data files will be saved to `./storage/app/public/data/`
-   Log files can be found in `./storage/app/logs/`

## Requirements

-   PHP webserver (deployment)
-   Composer (development)
-   Node/npm (development)

## Installation

```sh
# Get the code
git clone git@github.com:treyescan/marking-aois.git

# Include the videos to ./storage/app/public/videos/
cp *.webm ./storage/app/public/videos/

# Copy and edit the environment file, make sure to set NUMBER_VIDEOS and APP_URL
cp .env.example .env
```

> For optimal usage, browsers require videos to be compressed to .webm format. This can be easily done using [ffmpeg](https://ffmpeg.org/) with this command: `ffmpeg -i source.mp4 -c:v libvpx-vp9 -b:v 1M -c:a libopus -b:a 128k target.webm`

## Development

**To run locally:**

```sh
# Install PHP dependencies
composer install

# Run a local instance (localhost)
php artisan serve
```

**To develop locally:**

```sh
# Install JS/CSS/HTML dependencies
npm install

# Build the assets
npm run dev
npm run watch # alternatively: build assets and watch for changes

# Run a local instance (localhost)
php artisan serve
```

## Deployment

To deploy this Laravel application, follow the steps in [Installation](#installation) first. After that, refer to the official Laravel documentation for a [deployment guide](https://laravel.com/docs/9.x/deployment).

## Citation

## Contribution

[Issues](https://github.com/treyescan/marking-aois/issues/new) and other contributions are welcome.

## License

This toolkit is licensed under [GNU GENERAL PUBLIC LICENSE V3](/LICENSE)
