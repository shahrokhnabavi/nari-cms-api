import { all } from 'redux-saga/effects';
import articlesActionWatcher from './articlesSaga';

export default function* rootSaga() {
  yield all([
    ...articlesActionWatcher()
  ]);
};
