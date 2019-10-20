import React from 'react';
import { NavLink } from 'react-router-dom';
import './NavBar.css';

const checkActive = (match, location) => {
  if (!location) {
    return false;
  }

  const {pathname} = location;
  console.log(pathname);
  return pathname === "/";
};

const NavBar = () => {
  return (
    <ul className="NavBar">
      <li><NavLink exact to="/">Home</NavLink></li>
      <li><NavLink to="/article">Article</NavLink></li>
      <li><NavLink to="/404">Not Found</NavLink></li>
    </ul>
  );
};

export default NavBar;
