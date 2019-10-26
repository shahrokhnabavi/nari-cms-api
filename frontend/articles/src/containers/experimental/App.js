import React from 'react';
import { BrowserRouter, Route, Switch } from 'react-router-dom'
import './App.css';

const App = () => {
  return (
    <BrowserRouter>
      <div className="App">
        <Switch>
          <Route exact path="/" component={() => (<div>Home</div>)} />
          <Route component={() => (<div>404</div>)} />
        </Switch>
      </div>
    </BrowserRouter>
  );
};

export default App;
