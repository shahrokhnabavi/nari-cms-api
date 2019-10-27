import React from 'react';
import './style.css';

const Loading = props => {
  const speed = props.speed || 1;
  const size = props.size || 200;
  const thickness = props.thickness || 10;
  const primary = props.primary || '#cacbc5';
  const secondary = props.secondary || '#f3dcb2';

  return (
    <div className="ldsDoubleRing"
         style={
           {
             '--dual-ring-speed': `${speed}s`,
             '--dual-ring-size': `${size}px`,
             '--dual-ring-thickness': `${thickness}px`,
             '--dual-ring-primary-color': `${primary}`,
             '--dual-ring-secondary-color': `${secondary}`,
           }
         }
    >
      <div></div>
      <div></div>
    </div>
  );
};

export default Loading;
