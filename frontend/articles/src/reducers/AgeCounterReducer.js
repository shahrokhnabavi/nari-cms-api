import { AgeCounterAction } from '../actions';

const initialState = {
  age: 35,
  history: [],
  loading: false
};

const AgeCounterReducer = (state = initialState, action) => {
  const newState = {...state};

  switch (action.type) {
    case AgeCounterAction.AGE_UP:
    case AgeCounterAction.AGE_DOWN:
      return {
        ...state,
        loading: true
      };
    case AgeCounterAction.AGE_UP_ASYNC:
      return {
        ...state,
        age: state.age + action.value,
        loading: false,
        history: state.history.concat({
          log: `Age ${state.age} increased by ${action.value} and become ${newState.age + action.value}`,
          key: Math.random()
        })
      };
    case AgeCounterAction.AGE_DOWN_ASYNC:
      return {
        ...state,
        age: state.age - action.value,
        loading: false,
        history: state.history.concat({
          log: `Age ${state.age} decreased by ${action.value} and become ${state.age - action.value}`,
          key: Math.random()
        })
      };
    case AgeCounterAction.REMOVE_ITEM_HISTORY:
      return {
        ...state,
        history: state.history.filter(el => el.key !== action.key)
      };
    default:
      return state;
  }
};

export default AgeCounterReducer;
