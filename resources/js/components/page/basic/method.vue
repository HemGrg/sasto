<template>
  <div>
      <h1>This Method number: {{views}}</h1>
      <button @click="updateCounter(1)">Increase</button>
      <button @click="updateCounter(-1)">Decrease</button>
      <br>
      <br><br>
      <div v-for="(blog, i) in blogs" :key="i">
          <h1>{{blog.title}}</h1>
          <h2>{{blog.post}}</h2>
      </div>
      <br>
      <br>
      <br>
      <br>
      <div>
          <h1 v-if="showItem">Show this item is "showitem" is true"</h1>
          <h2 v-else>Show this item if "showitem" is false"</h2>
          <button @click="changeItem">change ShowItem</button>
      </div>
  </div>
</template>

<script>
export default {
    data(){
        return{
            views : 0,
            blogs: [],
            showItem: false
        }
    },
   methods: {
        updateCounter(number){
        this.views += number
    },
    changeItem(){
        this.showItem = !this.showItem
    }
   },
   //call the server to get the views of this blog post...
   created(){
       this.views = 100
       //get the blog post
       let posts = [{title: 'this is blog title', 'post' : 'this is the blog post', id: 1},
       {title: 'this is blog title1', 'post' : 'this is the blog post1', id: 2},
       {title: 'this is blog title2', 'post' : 'this is the blog post2', id: 3},
       {title: 'this is blog title3', 'post' : 'this is the blog post3', id: 4},
       ]
       this.blogs = posts
   }
}
</script>

<style>

</style>