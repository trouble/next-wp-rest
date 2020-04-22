import React, { useEffect } from 'react';
import App from 'next/app';
import { Router } from '../routes';

import cms from '../cms';
import Error from './_error';

import '../scss/app.scss';

const baseClass = 'app';

Router.events.on('routeChangeComplete', () => {
  window.scrollTo(0, 0);
});

const NextWPRestApp = (props) => {
  const {
    Component,
    componentProps,
    status,
    error,
    router,
  } = props;

  useEffect(() => {
    console.log('%cNext WP Rest boilerplate built by %cTRBL %c(https://trbl.design)', 'font-weight: bolder;', ' font-weight: bolder; color: #ff4553;', 'font-weight: bolder;');
  }, []);

  return (
    <div className={`${baseClass}__content__wrap`}>
      {status >= 400
        ? (
          <Error
            {...error}
            status={status}
          />
        ) : (
          <Component
            {...componentProps}
            router={router}
          />
        )}
    </div>
  )
}

NextWPRestApp.getInitialProps = async ({ Component, ctx }) => {
  const { res } = ctx;

  // If rendered page has getInitialProps, get 'em
  const componentProps = Component.getInitialProps
    ? await Component.getInitialProps(ctx)
    : {};

  const globalDataRequest = await cms.getGlobalData();
  const globalData = await globalDataRequest.json();

  // If a rendered page has returned a status greater than 400,
  // Get error page data
  if (componentProps.status && componentProps.status >= 400) {
    res.status(componentProps.status);
    return {
      status: componentProps.status,
      error: await Error.getInitialProps(ctx, componentProps.status),
    };
  }

  return {
    globalData,
    componentProps,
  };
}

export default NextWPRestApp;
