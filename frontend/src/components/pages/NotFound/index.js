import React from 'react';
import withTitle from '../../shared/withTitle';
import { makeStyles, Paper } from '@material-ui/core';

const useStyles = makeStyles(theme => ({
  pageRoot: {
    padding: theme.spacing(2),
    margin: theme.spacing(2),
  },
}));

const NotFound = () => {
  const classes = useStyles();

  return (
    <Paper className={classes.pageRoot}>404</Paper>
  );
};

export default withTitle(NotFound, 'Page not found');
