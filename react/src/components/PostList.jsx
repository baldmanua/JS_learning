import React from 'react';
import PostItem from "./PostItem";

const PostList = ({removePost, posts, ...props}) => {
  return (
    <div className='post_list'>
      <h1 style={{textAlign: 'center'}}>Posts</h1>
      {posts.map((post) => (
        <PostItem key={post.id} post={post} removePost={removePost}/>
      ))}
    </div>
  );
};

export default PostList;