import actions from '../actions';

const initialState = {
  age: 35
};

const AgeReducer = (state = initialState, action) => {
  const newState = {...state};

  if (action.type === actions.AGE_UP.type) {
    newState.age++;
  }

  if (action.type === actions.AGE_DOWN.type) {
    newState.age--;
  }

  return newState;
};

export default AgeReducer;
