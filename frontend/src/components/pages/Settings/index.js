import React from 'react';
import withTitle from '../../shared/withTitle';
import { makeStyles, Paper } from '@material-ui/core';

const useStyles = makeStyles(theme => ({
  pageRoot: {
    padding: theme.spacing(2),
    margin: theme.spacing(2),
  },
}));

const Settings = () => {
  const classes = useStyles();

  return (
    <Paper className={classes.pageRoot}>Settings</Paper>
  );
};

export default withTitle(Settings, 'Settings');
