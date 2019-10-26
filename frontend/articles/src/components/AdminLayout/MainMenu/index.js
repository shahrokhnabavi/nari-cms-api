import React from 'react';
import { connect } from 'react-redux';
import IconButton from '@material-ui/core/IconButton';
import { Drawer } from '@material-ui/core';
import { useTheme } from '@material-ui/core/styles';

import { AdminPanelLayoutActions } from '../../../actions';
import MainMenuItem from './MainMenuItem';
import Icon from '../../shared/Icon';

const Index = props => {
  const { classes, isMenuOpen, closeMenu } = props;
  const theme = useTheme();

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
          {theme.direction === 'ltr' ? <Icon type="chevronLeft" /> : <Icon type="chevronRight"/>}
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

export default connect(mapStoreToProps, mapDispatchToProps)(Index);
