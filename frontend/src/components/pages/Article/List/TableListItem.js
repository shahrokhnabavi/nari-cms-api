import React from 'react';
import { IconButton, ListItemSecondaryAction, Checkbox } from '@material-ui/core';
import Icon from '../../../shared/Icon';
import useStyles from './style';

const TableListItem = props => {
  const { item, style } = props;
  const classes = useStyles();

  return (
    <li style={style} onClick={() => (false)}>
      <span>
        <Checkbox
          tabIndex={-1}
          inputProps={{ 'aria-labelledby': item.identifier }}
        />
      </span>
      <span>
        {item.title}
      </span>
      <ListItemSecondaryAction className="ActionList" style={{ height: style.height - 1 }}>
        <IconButton edge="end" aria-label="Edit" className={classes.editButton} href="">
          <Icon type="edit" />
        </IconButton>
        <IconButton edge="end" aria-label="Delete" className={classes.deleteButton} href="">
          <Icon type="delete" />
        </IconButton>
      </ListItemSecondaryAction>
    </li>
  );
};

export default TableListItem;
