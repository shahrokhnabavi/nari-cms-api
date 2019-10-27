import React from 'react';
import {
  IconButton, ListItemSecondaryAction, ListItemText, Checkbox, ListItem, ListItemIcon
} from '@material-ui/core';
import Icon from '../../../shared/Icon';
import useStyles from './style';

const TableListItem = props => {
  const { item } = props;
  const classes = useStyles();

  return (
    <ListItem role={undefined} button onClick={() => ({})}>
      <ListItemIcon>
        <Checkbox
          edge="start"
          tabIndex={-1}
          disableRipple
          inputProps={{ 'aria-labelledby': item.identifier }}
        />
      </ListItemIcon>
      <ListItemText id={item.identifier} primary={item.title} />
      <ListItemSecondaryAction>
        <IconButton edge="end" aria-label="Edit" className={classes.editButton}>
          <Icon type="edit" />
        </IconButton>
        <IconButton edge="end" aria-label="Delete" className={classes.deleteButton}>
          <Icon type="delete" />
        </IconButton>
      </ListItemSecondaryAction>
    </ListItem>
  );
};

export default TableListItem;
