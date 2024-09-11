import React from 'react';
import './styles/App.css'
import PostList from "./components/PostList";
import PostForm from "./components/PostForm";
import MySelect from "./components/UI/Select/MySelect";


function App() {

  const [posts, setPosts] = React.useState([
    {id: 1, title: "Post title", description: "Post description",},
    {id: 2, title: "Post title2", description: "Post description",},
    {id: 3, title: "Post title3", description: "Post description",},
  ]);

  const addNewPost = (post) => {
    setPosts([...posts, post]);
  }

  const removePost = (postId) => {
    console.log(postId);
    setPosts(posts.filter((post) => post.id !== postId));
  }

  return (
    <div className="App">
      <PostForm addNewPost={addNewPost}/>
      <MySelect options={[{value:'name', text:'By Name'}, {value:'desc', text:'By Description'}]} defaultValue={{value:'sort', text:'Sort by...'}}/>
      {posts && posts.length > 0
        ? <PostList posts={posts} removePost={removePost}/>
        : <h1 style={{textAlign: 'center'}}>No posts found</h1>
      }
    </div>
  );
}

export default App;
