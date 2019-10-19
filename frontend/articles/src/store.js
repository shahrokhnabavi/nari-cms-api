import { createStore } from 'redux';
import AgeReducer from './reducers/AgeReducer';

const store = createStore(AgeReducer);

export default store;
