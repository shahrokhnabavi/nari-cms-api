import React from 'react';
import { BrowserRouter, Route, Switch } from 'react-router-dom'
import './App.css';
import AddArticleForm from '../components/form/AddArticleForm';
import NavBar from '../components/NavBar';

const App = () => {
  return (
    <BrowserRouter>
      <div className="App">
        <NavBar />
        <h1>Application Context</h1>
        <Switch>
          <Route exact path="/" component={() => (<div>Home</div>)} />
          <Route exact path="/article" component={AddArticleForm} />
          <Route path="/article/:id" component={() => (<div>one article</div>)} />
          <Route component={() => (<div>404</div>)} />
        </Switch>
      </div>
    </BrowserRouter>
  );
};

export default App;
