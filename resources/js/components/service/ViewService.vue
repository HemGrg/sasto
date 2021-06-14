<template>
  <div>
    <section class="content">
      <div class="row">
          @include('admin::admin.layouts._partials.messages.info')
        <div class="col-sm-12">
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group">
                <div class="buttonexport" id="buttonlist">
                  <a
                    class="btn btn-add"
                    data-toggle="modal"
                    data-target="#myModal"
                  >
                    <i class="fa fa-plus"></i> Add Category
                  </a>
                </div>
              </div>
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                <table
                  id="table_id"
                  class="table table-bordered table-striped table-hover"
                >
                  <thead>
                    <tr class="info">
                      <th>SN</th>
                      <th>Name</th>
                      <th>slug</th>
                      <th>image</th>
                      <th>Description</th>
                      <th>meta</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>name</td>
                      <td>slug</td>
                      <td>image</td>
                      <td>descriotion</td>
                      <td>meta description</td>
                      <td>
                        <a
                          href="#"
                          class="btn btn-add btn-sm"
                          title="Edit Service"
                          ><i class="fa fa-pencil"></i
                        ></a>
                        <a
                          href="#"
                          onclick="return confirm('Are you sure?')"
                          class="btn btn-danger btn-sm"
                          title="Delete Service"
                          ><i class="fa fa-trash-o"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-----------------------------------------------------------------------------------------------------------------
    ---------------------Adding Model------------------------------------------------------------------->
    <Model>
      <div class="modal fade in" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">×</span>
              </button>
              <h1 class="modal-title">Update Image</h1>
            </div>
            <div class="modal-body">
              <h2>sdjhbcsdbc dshcbdsjbc dsjhbdcs</h2>
              <div class="modal-footer">
                <input type="submit" class="btn btn-success" value="Udate" />
                <button
                  type="button"
                  class="btn btn-danger"
                  data-dismiss="modal"
                >
                  Close
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Model>
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: {
        name: "",
      },
    };
  },
};
</script>

<style>
</style>