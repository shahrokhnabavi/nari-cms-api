import React from 'react';
import { connect } from 'react-redux';
import { IconButton, Typography, AppBar, Toolbar, withStyles } from '@material-ui/core';

import styles from '../../../styles/muiAdminLayout/adminStyle';
import Icon from '../../shared/Icon';
import { AdminPanelLayoutActions } from '../../../actions';

const TopBar = props => {
  const { openMenu, pageTitle, classes } = props;

  return (
    <AppBar position="fixed">
      <Toolbar>
        <IconButton
          color="inherit"
          onClick={openMenu}
          edge="start"
          className={classes.menuButton}
        >
          <Icon type="menu" />
        </IconButton>
        <Typography variant="h6" noWrap>{pageTitle}</Typography>
      </Toolbar>
    </AppBar>
  );
};

const mapStoreToProps = state => ({
  pageTitle: state.AdminPanelLayoutReducer.pageTitle,
});

const mapDispatchToProps = {
  openMenu: AdminPanelLayoutActions.openMenu
};

export default withStyles(
  theme => styles(theme, 'appBar')
)(
  connect(mapStoreToProps, mapDispatchToProps)(TopBar)
);
