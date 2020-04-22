import React from 'react';
import PropTypes from 'prop-types';
import cms from '../cms';

const Error = (props) => {
  const { status } = props;

  return (
    <div>
      <h1>Error status: {status}</h1>
    </div>
  );
};

Error.getInitialProps = async (_, status) => {
  const pageRequest = await cms.getByPath('pages/not-found');
  const data = await pageRequest.json();
  const { status: errorPageStatus } = pageRequest;

  return {
    status,
    data: errorPageStatus <= 400 ? data : undefined,
  };
};

Error.defaultProps = {
  status: 400,
}

Error.propTypes = {
  status: PropTypes.number,
};

export default Error;
