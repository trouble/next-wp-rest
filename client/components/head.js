import React from 'react';
import PropTypes from 'prop-types';
import NextHead from 'next/head';
import getConfig from 'next/config';

const defaultDescription = 'Next WP REST is a boilerplate provided by TRBL that allows WP to be used in a headless capacity.';
const defaultOGURL = 'https://trbl.design';
const defaultOGImage = '/public/img/default-og-image.jpg';
const defaultKeywords = '';
const { publicRuntimeConfig } = getConfig();

const Head = (props) => {
  const {
    title, description, url, ogImage, keywords,
  } = props;

  return (
    <NextHead>
      <meta charSet="UTF-8" />
      <title>{title || 'Next WP Rest'}</title>
      <meta
        name="description"
        content={description || defaultDescription}
      />
      <meta
        name="keywords"
        content={keywords || defaultKeywords}
      />
      <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
      />
      <link
        rel="icon"
        href="/static/favicon.png"
      />
      <meta
        property="og:url"
        content={url || defaultOGURL}
      />
      <meta
        property="og:title"
        content={title || 'Next WP Rest'}
      />
      <meta
        property="og:description"
        content={description || defaultDescription}
      />
      <meta
        name="twitter:site"
        content={url || defaultOGURL}
      />
      <meta
        name="twitter:card"
        content="summary_large_image"
      />
      <meta
        name="twitter:image"
        content={ogImage || defaultOGImage}
      />
      <meta
        property="og:image"
        content={ogImage || defaultOGImage}
      />
      <meta
        property="og:image:width"
        content="1200"
      />
      <meta
        property="og:image:height"
        content="630"
      />
    </NextHead>
  );
};

Head.propTypes = {
  title: PropTypes.string,
  description: PropTypes.string,
  keywords: PropTypes.string,
  url: PropTypes.string,
  ogImage: PropTypes.oneOfType([
    PropTypes.string,
    PropTypes.bool,
  ]),
};

Head.defaultProps = {
  title: '',
  description: '',
  keywords: '',
  url: '',
  ogImage: false,
};

export default Head;
