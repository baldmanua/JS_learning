import React from 'react';
import MyButton from "./UI/Button/MyButton";

const PostItem = ({post, removePost, ...props}) => {
  return (
    <div className='post' {...props}>
      <div className='post__id'>
        <h2>{post.id}</h2>
      </div>
      <div className='post__desc'>
        <strong>{post.title}</strong>
        <p>{post.description}</p>
      </div>
      <div className='post__btns'>
        <MyButton className='danger' onClick={() => removePost(post.id)}>Delete</MyButton>
        <MyButton>Edit</MyButton>
      </div>
    </div>
  );
};

export default PostItem;