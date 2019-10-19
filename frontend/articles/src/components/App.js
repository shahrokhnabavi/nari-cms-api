import React from 'react';
import { connect } from 'react-redux';
import './App.css';
import actions from '../actions';

const App = props => {
  return (
    <div className="App">
      <header className="App-header">
        <p>
          My Application
        </p>
        <h4>Age: <span>{props.age}</span></h4>
        <button onClick={props.onAgeUp}>Add</button>
        <button onClick={props.onAgeDown}>Subtract</button>
      </header>
    </div>
  );
};

const mapStateToProps = state => ({age: state.age});

const mapDispatchToProps = dispatch => ({
  onAgeUp: () => dispatch(actions.AGE_UP),
  onAgeDown: () => dispatch(actions.AGE_DOWN)
});

export default connect(mapStateToProps, mapDispatchToProps)(App);
