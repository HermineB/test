<footer></footer>


<div id="SignInModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Sign in</h4>
            </div>
            <div class="modal-body">
                <form action="#" method="post" id="registration_form" class="clearfix">
                    <!--                    <div id="uLogin" data-ulogin="display=panel;theme=classic;fields=first_name,last_name,email;providers=vkontakte,odnoklassniki,mailru,facebook;hidden=other;redirect_uri=http%3A%2F%2Fhermine.000webhostapp.com%2Ffunctions.php;mobilebuttons=0;"></div>-->
                    <input type="text" name="first_name" placeholder="First name" class="form-control" required/>
                    <input type="text" name="last_name" placeholder="Last name" class="form-control" required/>
                    <input type="email"  name="email"  placeholder="e-mail" class="form-control" required/>
                    <input type="password"  name="password"  placeholder="password" class="form-control" required/>
                    <input type="submit" id="registation_mail_button" class="btn btn-info btn-sm" value="Send mail" />
                </form>
            </div>
            <div class="modal-footer">
                <p id="sign_in_error"></p>
            </div>
        </div>

    </div>
</div>


<div id="LogInModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Log in</h4>
            </div>
            <div class="modal-body">
                <form action="#" method="post" class="clearfix">
                    <!--                    <div id="uLogin" data-ulogin="display=panel;theme=classic;fields=first_name,last_name,email;providers=vkontakte,odnoklassniki,mailru,facebook;hidden=other;redirect_uri=http%3A%2F%2Fhermine.000webhostapp.com%2Ffunctions.php;mobilebuttons=0;"></div>-->

                    <input type="email" placeholder="e-mail" class="form-control" name="email"/>
                    <input type="password" placeholder="password" class="form-control" name="password"/>
                    <input type="button" id="log_in_button" class="btn btn-success btn-sm" value="Log In" />
                </form>
            </div>
            <div class="modal-footer">
                <p id="login_error"></p>
            </div>
        </div>

    </div>
</div>


<script src="//ulogin.ru/js/ulogin.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/pnotify.custom.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>


</body>
</html>
