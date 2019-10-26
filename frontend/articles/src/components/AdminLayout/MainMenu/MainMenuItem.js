import React from 'react';
import { ListItem, ListItemIcon, ListItemText, Divider } from "@material-ui/core";
import menuItams from "./menuItams";
import Index from "../../shared/Icon";

const MainMenuItem = () => {
  return menuItams.map((item, index) => {
    if (item.type === 'divider') {
      return <Divider key={index} />
    }

    return (
      <ListItem button key={index}>
        <ListItemIcon><Index type={item.icon} /></ListItemIcon>
        <ListItemText primary={item.caption} />
      </ListItem>
    );
  });
};

export default MainMenuItem;
