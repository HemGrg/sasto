 <!-- Left side column. contains the sidebar -->
 
 <aside class="main-sidebar" id="app">
            <!-- sidebar -->
            <div class="sidebar">
               <!-- sidebar menu -->
               <ul class="sidebar-menu">
                  <li class="active">
                  <router-link to="/dashboard"><i class="fa fa-tachometer"></i><span>Dashboard</span>
                     <span class="pull-right-container">
                     </span>
                     </router-link>
                  </li>
                  
                  <li class="treeview">
                     <a href="{{route('site-setting.index')}}">
                     <i class="fa fa-internet-explorer"></i><span>Site Setting</span>
                     <i class="fa fa-cogs pull-right"></i>
                     </a>
                  </li>

                  <li class="treeview">
                     <a href="#">
                     <i class="fa fa-sitemap"></i><span>Category</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>
                     <ul class="treeview-menu">
                        <li><a href="{{route('category.create')}}">Add Category</a></li>
                        <li><a href="{{route('category.index')}}">View Category</a></li>
                     </ul>
                  </li>

                  <li class="treeview">
                     <a href="">
                     <i class="fa fa-medkit"></i><span>Tags</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>
                  </li>
                  <li class="treeview">
                     <a href="#">
                     <i class="fa fa-medkit"></i><span>Admins</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>
                     <ul class="treeview-menu">
                        <li><a href="{{url('admin/add-admin')}}">Add Admin</a></li>
                        <li><a href="{{url('admin/view-admins')}}">View Admins</a></li>
                     </ul>
                  </li>         
               </ul>
            </div>
            <!-- /.sidebar -->
         </aside>
         <script src="{{asset('js/app.js')}}"></script>
         <!-- =============================================== -->