import React from 'react';
import { BrowserRouter, Switch, Route } from 'react-router-dom';
import { connect }  from 'react-redux';

import useStyles from './AdminStyle';
import conditionalCssClass from '../../util/conditionalCssClass';
import MainMenu from '../../components/AdminLayout/MainMenu';
import TopBar from '../../components/AdminLayout/TopBar';

import ArticleList from '../../components/ArticleList';
import AddArticleForm from '../../components/form/AddArticleForm';
import Pages from '../../components/pages';


const AdminPanelLayout = props => {
  const classes = useStyles();
  const { isMenuOpen } = props;

  return (
    <BrowserRouter>
      <div className={classes.root}>
        <TopBar classes={classes} />
        <MainMenu classes={classes} />

        <main className={conditionalCssClass(classes.content, [isMenuOpen, classes.contentShift])}>
          <div className={classes.drawerHeader} />
          <Switch>
            <Route exact path="/" component={Pages.Dashboard} />
            <Route exact path="/articles" component={ArticleList} />
            <Route exact path="/articles/add" component={AddArticleForm} />
            <Route path="/article/:id" component={() => (<div>one article</div>)} />
            <Route path="/about" component={Pages.About} />
            <Route path="/help" component={Pages.Help} />
            <Route path="/settings" component={Pages.Settings} />
            <Route component={Pages.NotFound} />
          </Switch>
        </main>
      </div>
    </BrowserRouter>
  );
};

const mapStoreToProps = state => ({
  isMenuOpen: state.AdminPanelLayoutReducer.isMenuOpen
});

export default connect(mapStoreToProps, null)(AdminPanelLayout);
