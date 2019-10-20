export const AGE_DOWN = 'AGE_DOWN';
export const AGE_UP = 'AGE_UP';
export const AGE_UP_ASYNC = 'AGE_UP_ASYNC';
export const AGE_DOWN_ASYNC = 'AGE_DOWN_ASYNC';
export const REMOVE_ITEM_HISTORY = 'REMOVE_ITEM_HISTORY';

export const ageUp = stepUp => ({
  type: AGE_UP,
  value: stepUp
});

export const ageDown = stepDown => ({
  type: AGE_DOWN,
  value: stepDown
});

export const removeItemHistory = id => ({
  type: REMOVE_ITEM_HISTORY,
  key: id
});
