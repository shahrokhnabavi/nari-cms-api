import React from 'react';
import {
  Inbox, Mail, Settings, HelpOutline, Dashboard, InfoOutlined, ChevronLeft, ChevronRight, Menu
} from "@material-ui/icons";

const Index = props => {
  const { type } = props;

  switch (type) {
    case 'mail':
      return <Mail />;
    case 'inbox':
      return <Inbox />;
    case 'dashboard':
      return <Dashboard />;
    case 'help':
      return <HelpOutline />;
    case 'settings':
      return <Settings />;
    case 'info':
      return <InfoOutlined />;
    case 'chevronLeft':
      return <ChevronLeft />;
    case 'chevronRight':
      return <ChevronRight />;
    case 'menu':
      return <Menu />;
    default:
      return ''
  }
};

export default Index;
