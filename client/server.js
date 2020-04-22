require('isomorphic-fetch');
require('dotenv').config();

const express = require('express');
const next = require('next');
const routes = require('./routes');

const dev = process.env.NODE_ENV !== 'production';

const app = next({ dev });
const handler = routes.getRequestHandler(app);

const { PORT } = process.env;

app
	.prepare()
	.then(() => {
		const server = express();

		const port = PORT || 3000;

		server.get('/favicon.png', (req, res) => {
			return res.sendStatus(404);
		});

		server.use(handler);

		server.listen(port, (err) => {
			if (err) throw err;
			console.log(`> Ready on http://localhost:${port}`);
		});
	})
	.catch((ex) => {
		console.error(ex.stack);
		process.exit(1);
	});
