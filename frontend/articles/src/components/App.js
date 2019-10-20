import React from 'react';
import { connect } from 'react-redux';
import './App.css';
import * as actions from '../actions';

const App = props => {
  const value = Math.round(Math.random() * (6 - 1) + 1);

  return (
    <div className="App">
      <header className="App-header">
        <p>
          My Application
        </p>
        <h4>Age: <span>{props.age}</span></h4>
        <div className="Button-Holder">
          <button onClick={() => props.onAgeUp(value)}>Add</button>
          <button onClick={() => props.onAgeDown(value)}>Subtract</button>
        </div>
        <div className="History">
          <ul>
            {
              props.history.map(el => {
                return (
                  <li onClick={() => props.onRemoveItemHistory(el.key)} key={el.key}>{el.log}</li>
                )
              })
            }
          </ul>
        </div>
      </header>
    </div>
  );
};

const mapStoreToProps = state => ({age: state.age, history: state.history});

const mapDispatchToProps = {
  onAgeUp: actions.ageUp,
  onAgeDown: actions.ageDown,
  onRemoveItemHistory: actions.removeItemHistory
};

export default connect(mapStoreToProps, mapDispatchToProps)(App);
