# Geofency Webhook Proxy

This web application is a webhook script for [Geofency](http://www.geofency.com) that translates the HTTP requests from
Geofency into different HTTP requests. The Geofency HTTP requests occur, when a certain geofence was entered or left.

At the moment, the web application is tailored to the REST API of [OpenHAB](https://github.com/openhab/openhab/wiki/REST-API), but it's
easily expandable to perform other actions and send other types of requests if needed.

## Installation

Clone this repository and do a

    composer install

Afterwards, copy the file [`config.dist.yml`](config.dist.yml) to `config.yml` and change it to fit your specific use case.

**Warning:** Since location data is kind of sensitive you should put this script on an SSL-encrypted connection and
should not call it via plain HTTP! The same goes for the outgoing requests which might contain authentication information
and interesting data.

## Future plans
- Rate limiting
- Different kinds of HTTP requests for uses other than OpenHAB
- Accept different requests, e.g. from [Locative](https://my.locative.io).