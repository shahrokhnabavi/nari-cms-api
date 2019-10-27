import React from 'react';
import { BrowserRouter } from 'react-router-dom';
import { connect } from 'react-redux';
import { MuiThemeProvider } from '@material-ui/core';

import theme from './theme';
import useStyles from './style';
import conditionalCssClass from '../../util/conditionalCssClass';
import MainMenu from '../../components/AdminLayout/MainMenu';
import TopBar from '../../components/AdminLayout/TopBar';
import SwitchAdminRoutes from "../../components/pages/routes";

const AdminPanelLayout = props => {
  const classes = useStyles();
  const { isMenuOpen } = props;

  return (
    <MuiThemeProvider theme={theme}>
      <BrowserRouter>
        <div className={classes.root}>
          <TopBar />
          <MainMenu />

          <main className={conditionalCssClass(classes.content, [isMenuOpen, classes.contentShift])}>
            <div className={classes.contentTopPadding} />
            <SwitchAdminRoutes />
          </main>
        </div>
      </BrowserRouter>
    </MuiThemeProvider>
  );
};

const mapStoreToProps = state => ({
  isMenuOpen: state.AdminPanelLayoutReducer.isMenuOpen
});

export default connect(mapStoreToProps, null)(AdminPanelLayout);
