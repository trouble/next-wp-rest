import getConfig from 'next/config';

const { publicRuntimeConfig } = getConfig();

export default {
  getGlobalData: () => fetch(`${publicRuntimeConfig.CMS_URL}/wp-json/next-wp-rest/v1/global-data`),
  getByPath: path => fetch(`${publicRuntimeConfig.CMS_URL}/wp-json/trbl-rest/v1/${path}`),
  previewDataById: (id, nonce, options) => fetch(`${publicRuntimeConfig.CMS_URL}/wp-json/trbl-rest/v1/preview/${id}/?_wpnonce=${nonce}`, { ...options }),
  getAllByType: type => fetch(`${publicRuntimeConfig.CMS_URL}/wp-json/trbl-rest/v1/${type}?per_page=-1`),
};
