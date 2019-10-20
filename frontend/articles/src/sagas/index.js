import { all } from 'redux-saga/effects';
import articlesActionWatcher from './articlesSaga';
import ageCounterActionWatcher from './ageCounterSaga';

export default function* rootSaga() {
  yield all([
    ...ageCounterActionWatcher(),
    ...articlesActionWatcher()
  ]);
};
