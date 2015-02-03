<!DOCTYPE html>

<html>
<head>
  <link rel="stylesheet" type="text/css" media="all" href="<?= base_url() ?>css/reset.css"/>
  <link rel="stylesheet" type="text/css" media="all" href="<?= base_url() ?>css/loginpage.css"/>
</head>
<body>
  <div id="container">

    <div class='banner'>
      <img class='spImage' src="<?= base_url() ?>images/logo.png" height="auto" width="100%">
    </div>
    <img class='login' src="<?= base_url() ?>images/login.gif">
    <img class="loginImage" src="<?= base_url() ?>images/login_head.gif">
    <div class="centered">
      <?php
      if (isset($errorMsg)) {
          echo "<p>" . $errorMsg . "</p>";
      }
      echo form_open('account/login');
      ?>
      <ul>
        <li>
          <?php

          echo form_error('username');
          echo form_input(array(
          'name' => 'username',
          'value' => set_value('username'),
          'placeholder' => 'Username',
          'required' => 'required'

          ));
          ?>
        </li>

        <li>
          <?php
          echo form_error('password');
          echo form_password(array(
          'name' => 'password',
          'value' => '',
          'placeholder' => 'Password',
          'required' => 'required'

          ));
          ?>
        </li>

        <li>
          <input value="Log in" class="btnbg" type="submit">
          <h5>
            <?php
            echo anchor('account/recover_password', 'Forgot Password');
            ?>
          </h5>
        </li>

        <?php
        $attributes = array(
        'name' => 'submit',
        'style' => 'position: absolute; left: -9999px; width: 1px; height: 1px;'
        );
        ?>
        <?php
        echo form_submit($attributes, 'Login');
        ?>

      </ul>
      <?php
      echo form_close();
      ?>
    </div>
    <div class="background">
      <img src="<?= base_url() ?>images/photo-Cover.jpg">
    </div>
    <div class="footer">
      <section id="about">
        <h6>About</h6>
        <p>
            <!-- original
          Scarborough is a safe, well-educated and prosperous community.  The
          Storefront contributes to making the impossible possible by providing
          accessible sites for community members of all ages and cultures to find
          and share solutions they need to live healthy lives, find meaningful
          work, play and thrive. We are seen as an excellent model for
          sustainable social innovation and transformation in communities.
          -->
          The East Scarborough Storefront is a partnership of community members
          and services working together to create a thriving community in East
          Scarborough. This Calendar allows our partners to book Storefront
          spaces, such as offices and meeting rooms, in order to provide
          services to our great community. Together, we can make a difference!
        </p>
      </section>
      <section id="address">
        <h6>Contact Us</h6>
        <p>
          4040 Lawrence Ave E. <br />
          Scarborough, ON, M1E 2R2
        </p>
        <p> <b>Phone:</b> 416-208-9889 </p>
        <p> <b>Fax</b>: 416-208-9239 </p>
      </section>
      <!--
      <section id="links">
        <h6>Links</h6>
        <li><a href='http://www.thestorefront.org/'>
            East Scarborough Storefront -- Main Website
        </a></li>
        <li><a href='https://www.gifttool.com/donations/Donate?ID=2004&AID=1820'>
            Donate to the Storefront
        </a></li>
        <li><a href='http://www.thestorefront.org/events/'>
            Not a partner? You can see the Storefront's events here!
        </a></li> 
      </section>
      -->
      <div class=clear></div>
    </div>
  </div>
</body>
</html>
