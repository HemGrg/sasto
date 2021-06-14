<template>
       <div class="table-responsive">
                            <table id="table_id" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr class="info">
                                        <th>SN</th>
                                        <th>Name</th>
                                        <th>Is Featured?</th>
                                        <th>Is Include In Main Menu?</th>
                                        <th>Does Contains Sub-Categories?</th>
                                        <th>Is Publish?</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>hari</td>
                                        <td>yes</td>
                                        <td>yes</td>
                                        <td>yes</td>
                                        <td>yes</td>
                                        <td>yes</td>
                                        <td>  <button type="submit" class="btn  btn-danger btn-delete" style="display:inline" title="Delete Service"><i class="fa fa-trash-o"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>          
</template>

<script>
 export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<style>

</style>