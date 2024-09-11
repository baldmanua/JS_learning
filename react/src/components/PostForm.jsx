import React from 'react';
import MyInput from "./UI/Input/MyInput";
import MyButton from "./UI/Button/MyButton";

const PostForm = ({addNewPost, ...props}) => {
  const [newPost, setNewPost] = React.useState({title: '', description: '',})


  const createPost = (e) => {
    e.preventDefault();
    addNewPost({id:Date.now(), ...newPost});
    setNewPost({title: '', description: '',});
  }

  return (
    <form {...props}>
      <MyInput placeholder="Name" value={newPost.title} onChange={e => setNewPost({...newPost, title: e.target.value})} />
      <MyInput placeholder="Description" value={newPost.description} onChange={e => setNewPost({...newPost, description: e.target.value})}/>
      <MyButton onClick={createPost}>Create</MyButton>
    </form>
  );
};

export default PostForm;