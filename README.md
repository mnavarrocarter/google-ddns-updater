Google Domains Dynamic DNS Updater
==================================

This is a small stateless application that runs in as a long-running non-blocking
process to update a Dynamic DNS record in Google Domains. It is designed to be
deployed as a docker image.

To use it just pull the image and configure it with environment variables:

```bash
docker run -d --name=google-ddns-my.dynamic.host --restart=unless-stopped -e GOOGLE_DDNS_HOSTNAME=my.dynamic.host -e GOOGLE_DDNS_USERNAME=my-ddns-username  -e GOOGLE_DDNS_PASSWORD=my-ddns-password ghcr.io/mnavarrocarter/google-ddns-updater:0.1.0
```

Support for multiple domains via a web interface could be a feature added in future
versions, but at the moment the model is one process per hostname.