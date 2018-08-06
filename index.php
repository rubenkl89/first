<?php

$link = mysqli_connect('localhost', 'ruben', 'IxklRlS4PYWZGwrG', 'oefen');
if (!$link) {die('Could not connect: ' . mysqli_connect_error());}
if (isset($_POST['submit']) && $_POST['submit'] == 'Submit')
{
  $person_id  = $_POST['person_id'];
  $name         = $_POST['name'];
  $ss              = $_POST['ss'];

  $query = "UPDATE persons
                   SET          name = '$name'
                                    ,ss = '$ss'
                   WHERE personID = $person_id";
  $result = mysqli_query($link, $query);
  if (mysqli_affected_rows($link) == 1) {
  $success_msg = '<P>The person has been updated.</P>';
  } else {
     error_log(mysqli_error($link));
     $success_msg = '<P>Something went wrong.</P>';
  }
} else {
  $person_id = $_GET['person_id'];
  $query = "SELECT name, ss
                    FROM persons
                    WHERE personID = $person_id";
  $result = mysqli_query($link, $query);
  $person_arr = mysqli_fetch_array($result);
  $name = stripslashes($person_arr[0]);
  $ss = stripslashes($person_arr[1]);
}

$thispage = "index.php"; //Have to do this for heredoc

$form_page = <<< EOFORMPAGE
<STYLE TYPE="text/css">
<!--
BODY, P        {color: black; font-family: verdana; font-size: 10 pt}
H1                 {color: black; font-family: arial; font-size: 12 pt}
-->
</STYLE>
</HEAD>

<BODY>
<TABLE BORDER=0 CELLPADDING=10 WIDTH=100%>
<TR>
<TD BGCOLOR="#F0F8FF" ALIGN=CENTER VALIGN=TOP WIDTH=17%>
</TD>
<TD BGCOLOR="#FFFFFF" ALIGN=LEFT VALIGN=TOP WIDTH=83%>
<H1>Comment edit</H1>

$success_msg
<FORM METHOD="post" ACTION="$thispage">
Naam: <INPUT TYPE="text" SIZE="40" NAME="name" VALUE="$name"><BR><BR>
SS-nummer: <INPUT TYPE="text" SIZE="40" NAME="ss" VALUE="$ss"><BR><BR>
<INPUT TYPE="hidden" NAME="person_id" VALUE="$person_id">
<INPUT TYPE="submit" NAME="submit" VALUE="Submit">
</FORM>

</TD></TR></TABLE>
</BODY>
</HTML>
EOFORMPAGE;
echo $form_page;
?>