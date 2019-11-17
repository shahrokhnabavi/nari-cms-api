import React from 'react';
import { connect } from 'react-redux';

import { AdminPanelLayoutActions } from '../../../actions';

const withTitle = (Component, title) => {
  const HocWrapper = props => {
    props.changePageHeadTitle(title);

    return (<Component {...props} />);
  };

  const mapDispatchToProps = {
    changePageHeadTitle: AdminPanelLayoutActions.changePageHeadTitle
  };

  return connect(null, mapDispatchToProps)(HocWrapper);
};

export default withTitle;
