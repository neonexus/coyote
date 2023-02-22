<?php

if(!defined('IN_COYOTE'))
    die("Can not access this file directly!");

/**
 * HTML/XML Parser Class
 *
 * This is a helper class that is used to parse HTML and XML. A unique feature of this parsing class 
 * is the fact that it includes support for innerHTML (which isn't easy to do).
 *
 * @author Dennis Pallett
 * @copyright Dennis Pallett 2006
 * @package HTML_Parser
 * @version 1.0
 */

// Helper Class
// To parse HTML/XML
Class CoyoteParser {
    // Private properties
    var $_parser;
    var $_tags = array();
    var $_html;
    var $output = array();
    var $strXmlData;
    var $_level = 0;
    var $_outline;
    var $_tagcount = array();
    var $xml_error = false;
    var $xml_error_code;
    var $xml_error_string;
    var $xml_error_line_number;

	function clear_mem(){
		unset($this->_parser, $this->_tags, $this->_html, $this->output, $this->strXmlData, $this->_level, $this->_outline, $this->_tagcount, $this->xml_error, $this->xml_error_code, $this->xml_error_string, $this->xml_error_line_number);
	}
	
    function get_html () {
        return $this->_html;
    }

    function parse($strInputXML) {
        $this->output = array();

        // Translate entities
        $strInputXML = $this->translate_entities($strInputXML);

        $this->_parser = xml_parser_create ();
        xml_parser_set_option($this->_parser, XML_OPTION_CASE_FOLDING, true);
        xml_set_object($this->_parser,$this);
        xml_set_element_handler($this->_parser, "tagOpen", "tagClosed");
          
        xml_set_character_data_handler($this->_parser, "tagData");
      
        $this->strXmlData = xml_parse($this->_parser,$strInputXML );

        if (!$this->strXmlData) {
            $this->xml_error = true;
            $this->xml_error_code = xml_get_error_code($this->_parser);
            $this->xml_error_string = xml_error_string(xml_get_error_code($this->_parser));
            $this->xml_error_line_number =  xml_get_current_line_number($this->_parser);
            return false;
        }
		unset($strInputXML);
		xml_parser_free($this->_parser);
        return $this->output;
    }
	
	function error_dump(){
		return '<strong>ERROR:</strong> ('.$this->xml_error_code.') <strong>'.$this->xml_error_string.'</strong> on line <strong>'.$this->xml_error_line_number.'</strong>';
	}

    function tagOpen($parser, $name, $attr) {
        // Increase level
        $this->_level++;

        // Create tag:
        //$newtag = $this->create_tag($name, $attr);

        // Build tag
        $tag = array('name'=>$name,'attr'=>$attr, 'level'=>$this->_level);

        // Add tag
        array_push ($this->output, $tag);

        // Add tag to this level
        $this->_tags[$this->_level] = $tag;

        // Add to HTML
        //$this->_html .= $newtag;

        // Add to outline
        //$this->_outline .= $this->_level . $newtag;
		unset($newtag, $tag, $parser, $name, $attr);
    }

    function create_tag ($name, $attr) {
        // Create tag:
        # Begin with name
        $tag = '<' . strtolower($name) . ' ';

        # Create attribute list
        foreach ($attr as $key=>$val) {
            $tag .= strtolower($key) . '="' . htmlentities($val) . '" ';
        }

        # Finish tag
        $tag = trim($tag);
        
        switch(strtolower($name)) {
            case 'br':
            case 'input':
                $tag .= ' /';
            break;
        }

        $tag .= '>';
		unset($name, $attr);
        return $tag;
    }

    function tagData($parser, $tagData) {
        if(trim($tagData)) {
            if(isset($this->output[count($this->output)-1]['tagData'])) {
                $this->output[count($this->output)-1]['tagData'] .= $tagData;
            } else {
                $this->output[count($this->output)-1]['tagData'] = $tagData;
            }
        }

        //$this->_html .= htmlentities($tagData);
        //$this->_outline .= htmlentities($tagData);
		unset($parser, $tagData);
    }
  
    function tagClosed($parser, $name) {
        // Add to HTML and outline
        /*switch (strtolower($name)) {
            case 'br':
            case 'input':
                break;
            default:
            $this->_outline .= $this->_level . '</' . strtolower($name) . '>';
            //$this->_html .= '</' . strtolower($name) . '>';
        }*/

        // Get tag that belongs to this end
        $tag = $this->_tags[$this->_level];
        $tag = $this->create_tag($tag['name'], $tag['attr']);

        // Try to get innerHTML
        //$regex = '%' . preg_quote($this->_level . $tag, '%') . '(.*?)' . preg_quote($this->_level . '</' . strtolower($name) . '>', '%') . '%is';
        //preg_match ($regex, $this->_outline, $matches);

        // Get innerHTML
        //if (isset($matches['1'])) {
            //$innerhtml = $matches['1'];
        //}
        
        // Remove level identifiers
        //$this->_outline = str_replace($this->_level . $tag, $tag, $this->_outline);
        //$this->_outline = str_replace($this->_level . '</' . strtolower($name) . '>', '</' . strtolower($name) . '>', $this->_outline);

        // Add innerHTML
        //if (isset($innerhtml)) {
            //$this->output[count($this->output)-1]['innerhtml'] = $innerhtml;
        //}

        // Fix tree
        $this->output[count($this->output)-2]['children'][] = $this->output[count($this->output)-1];
        array_pop($this->output);

        // Decrease level
        $this->_level--;
		unset($name, $parser, $tag, $regex, $innerhtml);
    }

    function translate_entities($xmlSource, $reverse =FALSE) {
        static $literal2NumericEntity;
        
        if (empty($literal2NumericEntity)) {
            $transTbl = get_html_translation_table(HTML_ENTITIES);

            foreach ($transTbl as $char => $entity) {
                if (strpos('&#038;"<>', $char) !== FALSE) continue;
                    $literal2NumericEntity[$entity] = '&#'.ord($char).';';
			}
		}

		if ($reverse) {
			return strtr($xmlSource, array_flip($literal2NumericEntity));
		} else {
			return strtr($xmlSource, $literal2NumericEntity);
		}
		
    }
}
//echo "<xmp>";
//$html = file_get_contents("test.txt");
// To be used like this
//$parser = new CyotParser;
//$output = $parser->parse($html);

//print_r ($output);
//echo "</xmp>";
?> 