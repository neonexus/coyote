<?
## header ##
## alias: head ##
## title       = No Title ##
## text       = #000000 ##
## bgcolor = #ffffff ##
## alink     = #00ff00 ##
## vlink     = #ff0000 ##
## link       = #ff0000 ##
## bg         = ##
## extjs    = false ##
?>
<html>
<head><title><?=$attribs['TITLE']?></title>
<?
if($attribs['EXTJS'] == "true")
	CoyoteProcessor::do_include('includes/ext_header.html');
echo $innerHTML;
?>
</head>
<body text="<?=$attribs['TEXT']?>" bgcolor="<?=$attribs['BGCOLOR']?>" bg="<?=$attribs['BG']?>" link="<?=$attribs['LINK']?>" vlink="<?=$attribs['VLINK']?>" alink="<?=$attribs['ALINK']?>">
