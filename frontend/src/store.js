import { createStore, applyMiddleware, combineReducers } from 'redux';
import createSagaMiddleware from 'redux-saga';
import Reducers from './reducers';
import rootSaga  from './sagas';

const sagaMiddleware = createSagaMiddleware();

const store = createStore(
  combineReducers(Reducers),
  applyMiddleware(sagaMiddleware)
);

sagaMiddleware.run(rootSaga);

export default store;
