import React, { Fragment } from 'react';
import PropTypes from 'prop-types';
import getConfig from 'next/config';

import Head from '../components/head';

import cms from '../cms';

const { publicRuntimeConfig: { UI_URL } } = getConfig();

const Page = (props) => {
  const {
    router: {
      query,
    },
    pageData: {
      title,
      acf: {
        meta: {
          metaTitle,
          metaDescription,
          metaKeywords,
          metaOgImage,
        } = {
          metaTitle: '',
          metaDescription: '',
          metaKeywords: '',
          metaOgImage: '',
        },
      } = {},
    },
  } = props;

  return (
    <Fragment>
      <Head
        title={metaTitle}
        description={metaDescription}
        keywords={metaKeywords}
        ogImage={(metaOgImage && metaOgImage.url)}
        url={`${UI_URL}/${query.slug || ''}`}
      />
      {title}
    </Fragment>
  );
};

Page.getInitialProps = async (ctx) => {
  const {
    req,
    query: {
      slug,
      preview_id: postID,
      _wpnonce: nonce,
    },
  } = ctx;

  let pageRequest;

  if (nonce && postID) {
    pageRequest = await cms.previewDataById(postID, nonce, {
      headers: {
        Cookie: req.headers.cookie,
      },
    });
  } else {
    pageRequest = await cms.getByPath(`pages/${slug || 'home'}`);
  }

  const pageData = await pageRequest.json();
  const { status } = pageRequest;

  if (pageData.length === 0) {
    return {
      status: 404,
      message: 'not-found',
    };
  }

  return { pageData, status };
};

Page.propTypes = {
  router: PropTypes.shape({
    query: PropTypes.shape({
      slug: PropTypes.string,
    }),
  }).isRequired,
  pageData: PropTypes.shape({
    title: PropTypes.string.isRequired,
    acf: PropTypes.oneOfType([
      PropTypes.shape({
        meta: PropTypes.shape({
          metaTitle: PropTypes.string,
          metaDescription: PropTypes.string,
          metaKeywords: PropTypes.string,
          metaOgImage: PropTypes.oneOfType([
            PropTypes.shape({
              url: PropTypes.string,
            }),
            PropTypes.bool,
          ]),
        }),
      }),
      PropTypes.bool,
    ]),
  }).isRequired,
};

export default Page;
