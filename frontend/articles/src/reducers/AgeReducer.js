import actions from '../actions';

const initialState = {
  age: 35,
  history: []
};

const AgeReducer = (state = initialState, action) => {
  const newState = {...state};

  if (action.type === actions.AGE_UP) {
    newState.age += action.value;
    newState.history = state.history.concat({
      log: `Age ${state.age} increased by ${action.value} and become ${newState.age}`,
      key: Math.random()
    });
  }

  if (action.type === actions.AGE_DOWN) {
    newState.age -= action.value;
    newState.history.push({
      log: `Age ${state.age} decreased by ${action.value} and become ${newState.age}`,
      key: Math.random()
    });
  }

  if (action.type === actions.REMOVE_ITEM_HISTORY) {
    newState.history = state.history.filter(el => el.key !== action.key)
  }

  return newState;
};

export default AgeReducer;
