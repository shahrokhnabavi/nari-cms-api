import React from 'react';
import { BrowserRouter } from 'react-router-dom';
import { MuiThemeProvider, withStyles } from '@material-ui/core';

import { theme, styles } from '../../styles/muiAdminLayout';
import TopBar from '../../components/AdminLayout/TopBar';
import MainMenu from '../../components/AdminLayout/MainMenu';
import SwitchAdminRoutes from "../../components/pages/routes";

const AdminPanelLayout = props => {
  const { classes } = props;

  return (
    <MuiThemeProvider theme={theme}>
      <BrowserRouter>
        <div className={classes.root}>
          <TopBar />
          <MainMenu />

          <main className={classes.content}>
            <SwitchAdminRoutes />
          </main>
        </div>
      </BrowserRouter>
    </MuiThemeProvider>
  );
};

export default withStyles(
  theme => styles(theme, 'adminLayout')
)(AdminPanelLayout);
