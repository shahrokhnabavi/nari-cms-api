import React from 'react';
import { connect } from 'react-redux';
import './App.css';
import actions from '../actions';

const App = props => {
  const value = Math.round(Math.random() * (6-1) + 1);

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

const mapStateToProps = state => ({age: state.age, history: state.history});

const mapDispatchToProps = dispatch => ({
  onAgeUp: stepUp => dispatch({type: actions.AGE_UP, value: stepUp}),
  onAgeDown: stepDow => dispatch({type: actions.AGE_DOWN, value: stepDow}),
  onRemoveItemHistory: id => dispatch({type: actions.REMOVE_ITEM_HISTORY, key: id})
});

export default connect(mapStateToProps, mapDispatchToProps)(App);
