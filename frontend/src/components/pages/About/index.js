import React from 'react';
import withTitle from '../../shared/withTitle';
import { Paper, makeStyles } from '@material-ui/core';

const useStyles = makeStyles(theme => ({
  pageRoot: {
    padding: theme.spacing(2),
    margin: theme.spacing(2),
    backgroundColor: 'white'
  },
}));

const About = () => {
  const classes = useStyles();

  return (<Paper className={classes.pageRoot} >About</Paper>);
};

export default withTitle(About, 'About');
