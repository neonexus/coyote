<?
##php##
# DON'T EVER EVAL!!!!
# "IF YOU MUST USE EVAL, YOU ARE ASKING THE WRONG QUESTION..."
# Just use the built-in custom eval function "CoyoteProcessor::custom_eval($string)"

$innerHTML = "<?\n".$innerHTML."\n?>";
CoyoteProcessor::custom_eval($innerHTML);
?>