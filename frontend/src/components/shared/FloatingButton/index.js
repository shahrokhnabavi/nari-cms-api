import React from 'react';
import { useTheme } from '@material-ui/core/styles';
import { Zoom, Fab } from '@material-ui/core';

import Icon from '../Icon';
import useStyles from './style';


const FloatingButton = props => {
  const { enter } = props;
  const classes = useStyles();
  const theme = useTheme();

  const transitionDuration = {
    enter: theme.transitions.duration.enteringScreen,
    exit: theme.transitions.duration.leavingScreen,
  };

  return (
    <Zoom
      in={enter}
      timeout={transitionDuration}
      style={{
        transitionDelay: `${enter ? transitionDuration.exit : 0}ms`,
      }}
      unmountOnExit
    >
      <Fab aria-label="Add" className={classes.fab} color="secondary">
        <Icon type="add" />
      </Fab>
    </Zoom>
  );
};

export default FloatingButton;
