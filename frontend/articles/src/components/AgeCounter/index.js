import React from 'react';
import * as actions from "../../actions";
import { connect } from "react-redux";
import './AgeCounter.css';

const AgeCounter = props => {
  const value = Math.round(Math.random() * (6 - 1) + 1);

  return (
    <header className="App-header">
      <p>
        Redux-Saga, click and wait 4 second
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
  );
};

const mapStoreToProps = state => ({age: state.age, history: state.history});

const mapDispatchToProps = {
  onAgeUp: actions.ageUp,
  onAgeDown: actions.ageDown,
  onRemoveItemHistory: actions.removeItemHistory
};

export default connect(mapStoreToProps, mapDispatchToProps)(AgeCounter);
