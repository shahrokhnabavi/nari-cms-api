import React from 'react';
import { NavLink } from 'react-router-dom';
import './NavBar.css';

const NavBar = () => {
  return (
    <ul className="NavBar">
      <li><NavLink exact to="/">Home</NavLink></li>
      <li><NavLink exact to="/articles">Articles</NavLink></li>
      <li><NavLink to="/articles/add">Add Article</NavLink></li>
      <li><NavLink exact to="/age">Age Counter</NavLink></li>
      <li><NavLink to="/404">Not Found</NavLink></li>
    </ul>
  );
};

export default NavBar;
