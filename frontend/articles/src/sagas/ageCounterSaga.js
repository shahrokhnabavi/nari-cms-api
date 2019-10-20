import { takeLatest, put, delay } from 'redux-saga/effects';
import { AgeCounterAction } from '../actions';

const ageUpAsync = function* (action) {
  yield delay(3000);
  yield put({type: AgeCounterAction.AGE_UP_ASYNC, value: action.value});
};

const ageDownAsync = function* (action) {
  yield delay(2000);
  yield put({type: AgeCounterAction.AGE_DOWN_ASYNC, value: action.value});
};

function* ageUpActionWatcher() {
  yield takeLatest(AgeCounterAction.AGE_UP, ageUpAsync);
}

function* ageDownActionWatcher() {
  yield takeLatest(AgeCounterAction.AGE_DOWN, ageDownAsync);
}

export default {
  ageUpActionWatcher,
  ageDownActionWatcher
};
