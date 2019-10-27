import React from 'react';
import { NavLink } from 'react-router-dom';
import { ListItem, ListItemIcon, ListItemText, Divider } from "@material-ui/core";
import menuItems from './menuItems';
import Index from '../../shared/Icon';

const MainMenuItem = () => {
  return menuItems.map((item, index) => {
    if (item.type === 'divider') {
      return <Divider key={index} />
    }

    return (
      <NavLink exact to={item.url} key={index}>
        <ListItem button>
          <ListItemIcon><Index type={item.icon} /></ListItemIcon>
          <ListItemText primary={item.caption} />
        </ListItem>
      </NavLink>
    );
  });
};

export default MainMenuItem;
