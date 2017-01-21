
<?php
require 'header.php';

if(!isset($_SESSION['user'])){


    header("location:index.php");
    exit;

}else{
    ?>
    <section class="main_content">

        <div class="container">
            <div class="jumbotron">
                <h1>Website Profile Page</h1>
                <p>Created by Hermine Baghdasaryan.</p>
            </div>
            <div class="row col-xs-10">
                <form class="form-group" id="polls_add"  action="#" method="post" >

                    <table class="table table-bordered col-xs-12" id="dynamic_field">
                        <tbody>
                        <tr>
                            <td colspan="2">
                                <input type="text" name="poll_title" placeholder="Poll title" class="form-control" required/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="poll_option[]" placeholder="Poll option" class="form-control" required/>
                            </td>
                            <td>
                                <button type="button" name="remove" class="btn btn-danger btn_remove">X</button>
                            </td>
                        </tr>
                        </tbody></table>

                    <div class="btn-group">
                        <button type="button" name="add" id="add" class="btn btn-success">+</button>
                        <button type="button"  class="btn btn-primary polls_add" >Submit</button>
                    </div>

                </form>

            </div>
            <div class="row col-xs-2">
                <form class="form-group" id="polls_edit"  action="#" method="post" >


                </form>

            </div>

        </div>

    </section>
    <?php
}
?>
<div id="edit_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content" id="gen_block">

        </div>

    </div>
</div>

<div id="delete_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">are you sure you want to delete  <span id="title_del_poll"></span> </h4>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-success delete_submit" id="delete_submit">Yes</button>
            </div>
        </div>

    </div>
</div>

<?php
require 'footer.php'
?>