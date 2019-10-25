import React from 'react';
import { connect } from 'react-redux';
import IconButton from "@material-ui/core/IconButton";
import {
  ChevronLeft as ChevronLeftIcon,
  ChevronRight as ChevronRightIcon,
  Inbox as InboxIcon,
  Mail as MailIcon
} from "@material-ui/icons";
import { Divider, Drawer, List, ListItem, ListItemIcon, ListItemText } from "@material-ui/core";
import { useTheme } from '@material-ui/core/styles';

import { AdminPanelLayoutActions } from "../../actions";

const MainMenu = props => {
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
          {theme.direction === 'ltr' ? <ChevronLeftIcon /> : <ChevronRightIcon />}
        </IconButton>
      </div>
      <List>
        {['Inbox', 'Starred', 'Send email', 'Drafts'].map((text, index) => (
          <ListItem button key={text}>
            <ListItemIcon>{index % 2 === 0 ? <InboxIcon /> : <MailIcon />}</ListItemIcon>
            <ListItemText primary={text} />
          </ListItem>
        ))}
      </List>
      <Divider />
      <List>
        {['All mail', 'Trash', 'Spam'].map((text, index) => (
          <ListItem button key={text}>
            <ListItemIcon>{index % 2 === 0 ? <InboxIcon /> : <MailIcon />}</ListItemIcon>
            <ListItemText primary={text} />
          </ListItem>
        ))}
      </List>
    </Drawer>
  );
};

const mapStoreToProps = state => ({
  isMenuOpen: state.AdminPanelLayoutReducer.isMenuOpen
});

const mapDispatchToProps = {
  closeMenu: AdminPanelLayoutActions.closeMenu,
};

export default connect(mapStoreToProps, mapDispatchToProps)(MainMenu);
