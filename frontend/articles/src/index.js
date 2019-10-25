import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';

import * as serviceWorker from './serviceWorker';
import './index.css';

import ContainerSwitch from './containers/ContainerSwitch';
import store from './store';

ReactDOM.render(
  <Provider store={store}>
    <ContainerSwitch container="admin" />
  </Provider>,
  document.getElementById('root')
);

serviceWorker.unregister();
