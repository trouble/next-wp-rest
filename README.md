# NextJS + WordPress REST API Boilerplate built by TRBL

This repo provides a boilerplate for pairing the WP Rest API with a NextJS React client, built by [TRBL](https://trbl.design).

Wordpress, MySQL, PHP and PHPMyAdmin are all provided by Docker which makes it easy to spin up new instances of WP sites both for local development and for production on hosts like DigitalOcean.

## Getting Started
Clone this repository locally and `cd` to the `client` folder and type `npm install` or `yarn`.

### Set Up Environment
The NextJS app relies on an `.env` file to configure itself to its environment, and this repo ships with an example that you can copy and rename.  To do so, make sure you're still in the `/client` directory, and then duplicate / rename `.env.example` by running `cp .env.example .env`.  The example `.env` file comes preloaded with the URL to the default Docker installation of Wordpress.

### Docker
First, make sure you have Docker installed locally.  Once you do, `cd` to `/api` to duplicate and rename `docker-compose.yml.example` by running `cp docker-compose.yml.example docker-compose.yml`.  Now we need to edit `api/docker-compose.yml` to link your local filesystem with Docker's Wordpress files.  To do so, open up our newly duplicated `docker-compose.yml` and change the following to match your local install directory.  

**NOTE:** You only need to change the path located _before_ the colon. In this case, replace `~/www/next-wp-rest` with your install directory.

````
  volumes:
  	- ~/www/next-wp-rest/api:/var/www/html:delegated
  	- ~/www/next-wp-rest/api/.database:/var/lib/mysql:delegated
````

You may want to also swap all `next_wp_rest_` prefixes for your project's abbreviation to avoid using the same container across multiple projects.

Feel free to make any other changes you'd like to the default user and database configurations but there's no real need locally. Just don't use defaults in production.

Next, fire up Docker if it isn't already. Once this is done, ensure you're still in the `api` directory and and type `docker-compose up -d`.  You can now reach your WP instance via `http://localhost:8080`.

### Wordpress Configuration

After you're up and running, we need to navigate to `http://localhost:8080/wp-admin` and perform the following steps to Wordpress:

1. Activate the Next WP Rest theme
1. Activate plugin ACF PRO
1. Activate TRBL REST and ACF Form Builder
1. Enable Pages and Posts within Settings -> TRBL REST API Settings
1. Add a new page called `Home`, set it to use the `Home` page template, and then set it as your front page in the `Settings -> Reading -> Your homepage displays` section
1. Change Permalinks to the Post Name option
1. Update your Site Address within `Settings -> General` to your SSR app (default: http://localhost:3000)

### Booting up the client side

Run `yarn dev` or `npm run dev` in the `client` folder and then navigate to http://localhost:3000.

## Included Plugins

We've bundled ACF Pro and a few homegrown plugins that we use on all our production WP sites:

- [TRBL REST API](./api/wp-content/plugins/trbl-rest/README.md)
- [ACF Form Builder](./api/wp-content/plugins/acf-form-builder/README.md)

## Questions?

[Email us](mailto:info@trbl.design) or drop by our website at [trbl.design](https://trbl.design).
