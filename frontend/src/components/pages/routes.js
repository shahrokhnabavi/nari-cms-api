import React from 'react';
import { Switch, Route } from 'react-router-dom';

import Pages from "./index";
import AddArticleForm from "../form/AddArticleForm";

const SwitchAdminRoutes = () => {
  return (
    <Switch>
      <Route exact path="/" component={Pages.Dashboard} />
      <Route exact path="/articles" component={Pages.ArticleList} />
      <Route exact path="/articles/add" component={AddArticleForm} />
      <Route path="/article/:id" component={() => (<div>one article</div>)} />
      <Route path="/about" component={Pages.About} />
      <Route path="/help" component={Pages.Help} />
      <Route path="/settings" component={Pages.Settings} />
      <Route component={Pages.NotFound} />
    </Switch>
  );
};

export default SwitchAdminRoutes;
