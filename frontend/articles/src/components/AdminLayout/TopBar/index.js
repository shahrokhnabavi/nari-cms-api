import React from 'react';
import { connect } from 'react-redux';
import { IconButton, Typography, AppBar, Toolbar } from '@material-ui/core';

import conditionalCssClass from '../../../util/conditionalCssClass';
import Icon from '../../shared/Icon';
import { AdminPanelLayoutActions } from '../../../actions';
import useStyles from './style';

const TopBar = props => {
  const { isMenuOpen, openMenu, pageTitle } = props;
  const classes = useStyles();

  return (
    <AppBar
      position="fixed"
      className={conditionalCssClass(classes.appBar, [isMenuOpen, classes.appBarShift])}
    >
      <Toolbar>
        <IconButton
          color="inherit"
          onClick={openMenu}
          edge="start"
          className={conditionalCssClass(classes.menuButton, [isMenuOpen, classes.hide])}
        >
          <Icon type="menu" />
        </IconButton>
        <Typography variant="h6" noWrap>{pageTitle}</Typography>
      </Toolbar>
    </AppBar>
  );
};

const mapStoreToProps = state => ({
  isMenuOpen: state.AdminPanelLayoutReducer.isMenuOpen,
  pageTitle: state.AdminPanelLayoutReducer.pageTitle,
});

const mapDispatchToProps = {
  openMenu: AdminPanelLayoutActions.openMenu
};

export default connect(mapStoreToProps, mapDispatchToProps)(TopBar);
