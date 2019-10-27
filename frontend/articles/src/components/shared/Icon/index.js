import React from 'react';
import * as Icons from '@material-ui/icons';
import PropTypes from 'prop-types';

const mapIcons = {
  mail: Icons.Mail,
  inbox: Icons.Inbox,
  menu: Icons.Menu,
  dashboard: Icons.Dashboard,
  help: Icons.HelpOutline,
  settings: Icons.Settings,
  info: Icons.InfoOutlined,
  chevron_right: Icons.ChevronRight,
  chevron_left: Icons.ChevronLeft,
  add: Icons.Add,
  edit: Icons.Edit,
  up: Icons.KeyboardArrowUp,
};

const Icon = props => {
  const { type } = props;

  if (!type) {
    return '';
  }
  const Component = mapIcons[type.toLowerCase()] || '';

  if (Component === '') {
    return '';
  }

  return <Component />;
};

Icon.propsTypes = {
  type: PropTypes.string.isRequired
};

export default Icon;
