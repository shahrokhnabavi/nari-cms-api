import adminLayout from './adminLayout';
import mainMenu from './mainMenu';
import appBar from './appBar';

const styleParts = {
  adminLayout,
  appBar,
  mainMenu
};

export default (theme, type) => {
  if (!(type in styleParts)) {
    return {};
  }

  return styleParts[type](theme);
};
