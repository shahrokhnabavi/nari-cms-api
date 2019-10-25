import React from 'react';
import PropTypes from "prop-types";

import AdminPanelLayout from './admin/AdminPanelLayout';
import App from './experimental/App';

const ContainerSwitch = props => {
  const { container } = props;

  switch(container) {
    case 'admin':
      return <AdminPanelLayout/>;
    case 'experimental':
      return <App />;
    default:
      return (<div>No Container Defined</div>);
  }
};

ContainerSwitch.propTypes = {
  container: PropTypes.string.isRequired
};

export default ContainerSwitch;
