require('dotenv').config();

module.exports = {
  publicRuntimeConfig: {
    CMS_URL: process.env.CMS_URL,
    UI_URL: process.env.UI_URL,
  },
  sassLoaderOptions: {
    includePaths: ['scss'],
  },
  webpack: (config) => {
    const configCopy = { ...config };
    configCopy.node = {
      fs: 'empty',
    };

    return configCopy;
  },
};
