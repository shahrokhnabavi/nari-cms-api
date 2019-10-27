import React from 'react';
import { connect } from 'react-redux';
import { Drawer, IconButton, withTheme } from '@material-ui/core';

import Icon from '../../shared/Icon';
import { AdminPanelLayoutActions } from '../../../actions';
import MainMenuItem from './MainMenuItem';
import useStyles from './style';

const Index = props => {
  const { theme, isMenuOpen, closeMenu } = props;
  const classes = useStyles();

  return (
    <Drawer
      className={classes.drawer}
      variant="persistent"
      anchor="left"
      open={isMenuOpen}
      classes={{
        paper: classes.drawerPaper,
      }}
    >
      <div className={classes.drawerHeader}>
        <IconButton onClick={closeMenu}>
          <Icon type={theme.direction === 'ltr' ? "chevron_left" : "chevron_right"} />
        </IconButton>
      </div>

      <MainMenuItem />
    </Drawer>
  );
};

const mapStoreToProps = state => ({
  isMenuOpen: state.AdminPanelLayoutReducer.isMenuOpen
});

const mapDispatchToProps = {
  closeMenu: AdminPanelLayoutActions.closeMenu,
};

export default connect(mapStoreToProps, mapDispatchToProps)(withTheme(Index));
