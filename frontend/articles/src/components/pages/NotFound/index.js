import React from 'react';
import withTitle from '../../shared/withTitle';

const NotFound = () => {
  return (<div>404</div>);
};

export default withTitle(NotFound, 'Page not found');
