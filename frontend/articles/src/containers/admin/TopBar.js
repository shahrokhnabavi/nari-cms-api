import React from 'react';
import { connect } from 'react-redux';
import IconButton from "@material-ui/core/IconButton";
import Typography from "@material-ui/core/Typography";
import { Menu as MenuIcon } from "@material-ui/icons";
import { AppBar, Toolbar } from "@material-ui/core";

import conditionalCssClass from "../../util/conditionalCssClass";
import { AdminPanelLayoutActions } from "../../actions";

const TopBar = props => {
  const { classes, isMenuOpen, openMenu } = props;

  console.log(conditionalCssClass(classes.appBar, [isMenuOpen, classes.appBarShift]));
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
          <MenuIcon />
        </IconButton>
        <Typography variant="h6" noWrap>
          Persistent drawer
        </Typography>
      </Toolbar>
    </AppBar>
  );
};

const mapStoreToProps = state => ({
  isMenuOpen: state.AdminPanelLayoutReducer.isMenuOpen
});

const mapDispatchToProps = {
  openMenu: AdminPanelLayoutActions.openMenu
};

export default connect(mapStoreToProps, mapDispatchToProps)(TopBar);
