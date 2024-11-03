# Nexcloud OpenApi UI
This app allow you to read and try your Nextcloud server application APIs.

![Screenshot](https://github.com/smarinier/nextcloud_open_api/raw/master/screenshots/open-api-swagger.png)

## :eyes: Features

* **Swagger UI** Provides Swagger interface for your Nextcloud APIs
* **Automatic scan** List of OpenApi-compatible applications
* **Core Nextcloud** Provides Core Nextcloud APIs
* **Try out** All APIs may be directly tried with the current user rights
* **Acces to the OpenApi description** You may download APIs (use with tools like Postman)

## :rocket:: Installation
Install package in your nextcloud/apps folder.

If you like to build from source, please continue reading.
To install it change into your Nextcloud's apps directory:

    cd nextcloud/apps

Then run:

    git clone https://github.com/smarinier/nextcloud_open_api.git open_api

Then install the dependencies using:

    make build

