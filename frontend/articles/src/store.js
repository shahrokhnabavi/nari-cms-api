import { createStore, applyMiddleware } from 'redux';
import createSagaMiddleware from 'redux-saga';
import AgeReducer from './reducers/AgeReducer';
import rootSaga  from './sagas';

const sagaMiddleware = createSagaMiddleware();

const store = createStore(AgeReducer, applyMiddleware(sagaMiddleware));

sagaMiddleware.run(rootSaga);

export default store;
