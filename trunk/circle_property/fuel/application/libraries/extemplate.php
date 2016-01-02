<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class CI_exTemplate {
   
   var $CI;
   var $config;
   var $extemplate;
   var $master;
   var $regions = array(
      '_scripts' => array(),
      '_styles' => array(),
   );
   var $output;
   var $js = array();
   var $css = array();
   var $parser = 'parser';
   var $parser_method = 'parse';
   var $parse_extemplate = FALSE;
   
   /**
	 * Constructor
	 *
	 * Loads extemplate configuration, extemplate regions, and validates existence of 
	 * default extemplate
	 *
	 * @access	public
	 */
   
   function CI_exTemplate()
   {
      // Copy an instance of CI so we can use the entire framework.
      $this->CI =& get_instance();
      
      // Load the extemplate config file and setup our master extemplate and regions
      include(APPPATH.'config/extemplate'.EXT);
      if (isset($extemplate))
      {
         $this->config = $extemplate;
         $this->set_extemplate($extemplate['active_extemplate']);
      }
   }
   
   // --------------------------------------------------------------------
   
   /**
    * Use given extemplate settings
    *
    * @access  public
    * @param   string   array key to access extemplate settings
    * @return  void
    */
   
   function set_extemplate($group)
   {
      if (isset($this->config[$group]))
      {
         $this->extemplate = $this->config[$group];
      }
      else
      {
         show_error('The "'. $group .'" extemplate group does not exist. Provide a valid group name or add the group first.');
      }
      $this->initialize($this->extemplate);
   }
   
      // --------------------------------------------------------------------
   
   /**
    * Set master extemplate
    *
    * @access  public
    * @param   string   filename of new master extemplate file
    * @return  void
    */
   
   function set_master_extemplate($filename)
   {
      if (file_exists(APPPATH .'views/'. $filename) or file_exists(APPPATH .'views/'. $filename . EXT))
      {
         $this->master = $filename;
      }
      else
      {
         show_error('The filename provided does not exist in <strong>'. APPPATH .'views</strong>. Remember to include the extension if other than ".php"');
      }
   }
   
   // --------------------------------------------------------------------
   
   /**
    * Dynamically add a extemplate and optionally switch to it
    *
    * @access  public
    * @param   string   array key to access extemplate settings
    * @param   array properly formed
    * @return  void
    */
   
   function add_extemplate($group, $extemplate, $activate = FALSE)
   {
      if ( ! isset($this->config[$group]))
      {
         $this->config[$group] = $extemplate;
         if ($activate === TRUE)
         {
            $this->initialize($extemplate);
         }
      }
      else
      {
         show_error('The "'. $group .'" extemplate group already exists. Use a different group name.');
      }
   }
   
   // --------------------------------------------------------------------
   
   /**
    * Initialize class settings using config settings
    *
    * @access  public
    * @param   array   configuration array
    * @return  void
    */
   
   function initialize($props)
   {
      // Set master extemplate
      if (isset($props['extemplate']) 
         && (file_exists(APPPATH .'views/'. $props['extemplate']) or file_exists(APPPATH .'views/'. $props['extemplate'] . EXT)))
      {
         $this->master = $props['extemplate'];
      }
      else 
      {
         // Master extemplate must exist. Throw error.
         show_error('Either you have not provided a master extemplate or the one provided does not exist in <strong>'. APPPATH .'views</strong>. Remember to include the extension if other than ".php"');
      }
      
      // Load our regions
      if (isset($props['regions']))
      {
         $this->set_regions($props['regions']);
      }
      
      // Set parser and parser method
      if (isset($props['parser']))
      {
         $this->set_parser($props['parser']);
      }
      if (isset($props['parser_method']))
      {
         $this->set_parser_method($props['parser_method']);
      }
      
      // Set master extemplate parser instructions
      $this->parse_extemplate = isset($props['parse_extemplate']) ? $props['parse_extemplate'] : FALSE;
   }
   
   // --------------------------------------------------------------------
   
   /**
    * Set regions for writing to
    *
    * @access  public
    * @param   array   properly formed regions array
    * @return  void
    */
   
   function set_regions($regions)
   {
      if (count($regions))
      {
         $this->regions = array(
            '_scripts' => array(),
            '_styles' => array(),
         );
         foreach ($regions as $key => $region) 
         {
            // Regions must be arrays, but we take the burden off the extemplate 
            // developer and insure it here
            if ( ! is_array($region))
            {
               $this->add_region($region);
            }
            else {
               $this->add_region($key, $region);
            }
         }
      }
   }
   
   // --------------------------------------------------------------------
   
   /**
    * Dynamically add region to the currently set extemplate
    *
    * @access  public
    * @param   string   Name to identify the region
    * @param   array Optional array with region defaults
    * @return  void
    */
   
   function add_region($name, $props = array())
   {
      if ( ! is_array($props))
      {
         $props = array();
      }
      
      if ( ! isset($this->regions[$name]))
      {
         $this->regions[$name] = $props;
      }
      else
      {
         show_error('The "'. $name .'" region has already been defined.');
      }
   }
   
   // --------------------------------------------------------------------
   
   /**
    * Empty a region's content
    *
    * @access  public
    * @param   string   Name to identify the region
    * @return  void
    */
   
   function empty_region($name)
   {
      if (isset($this->regions[$name]['content']))
      {
         $this->regions[$name]['content'] = array();
      }
      else
      {
         show_error('The "'. $name .'" region is undefined.');
      }
   }
   
   // --------------------------------------------------------------------
   
   /**
    * Set parser
    *
    * @access  public
    * @param   string   name of parser class to load and use for parsing methods
    * @return  void
    */
   
   function set_parser($parser, $method = NULL)
   {
      $this->parser = $parser;
      $this->CI->load->library($parser);
      
      if ($method)
      {
         $this->set_parser_method($method);
      }
   }
   
   // --------------------------------------------------------------------
   
   /**
    * Set parser method
    *
    * @access  public
    * @param   string   name of parser class member function to call when parsing
    * @return  void
    */
   
   function set_parser_method($method)
   {
      $this->parser_method = $method;
   }

   // --------------------------------------------------------------------
   
   /**
	 * Write contents to a region
	 *
	 * @access	public
	 * @param	string	region to write to
	 * @param	string	what to write
	 * @param	boolean	FALSE to append to region, TRUE to overwrite region
	 * @return	void
	 */
   
   function write($region, $content, $overwrite = FALSE)
   {
       
      if (isset($this->regions[$region]))
      {
         if ($overwrite === TRUE) // Should we append the content or overwrite it
         {
            $this->regions[$region]['content'] = array($content);
         } else {
            $this->regions[$region]['content'][] = $content;
         }
      }
      
      // Regions MUST be defined
      else
      {
         
         show_error("Cannot write to the '{$region}' region. The region is undefined.");
         
      }
   }
   
   // --------------------------------------------------------------------
   
   /**
	 * Write content from a View to a region. 'Views within views'
	 *
	 * @access	public
	 * @param	string	region to write to
	 * @param	string	view file to use
	 * @param	array	variables to pass into view
	 * @param	boolean	FALSE to append to region, TRUE to overwrite region
	 * @return	void
	 */
   
   function write_view($region, $view, $data = NULL, $overwrite = FALSE)
   {
      $args = func_get_args();
      
      // Get rid of non-views
      unset($args[0], $args[2], $args[3]);
      
      // Do we have more view suggestions?
      if (count($args) > 1)
      {
         foreach ($args as $suggestion)
         {
            if (file_exists(APPPATH .'views/'. $suggestion . EXT) or file_exists(APPPATH .'views/'. $suggestion))
            {
               // Just change the $view arg so the rest of our method works as normal
               $view = $suggestion;
               break;
            }
         }
      }
      
      $content = $this->CI->load->view($view, $data, TRUE);
      $this->write($region, $content, $overwrite);

   }
   
   // --------------------------------------------------------------------
   
   /**
    * Parse content from a View to a region with the Parser Class
    *
    * @access  public
    * @param   string   region to write to
    * @param   string   view file to parse
    * @param   array variables to pass into view for parsing
    * @param   boolean  FALSE to append to region, TRUE to overwrite region
    * @return  void
    */
   
   function parse_view($region, $view, $data = NULL, $overwrite = FALSE)
   {
      $this->CI->load->library('parser');
      
      $args = func_get_args();
      
      // Get rid of non-views
      unset($args[0], $args[2], $args[3]);
      
      // Do we have more view suggestions?
      if (count($args) > 1)
      {
         foreach ($args as $suggestion)
         {
            if (file_exists(APPPATH .'views/'. $suggestion . EXT) or file_exists(APPPATH .'views/'. $suggestion))
            {
               // Just change the $view arg so the rest of our method works as normal
               $view = $suggestion;
               break;
            }
         }
      }
      
      $content = $this->CI->{$this->parser}->{$this->parser_method}($view, $data, TRUE);
      $this->write($region, $content, $overwrite);

   }

   // --------------------------------------------------------------------
   
   /**
    * Dynamically include javascript in the extemplate
    * 
    * NOTE: This function does NOT check for existence of .js file
    *
    * @access  public
    * @param   string   script to import or embed
    * @param   string  'import' to load external file or 'embed' to add as-is
    * @param   boolean  TRUE to use 'defer' attribute, FALSE to exclude it
    * @return  TRUE on success, FALSE otherwise
    */
   
   function add_js($script, $type = 'import', $defer = FALSE, $use_base = TRUE)
   {
      $success = TRUE;
      $js = NULL;
      
      $this->CI->load->helper('url');
      
      switch ($type)
      {
         case 'import':
            if($use_base)
            {
                $filepath = base_url() . $script;
            }
            else
            {
                $filepath = $script;
            }
            $js = '<script type="text/javascript" src="'. $filepath .'"';
            if ($defer)
            {
               $js .= ' defer="defer"';
            }
            $js .= "></script>";
            break;
         
         case 'embed':
            $js = '<script type="text/javascript"';
            if ($defer)
            {
               $js .= ' defer="defer"';
            }
            $js .= ">";
            $js .= $script;
            $js .= '</script>';
            break;
            
         default:
            $success = FALSE;
            break;
      }
      
      // Add to js array if it doesn't already exist
      if ($js != NULL && !in_array($js, $this->js))
      {
         $this->js[] = $js;
         $this->write('_scripts', $js);
      }
      
      return $success;
   }
   
   // --------------------------------------------------------------------
   
   /**
    * Dynamically include CSS in the extemplate
    * 
    * NOTE: This function does NOT check for existence of .css file
    *
    * @access  public
    * @param   string   CSS file to link, import or embed
    * @param   string  'link', 'import' or 'embed'
    * @param   string  media attribute to use with 'link' type only, FALSE for none
    * @return  TRUE on success, FALSE otherwise
    */
   
    function add_css($style, $type = 'link', $media = FALSE, $use_base = TRUE)
   {
      $success = TRUE;
      $css = NULL;
      
      $this->CI->load->helper('url');
      if ($use_base)
      {
        $filepath = base_url() . $style;
      }
      else
      {
          $filepath = $style;
      }
      
      switch ($type)
      {
         case 'link':
            
            $css = '<link type="text/css" rel="stylesheet" href="'. $filepath .'"';
            if ($media)
            {
               $css .= ' media="'. $media .'"';
            }
            $css .= ' />';
            break;
         
         case 'import':
            $css = '<style type="text/css">@import url('. $filepath .');</style>';
            break;
         
         case 'embed':
            $css = '<style type="text/css">';
            $css .= $style;
            $css .= '</style>';
            break;
            
         default:
            $success = FALSE;
            break;
      }
      
      // Add to js array if it doesn't already exist
      if ($css != NULL && !in_array($css, $this->css))
      {
         $this->css[] = $css;
         $this->write('_styles', $css);
      }
      
      return $success;
   }
      
   // --------------------------------------------------------------------
   
   /**
	 * Render the master extemplate or a single region
	 *
	 * @access	public
	 * @param	string	optionally opt to render a specific region
	 * @param	boolean	FALSE to output the rendered extemplate, TRUE to return as a string. Always TRUE when $region is supplied
	 * @return	void or string (result of extemplate build)
	 */
   
   function render($region = NULL, $buffer = FALSE, $parse = FALSE)
   {
      // Just render $region if supplied
      if ($region) // Display a specific regions contents
      {
         if (isset($this->regions[$region]))
         {
            $output = $this->_build_content($this->regions[$region]);
         }
         else
         {
            show_error("Cannot render the '{$region}' region. The region is undefined.");
         }
      }
      
      // Build the output array
      else
      {
         foreach ($this->regions as $name => $region)
         {
            $this->output[$name] = $this->_build_content($region);
         }
         
         if ($this->parse_extemplate === TRUE or $parse === TRUE)
         {
            // Use provided parser class and method to render the extemplate
            $output = $this->CI->{$this->parser}->{$this->parser_method}($this->master, $this->output, TRUE);
            
            // Parsers never handle output, but we need to mimick it in this case
            if ($buffer === FALSE)
            {
               $this->CI->output->set_output($output);
            }
         }
         else
         {
            // Use CI's loader class to render the extemplate with our output array
            $output = $this->CI->load->view($this->master, $this->output, $buffer);
         }
      }
      
      return $output;
   }
   
   // --------------------------------------------------------------------
   
   /**
    * Load the master extemplate or a single region
    *
    * DEPRECATED!
    * 
    * Use render() to compile and display your extemplate and regions
    */
    
    function load($region = NULL, $buffer = FALSE)
    {
       $region = NULL;
       $this->render($region, $buffer);
    }
   
   // --------------------------------------------------------------------
   
   /**
	 * Build a region from it's contents. Apply wrapper if provided
	 *
	 * @access	private
	 * @param	string	region to build
	 * @param	string	HTML element to wrap regions in; like '<div>'
	 * @param	array	Multidimensional array of HTML elements to apply to $wrapper
	 * @return	string	Output of region contents
	 */
   
   function _build_content($region, $wrapper = NULL, $attributes = NULL)
   {
      $output = NULL;
      
      // Can't build an empty region. Exit stage left
      if ( ! isset($region['content']) or ! count($region['content']))
      {
         return FALSE;
      }
      
      // Possibly overwrite wrapper and attributes
      if ($wrapper)
      {
         $region['wrapper'] = $wrapper;
      }
      if ($attributes)
      {
         $region['attributes'] = $attributes;
      }
      
      // Open the wrapper and add attributes
      if (isset($region['wrapper'])) 
      {
         // This just trims off the closing angle bracket. Like '<p>' to '<p'
         $output .= substr($region['wrapper'], 0, strlen($region['wrapper']) - 1);
         
         // Add HTML attributes
         if (isset($region['attributes']) && is_array($region['attributes']))
         {
            foreach ($region['attributes'] as $name => $value)
            {
               // We don't validate HTML attributes. Imagine someone using a custom XML extemplate..
               $output .= " $name=\"$value\"";
            }
         }
         
         $output .= ">";
      }
      
      // Output the content items.
      foreach ($region['content'] as $content)
      {
         $output .= $content;
      }
      
      // Close the wrapper tag
      if (isset($region['wrapper']))
      {
         // This just turns the wrapper into a closing tag. Like '<p>' to '</p>'
         $output .= str_replace('<', '</', $region['wrapper']) . "\n";
      }
      
      return $output;
   }
   
}
// END exTemplate Class

/* End of file exTemplate.php */
/* Location: ./system/application/libraries/exTemplate.php */