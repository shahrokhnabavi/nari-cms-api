import React from 'react';
import * as Icons from '@material-ui/icons';

const mapIcons = {
  mail: Icons.Mail,
  inbox: Icons.Inbox,
  menu: Icons.Menu,
  dashboard: Icons.Dashboard,
  help: Icons.HelpOutline,
  settings: Icons.Settings,
  info: Icons.InfoOutlined,
  chevronRight: Icons.ChevronRight,
  chevronLeft: Icons.ChevronLeft,
};

const Icon = props => {
  const { type } = props;
  const Component = mapIcons[type] || '';

  if (Component === '') {
    return '';
  }

  return <Component />;
};

export default Icon;
