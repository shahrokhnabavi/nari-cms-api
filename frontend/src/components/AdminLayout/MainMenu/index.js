import React from 'react';
import { connect } from 'react-redux';
import { Drawer, IconButton, withStyles } from '@material-ui/core';

import styles from '../../../styles/muiAdminLayout/adminStyle';
import Icon from '../../shared/Icon';
import { AdminPanelLayoutActions } from '../../../actions';
import MainMenuItem from './MainMenuItem';

const MainMenu = props => {
  const { isMenuOpen, closeMenu, classes } = props;

  return (
    <Drawer
      className={classes.drawer}
      anchor="left"
      open={isMenuOpen}
      onClose={closeMenu}
      classes={{
        paper: classes.drawerPaper,
      }}
    >
      <div
        className={classes.drawerHeader}
      >
        <IconButton onClick={closeMenu}>
          <Icon type="chevron_left" />
        </IconButton>
      </div>

      <MainMenuItem />
    </Drawer>
  );
};

const mapStoreToProps = state => ({
  isMenuOpen: state.AdminPanelLayoutReducer.isMenuOpen,
});

const mapDispatchToProps = {
  closeMenu: AdminPanelLayoutActions.closeMenu,
};

export default withStyles(
  theme => styles(theme, 'mainMenu'),
)(
  connect(mapStoreToProps, mapDispatchToProps)(MainMenu),
);
