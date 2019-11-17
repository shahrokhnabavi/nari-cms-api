import React from 'react';
import { connect } from 'react-redux';
import { NavLink } from 'react-router-dom';
import { ListItem, ListItemIcon, ListItemText, Divider } from '@material-ui/core';

import Index from '../../shared/Icon';
import { AdminPanelLayoutActions } from '../../../actions';

const menuItems = [
  {caption: 'Dashboard', url: '/', icon: 'dashboard'},
  {caption: 'Page Not Found', url: '/not-valid-route'},
  {caption: 'About', url: '/about', icon: 'info'},
  {type: 'divider', caption: 'Tools'},
  {caption: 'Article', url: '/articles'},
  {type: 'divider'},
  {caption: 'Settings', url: '/settings', icon: 'settings'},
  {caption: 'Help', url: '/help', icon: 'help'},
];

const MainMenuItem = props => {
  const { closeMenu } = props;
  return menuItems.map((item, index) => {
    if (item.type === 'divider') {
      return <Divider key={index} />
    }

    return (
      <NavLink exact to={item.url} key={index}>
        <ListItem button onClick={closeMenu}>
          <ListItemIcon><Index type={item.icon} /></ListItemIcon>
          <ListItemText primary={item.caption} />
        </ListItem>
      </NavLink>
    );
  });
};

const mapDispatchToProps = {
  closeMenu: AdminPanelLayoutActions.closeMenu,
};

export default connect(null, mapDispatchToProps)(MainMenuItem);
