<%@ Page Language="C#" AutoEventWireup="true" CodeFile="PrintDIVContentusingjQuery.aspx.cs" Inherits="PrintDIVContentusingjQuery" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
<title>jQuery Print Particular DIV using jQuery Print Plugin</title>
 <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="jquery.print.js"></script>
<script type="text/javascript">
    $(function() {
    $("#hrefPrint").click(function() {
    // Print the DIV.
    $("#printdiv").print();
    return (false);
});
});
</script>
<style type="text/css">
body {
font-family: verdana ;
font-size: 14px ;
}
h1 {
font-size: 180% ;
}
h2 {
border-bottom: 1px solid #999999 ;
}
.printable {
border: 1px dotted #CCCCCC ;
padding: 10px 10px 10px 10px ;
}
img {
background-color: #E0E0E0 ;
border: 1px solid #666666 ;
padding: 5px 5px 5px 5px ;

}
a {
color: red ;
font-weight:bold;
}
</style>
</head>
<body>
<div style="margin-left:400px"><a href="#" id="hrefPrint">Print DIV</a></div>
<div id="printdiv" class="printable">
<h2>
Aspdotnet-Suresh.com

</h2>
<p>
Welcome to Aspdotnet-Suresh.com. It will provide many articles relating asp.net, c#, sql server, jquery, json etc...
</p>
<p>
<img src="AS.jpg" />
</p>
</div>
</body>
</html>