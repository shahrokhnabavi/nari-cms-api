import { all } from 'redux-saga/effects';
import ArticlesSaga from './articlesSaga';
import AgeCounterSaga from './ageCounterSaga';

export default function* rootSaga() {
  yield all([
    AgeCounterSaga.ageUpActionWatcher(),
    AgeCounterSaga.ageDownActionWatcher(),
    ArticlesSaga.getArticlesActionWatcher()
  ]);
};
