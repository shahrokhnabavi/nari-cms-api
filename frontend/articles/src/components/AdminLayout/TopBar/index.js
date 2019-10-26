import React from 'react';
import { connect } from 'react-redux';
import IconButton from "@material-ui/core/IconButton";
import Typography from "@material-ui/core/Typography";
import { AppBar, Toolbar } from "@material-ui/core";

import conditionalCssClass from "../../../util/conditionalCssClass";
import { AdminPanelLayoutActions } from "../../../actions";
import Icon from '../../shared/Icon';

const TopBar = props => {
  const { classes, isMenuOpen, openMenu, pageTitle } = props;

  return (
    <AppBar
      position="fixed"
      className={conditionalCssClass(classes.appBar, [isMenuOpen, classes.appBarShift])}
    >
      <Toolbar>
        <IconButton
          color="inherit"
          aria-label="open drawer"
          onClick={openMenu}
          edge="start"
          className={conditionalCssClass(classes.menuButton, [isMenuOpen, classes.hide])}
        >
          <Icon type="menu" />
        </IconButton>
        <Typography variant="h6" noWrap>
          {pageTitle}
        </Typography>
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
