import React from 'react';
import classes from './MyButton.module.css'

const MyButton = ({children, className, ...props}) => {
  return (
    <button className={`${classes.MyBtn} ${className? classes[className]: ''}`} {...props}>{children}</button>
  );
};

export default MyButton;