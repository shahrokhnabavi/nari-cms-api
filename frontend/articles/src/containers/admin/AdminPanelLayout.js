import React from 'react';

import useStyles from './AdminStyle';
import ContentRoute from './ContentRoute';
import MainMenu from '../../components/AdminLayout/MainMenu';
import TopBar from '../../components/AdminLayout/TopBar';

const AdminPanelLayout = () => {
  const classes = useStyles();

  return (
    <div className={classes.root}>
      <TopBar classes={classes}/>
      <MainMenu classes={classes} />
      <ContentRoute classes={classes} />
    </div>
  );
};

export default AdminPanelLayout;
