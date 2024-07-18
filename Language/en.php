<?php
/************************************************|
|* Description | Language file - ENGLISH        *|
|************************************************/

  /* General */
 define('LANG', array(
  "username_or_password_is_invalid" => "Your username or password is invalid.",
  "login_btn" => "Login",

  // Hello.tpl
  "hello" => "Hello World!",
  "hello_installation_successful" => "NoobMVC installation successful!",
  "hello_message" => 
        "<p class='p-2'>This is the default view for the Hello controller. You can find it in the Views/Hello.tpl file.
        For more information on how to use NoobMVC, please visit the <a href='https://github.com/kurzejapatryk/NoobMVC/wiki'>NoobMVC website on Github</a>.</p>
        <p>Now, go ahead and create your own controllers and views!</p>",
  
  /* Months */
  "months" => [
    '01' => "January",
    '02' => "February",
    '03' => "March",
    '04' => "April",
    '05' => "May",
    '06' => "June",
    '07' => "July",
    '08' => "August",
    '09' => "September",
    '10' => "October",
    '11' => "November",
    '12' => "December",
    /* Short months */
    "Jan" => "JAN",
    "Feb" => "FEB",
    "Mar" => "MAR",
    "Apr" => "APR",
    "May" => "MAY",
    "Jun" => "JUN",
    "Jul" => "JUL",
    "Aug" => "AUG",
    "Sep" => "SEP",
    "Oct" => "OCT",
    "Nov" => "NOV",
    "Dec" => "DEC",
  ],


  /* Validation errors */
  "val_errors" => [
    "val_pattern" => "Invalid data format.",
    "val_required" => "This field is required.",
    "val_min" => "The value is too small.",
    "val_max" => "The value is too large.",
    "val_equal" => "The value should be equal to ",
    "val_file_max_size" => "The file is too large.",
    "val_file_ext" => "Invalid file format.",
  ],

  /* Error pages */
  "404" => "This page is not exist",
  "500" => "Internal server error"

));
