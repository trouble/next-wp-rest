const nextRoutes = require('next-routes');

const routes = nextRoutes();

routes.add('page', '/:slug*', '/');

module.exports = routes;
