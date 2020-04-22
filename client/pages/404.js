import React from 'react';
import cms from '../cms';

const NotFound = (props) => {
  return (
    <div>
      <h1>Not Found</h1>
    </div>
  );
};

NotFound.getInitialProps = async (_, status) => {
  const pageRequest = await cms.getByPath('pages/not-found');
  const data = await pageRequest.json();
  const { status: errorPageStatus } = pageRequest;

  return {
    status,
    data: errorPageStatus <= 400 ? data : undefined,
  };
};

export default NotFound;
