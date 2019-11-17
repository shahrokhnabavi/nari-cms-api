import React from 'react';
import withTitle from '../../shared/withTitle';
import { makeStyles, Paper } from '@material-ui/core';

const useStyles = makeStyles(theme => ({
  pageRoot: {
    padding: theme.spacing(2),
    margin: theme.spacing(2),
  },
}));

const Help = () => {
  const classes = useStyles();

  return (
    <Paper className={classes.pageRoot}>Help</Paper>
  );
};

export default withTitle(Help, 'Help');
