import React from 'react';
import { connect } from 'react-redux';

const withTitle = (Component, title) => {
  const HocWrapper = props => {
    props.changeTitle();
    return (<Component {...props} />);
  };

  const mapDispatchToProps = {
    changeTitle: () => ({type: 'changeTitle', title})
  };

  return connect(null, mapDispatchToProps)(HocWrapper);
};

export default withTitle;
