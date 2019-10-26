import React from 'react';
import { BrowserRouter, Route, Switch } from 'react-router-dom'
import './App.css';
import AgeCounter from '../../components/AgeCounter';
import NavBar from '../../components/NavBar';

const App = () => {
  return (
    <BrowserRouter>
      <div className="App">
        <NavBar />

        <Switch>
          <Route exact path="/" component={() => (<div>Home</div>)} />
          <Route exact path="/age" component={AgeCounter} />
          <Route component={() => (<div>404</div>)} />
        </Switch>
      </div>
    </BrowserRouter>
  );
};

export default App;
