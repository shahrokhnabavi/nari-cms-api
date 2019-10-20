import { takeLatest, all, put, delay } from 'redux-saga/effects';
import * as actions from '../actions';

const ageUpAsync = function* (action) {
  yield delay(3000);
  yield put({type: actions.AGE_UP_ASYNC, value: action.value});
};

const ageDownAsync = function* (action) {
  yield delay(2000);
  yield put({type: actions.AGE_DOWN_ASYNC, value: action.value});
};

function* ageUpActionWatcher() {
  yield takeLatest(actions.AGE_UP, ageUpAsync);
}

function* ageDownActionWatcher() {
  yield takeLatest(actions.AGE_DOWN, ageDownAsync);
}

export default function* rootSaga() {
  yield all([
    ageUpActionWatcher(),
    ageDownActionWatcher()
  ]);
};
