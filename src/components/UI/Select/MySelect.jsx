import React from 'react';

const MySelect = ({options, defaultValue, ...props}) => {
  return (
    <select {...props}>
      <option selected disabled value={defaultValue.value}>{defaultValue.text}</option>
      {options.map(option => <option key={option.value} value={option.value}>{option.text}</option>)}
    </select>
  );
};

export default MySelect;